<?php

namespace App\Http\Livewire;

use Illuminate\Database\Query\Expression;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

use App\Datatables\ColumnSet;

class LivewireDatatable extends Component
{
    use WithPagination;

    const SEPARATOR = '|**lwdt**|';
    public $model;
    public $columns;
    public $perPage = 10;
    public $include;
    public $exclude;

    protected $query;

    public function mount($model, $include = [], $exclude = [])
    {
        foreach (['model', 'include', 'exclude'] as $property) {
            $this->$property = $this->$property ?? $$property;
        }

        $this->columns = $this->getColumns();
    }

    public function builder()
    {
        return $this->model::query();
    }

    public function getColumns()
    {
        $columns = $this->processedColumns->columnsArray();

        return collect($columns)->map(function ($column) {
            return collect($column)->toArray();
        })->toArray();
    }

    public function getProcessedColumnsProperty()
    {
        return ColumnSet::build($this->model::firstOrFail())
            ->include($this->include)
            ->exclude($this->exclude);
    }

    public function resolveColumnName($column)
    {
        return $column->isBaseColumn()
            ? $this->query->getModel()->getTable() . '.' . ($column->base ?? Str::before($column->name, ':'))
            : $column->select ?? $this->resolveRelationColumn($column->base ?? $column->name, $column->aggregate);
    }

    public function getSelectStatements($withAlias = false)
    {
        $statement =  $this->processedColumns->columns
            ->reject(function ($column) {
                return $column->scope || $column->type === 'label';
            })->map(function ($column) {
                if ($column->select) {
                    return $column;
                }

                $column->select = $this->resolveColumnName($column);

                return $column;
            })->when($withAlias, function ($columns) {
                return $columns->map(function ($column) {
                     return $column->select . ' AS ' . $column->name;
                });
            });

            // dd($statement);
    }

    protected function resolveRelationColumn($name, $aggregate = null, $alias = null)
    {
        $parts = explode('.', Str::before($name, ':'));
        $columnName = array_pop($parts);
        $relation = implode('.', $parts);
        // dd($parts);
        return  method_exists($this->query->getModel(), $parts[0])
            ? $this->joinRelation($relation, $columnName, $aggregate, $alias ?? $name)
            : $name;
    }

    protected function joinRelation($relation, $relationColumn, $aggregate = null, $alias = null)
    {
        $table = '';
        $model = '';
        $lastQuery = $this->query;
        // dd($lastQuery);
        foreach (explode('.', $relation) as $eachRelation) {
            // dd($eachRelation);
            $model = $lastQuery->getRelation($eachRelation);
            dd($model);

            $table = $model->getRelated()->getTable();
            dd($table);
            $foreign = $model->getQualifiedForeignKeyName();
            $other = $model->getQualifiedOwnerKeyName();

            if ($table) {
                $joins = [];
                foreach ((array) $this->query->getQuery()->joins as $key => $join) {
                    $joins[] = $join->table;
                }

                if (! in_array($table, $joins)) {
                    $this->query->join($table, $foreign, '=', $other, 'left');
                }
            }
            $lastQuery = $model->getQuery();
        }

        return $table . '.' . $relationColumn;
    }

    public function getResultsProperty()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    public function buildDatabaseQuery()
    {
        $this->query = $this->builder();


        dd($this->getSelectStatements(true));
        $this->query->addSelect(
            $this->getSelectStatements(true)
            ->flatten()
            ->toArray()
        );

        // dd($this->query);
    }

    public function render()
    {
        return view('livewire.livewire-datatable');
    }

    public function getQuery($export = false)
    {
        $this->buildDatabaseQuery($export);

        return $this->query->toBase();
    }
}
