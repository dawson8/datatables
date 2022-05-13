<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Schema;
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
        // $this->model->getTable()
        // dd($this->model);
        $model = new \App\Models\User;
        $table = $model->getTable();
        $columns = Schema::getColumnListing($table);
        dd($columns);

        dd(Schema::getColumnListing($this->builder()->getQuery()->from));
        return collect(Schema::getColumnListing($this->builder()->getQuery()->from))
            ->reject(function($column) {
                return in_array($column, $this->exclude);
            })->toArray();
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

    public function records()
    {
        $builder = $this->builder();

        if ($this->query) {
            $builder = $builder->search($this->query);
        }

        return $builder->paginate($this->paginate);
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
