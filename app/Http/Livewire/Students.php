<?php

namespace App\Http\Livewire;

use App\Models\Classes;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Students extends Component
{
    use WithPagination;

    public $paginate = 10;

    public function render()
    {
        return view('livewire.students', [
            'students' => Student::with(['class', 'section'])->paginate($this->paginate),
            'classes' => Classes::all()
        ]);
    }
}
