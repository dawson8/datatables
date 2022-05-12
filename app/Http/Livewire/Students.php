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
    public $search;
    public $selectedClass;
    // public $sections;
    // public $selectedSection;

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

    // TODO: We didn't set our database up like this because it made no sense
    // public function updatedSelectedClass($class_id)
    // {
    //     $this->sections = Section::where('class_id', $class_id)->get();
    // }

    public function render()
    {
        return view('livewire.students', [
            'students' => Student::with(['class', 'section'])
                ->when($this->selectedClass, function($query) {
                    $query->where('class_id', $this->selectedClass);
                })
                // ->when($this->selectedSection, function($query) {
                //     $query->where('section_id', $this->selectedSection);
                // })
                ->search(trim($this->search))
                ->paginate($this->paginate),
            'classes' => Classes::all()
        ]);
    }
}
