<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Schema;
use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    public $model;
    // public $table;
    public $columns;

    public function mount($model)
    {
        $this->model = $model;
        // $this->table = $this->builder()->getTable();
        // dd($this->table);
        $this->columns = $this->columns();
    }

    public function builder()
    {
        return new $this->model;
    }

    public function columns()
    {
        return collect($this->builder()->firstOrFail()->getAttributes())
            ->keys()
            ->reject(function ($column) {
                return in_array($column, $this->builder()->getHidden());
            });
    }

    // public function getProcessedColumnsProperty()
    // {
    //     return ColumnSet::build($this->columns())
    //         ->include($this->include)
    //         ->exclude($this->exclude)
    //         ->hide($this->hide)
    //         ->formatDates($this->dates)
    //         ->formatTimes($this->times)
    //         ->search($this->searchable)
    //         ->sort($this->sort);
    // }

    public function records()
    {
        return $this->builder()->paginate(10);
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
