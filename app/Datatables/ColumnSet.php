<?php

namespace App\Datatables;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ColumnSet
{
    public $columns;

    public function __construct(Collection $columns)
    {
        $this->columns = $columns;
    }

    public static function build($model)
    {
        return new static(
            collect($model->getAttributes())->keys()->reject(function ($name) use ($model) {
                return in_array($name, $model->getHidden());
            })->map(function ($attribute) {
                return Column::name($attribute);
            })
        );
    }

    public function include($include)
    {
        if (! $include) {
            return $this;
        }

        $include = collect(is_array($include) ? $include : array_map('trim', explode(',', $include)));
       
        $this->columns = $include->map(function ($column) {
            return Str::contains($column, '|')
                ? Column::name(Str::before($column, '|'))->label(Str::after($column, '|'))
                : Column::name($column);
        });

        return $this;
    }

    public function exclude($exclude)
    {
        if (! $exclude) {
            return $this;
        }

        $exclude = is_array($exclude) ? $exclude : array_map('trim', explode(',', $exclude));

        $this->columns = $this->columns->reject(function ($column) use ($exclude) {
            return in_array(Str::after($column->name, '.'), $exclude);
        });

        return $this;
    }


    public function columnsArray()
    {
        return collect($this->columns)->map->toArray();
    }
}
