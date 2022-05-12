<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class StudentExport implements FromQuery
{
    use Exportable;

    public function __construct($students)
    {
        $this->students = $students;
    }

    public function query()
    {
        return Student::query()->whereKey($this->students);
    }
}
