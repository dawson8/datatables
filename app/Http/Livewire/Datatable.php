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
    public $paginate = 2;
    public $checked = [];

    protected $query;

    public function mount($model, $include = [], $exclude = [])
    {
        $this->model = $model; 
        
        $this->columns = $this->columns();
        $this->include($include);
        $this->exclude($exclude);
    }

    public function builder()
    {
        return $this->model::query();
    }

    public function columns()
    {
        $item = $this->builder()->firstOrFail();

        // $columns = collect(array_keys($item->getAttributes()));
        $columns = collect($item->getAttributes())->keys()->reject(function ($name) use ($item) {
            return in_array($name, $item->getHidden());
        });
            // ->$this->exclude();
            // ->reject($this->exclude);

        return $columns;
    }

    public function records()
    {
        // dd($this->columns);
        return $this->builder()->addSelect(
            $this->columns()->map(function ($column) {
                dd($column);
                return $column . ' AS ' . $column;
            })
            ->flatten()
            ->toArray()
        )->paginate($this->paginate);
    }

    public function include($include)
    {
        if (! $include) {
            return $this;
        }

        $include = collect(is_array($include) 
            ? $include 
            : array_map('trim', explode(',', $include)));

        // Replace existing columns
        $this->columns = $include->map(function ($column) {
            return Str::contains($column, '|')
                ? Str::before($column, '|')
                : $column;
        });
        
        // Add to existing columns - not quite there yet
        // $this->columns = $this->columns->push($include->map(function ($column) {
        //     return Str::contains($column, '|')
        //         ? Str::before($column, '|')
        //         : $column;
        // }));

        return $this;
    }

    public function exclude($exclude)
    {
        if (! $exclude) {
            return $this;
        }

        $exclude = is_array($exclude) 
            ? $exclude 
            : array_map('trim', explode(',', $exclude));

        $this->columns = $this->columns->reject(function ($column) use ($exclude) {
            return in_array(Str::after($column, '.'), $exclude);
        });

        return $this;
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
