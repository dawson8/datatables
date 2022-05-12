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
    public $checked = [];

    public function deleteRecords()
    {
        Student::whereKey($this->checked)->delete();
        $this->checked = [];

        // TODO: notifications in view
        session()->flash('info', 'Selected Records were deleted Successfully');
    }

    public function deleteSingleRecord(Student $student)
    {
        $student->delete();
        
        // TODO: notifications in view
        session()->flash('info', 'Record was deleted Successfully');
    }

    public function isChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function render()
    {
        return view('livewire.students', [
            'students' => Student::with(['class', 'section'])->paginate($this->paginate),
            'classes' => Classes::all()
        ]);
    }
}
