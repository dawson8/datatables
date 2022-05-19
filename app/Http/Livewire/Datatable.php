<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    public $model;
    public $columns;
    public $query;

    public function mount($model)
    {
        $this->model = $model;
        $this->columns = $this->columns();
    }

    public function builder()
    {
        return new $this->model;
    }

    public function columns()
    {
        $columns =  collect($this->builder()
            ->firstOrFail()
            ->getAttributes())
            ->keys()
            ->map(function ($item) {
                return $item . ' nice';
            })->reject(function ($column) {
                    return in_array($column, $this->builder()->getHidden());
                }
            );

        dd($columns);
        // dd($columnSet);
    }

    public function records()
    {
        return $this->builder()->paginate(10);
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
