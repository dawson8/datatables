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

    public $model;
    public $columns;
    public $perPage = 10;
    public $include;
    public $exclude;

    protected $query;

    public function mount($model, $include = [], $exclude = [])
    {
        $this->model = $model;
        $this->include = $include;
        $this->exclude = $exclude;
        $this->columns = $this->getColumns()->columnsArray();
    }

    public function builder()
    {
        return $this->model::query();
    }

    public function getColumns()
    {
        $columns = ColumnSet::build($this->model::firstOrFail())
            ->include($this->include)
            ->exclude($this->exclude);

        return($columns);
    }

    public function resolveColumnName($column)
    {
        return $column->isBaseColumn()
            ? $this->query->getModel()->getTable() . '.' . ($column->base ?? Str::before($column->name, ':'))
            : $column->select ?? $this->resolveRelationColumn($column->name);
    }

    protected function resolveRelationColumn($name)
    {
        $parts = explode('.', Str::before($name, ':'));
        $columnName = array_pop($parts);
        $relation = implode('.', $parts);

        $table = '';
        $model = '';
        $lastQuery = $this->query;

        foreach (explode('.', $relation) as $eachRelation) {
            $model = $lastQuery->getRelation($eachRelation);

            $table = $model->getRelated()->getTable();
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

        return $table . '.' . $columnName;
    }

    public function getResultsProperty()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.livewire-datatable');
    }

    public function getQuery()
    {
        $this->query = $this->builder();

        $this->query->addSelect(
            $this->getColumns()->columns
            ->map(function ($column) {
                return $this->resolveColumnName($column) . ' AS ' . $column->name;
            })
            ->flatten()
            ->toArray()
        );

        return $this->query->toBase();
    }
}
