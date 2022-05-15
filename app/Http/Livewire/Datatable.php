<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $exclude;
    public $paginate = 10;
    public $checked = [];
    public $query;

    public function mount($model, $exclude = '')
    {
        $this->model = $model;
        $this->exclude = explode(',', $exclude);
        $this->columns = $this->columns();
    }

    public function builder()
    {
        return new $this->model;
    }

    public function columns()
    {
        $item = $this->builder()->where('id', 1)->first();

        $columns = collect(array_keys($item->getAttributes()))
            ->reject(fn ($column) => in_array($column, $this->exclude));

        // $columns->push('test');

        return $columns->toArray();

        // dd($columns);
    }

    public function records()
    {
        $lastQuery = $this->builder()
            ->when($this->query, fn ($builder) => $builder->search($this->query))
            ->join('classes', 'students.class_id', '=', 'classes.id', 'left')
            ->paginate($this->paginate)->flatten();
        dd($lastQuery);
        // foreach (explode('.', $relation) as $eachRelation) {
        $model = $lastQuery->getRelation('class');

        $table = $model->getRelated()->getTable();
        $foreign = $model->getQualifiedForeignKeyName();
        $other = $model->getQualifiedOwnerKeyName();

        dd($table);
        // return $this->builder()
        //     ->when($this->query, fn ($builder) => $builder->search($this->query))
        //     ->join('classes', 'students.class_id', '=', 'classes.id', 'left')
        //     ->paginate($this->paginate);
    }

    protected function checkedRecords()
    {
        return $this->builder()->whereIn('id', $this->checked);
    }

    public function isChecked($record)
    {
        return in_array($record->id, $this->checked);
    }

    public function deleteChecked()
    {
        $this->checkedRecords()->delete();
        $this->checked = [];
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
