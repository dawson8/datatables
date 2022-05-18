<?php

namespace App\Datatables;

use Illuminate\Support\Collection;

class EloquentDatatable
{
    public $columns;

    public function __construct(Collection $columns)
    {
        $this->columns = $columns;
    }

    public static function build($columns)
    {
        // dd($columns);
        return new static(collect($columns));
    }
}
