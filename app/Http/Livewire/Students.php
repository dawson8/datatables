<?php

namespace App\Http\Livewire;

use App\Exports\StudentExport;
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
    public $selectPage;
    public $selectAll;
    public $sortBy = 'id';
    public $sortAsc = true;

    public function deleteRecords()
    {
        Student::whereKey($this->checked)->delete();
        $this->checked = [];

        // TODO: notifications in view
        session()->flash('info', 'Selected Records were deleted Successfully');
    }

    public function deleteSingleRecord(Student $student)
    {
        $this->checked = array_diff($this->checked, [$student->id]);

        $student->delete();

        // TODO: notifications in view
        session()->flash('info', 'Record was deleted Successfully');
    }

    public function isChecked($student_id)
    {
        return in_array($student_id, $this->checked);
    }

    public function exportSelected()
    {
        return (new StudentExport($this->checked))->download('students.xlsx');
    }

    public function updatedSelectPage($value)
    {
        if($value) {
            $this->checked = $this->students->pluck('id')->toArray();
        } else {
            $this->checked = [];
        }
    }

    public function getStudentsQueryProperty()
    {
        return Student::with(['class', 'section'])
            ->when($this->selectedClass, function($query) {
                $query->where('class_id', $this->selectedClass);
            })
            ->search(trim($this->search))
            ->orderBy($this->sortBy, $this->sortAsc ? 'ASC' : 'DESC');
    }

    public function getStudentsProperty()
    {
        return $this->studentsQuery
            ->paginate($this->paginate);
    }

    public function updatedChecked()
    {
        $this->selectPage = false;
    }

    public function selectAll()
    {
        $this->selectAll = true;
        $this->checked = $this->studentsQuery->pluck('id')->toArray();
    }

    public function sortBy($field)
    {
        if ($field === $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }

        $this->sortBy = $field;
    }

    public function render()
    {
        return view('livewire.students', [
            'students' => $this->students,
            'classes' => Classes::all()
        ]);
    }
}
