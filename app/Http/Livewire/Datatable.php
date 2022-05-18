<?php

namespace App\Http\Livewire;

use App\Datatables\EloquentDatatable;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Datatable extends Component
{
    use WithPagination;

    public $model;
    public $include;
    public $columns;
    public $query;

    public function mount($model, $include = [])
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
        // $row = $this->builder()->firstOrFail();

        $include = collect(is_array($this->include)
            ? $this->include
            : array_map('trim', explode(',', $this->include)));
        // dd($include);
        // $test = collect([
        //     'name' => 'Desk',
        //     'price' => 100
        // ]);

        // dd($test);

        $columns = $include->map(function ($column) {
            return EloquentDatatable::build($column);
        });

        dd($columns);
        return $columns;

        // return collect(array_keys($row->getAttributes()))
        //     ->reject(function ($column) use ($row) {
        //         return in_array($column, $row->getHidden());
        //     }
        // );
    }
    // $column->label = (string) Str::of($name)->after('.')->ucfirst()->replace('_', ' ');
    // public function isBaseColumn()
    // {
    //     return ! Str::startsWith($this->name, 'callback_') && ! Str::contains($this->name, '.') && ! $this->raw;
    // }

    public function resolveColumnName($column)
    {
        $name = Str::after(Str::before($column, '|'), '.');
        $model = Str::after($column, '|');

        return Str::title($model . ' ' . $name);
    }

    public function records()
    {
        dd($this->builder()->paginate(10));
    }

    public function render()
    {
        return view('livewire.datatable');
    }
}
