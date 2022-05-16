<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Datatable extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $exclude;
    public $paginate = 10;
    public $checked = [];

    protected $query;

    public function mount($model, $include = [], $exclude = [])
    {
        // $this->model = $model;
        $this->exclude = is_array($exclude)
            ? $exclude
            : array_map('trim', explode(',', $exclude));

        if ($include) {
            $this->include($include);
        } else {
            $this->columns = $this->columns();
        }
    }

    public function builder()
    {
        return $this->model::query();
    }

    public function columns()
    {
        $item = $this->model::firstOrFail();

        return collect($item->getAttributes())->keys()
            ->reject(function ($name) use ($item) {
                return in_array($name, $item->getHidden())
                    || in_array($name, $this->exclude);
            });
    }

    public function resolveColumnName($column)
    {
        return ! Str::contains($column, '.')
            ? $this->query->getModel()->getTable() . '.' . ($column ?? Str::before($column, ':'))
            : $this->resolveRelationColumn($column);
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

    public function records()
    {
        $this->query = $this->builder();

        $this->query->addSelect(
            $this->columns->map(function ($column) {
                return $this->resolveColumnName($column) . ' AS ' . $column;
            })
            ->toArray()
        );

        return $this->query->paginate($this->paginate);
    }

    public function include($include)
    {
        if (! $include) {
            return $this;
        }

        $include = collect(is_array($include)
            ? $include
            : array_map('trim', explode(',', $include)));

        $this->columns = $include->map(function ($column) {
            return Str::contains($column, '|') ? Str::before($column, '|') : $column;
        });

        return $this;
    }








    protected function checkedRecords()
    {
        // return $this->builder()->whereIn('id', $this->checked);
    }

    public function isChecked($record)
    {
        return in_array($record->id, $this->checked);
    }

    public function deleteChecked()
    {
        // $this->checkedRecords()->delete();
        $this->checked = [];
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
