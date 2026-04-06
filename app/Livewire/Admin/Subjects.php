<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\Teacher;
use App\Models\TeacherSubject;
use App\Models\SubjectsOfLearningCenter;
use Livewire\Component;
use Livewire\WithPagination;

class Subjects extends Component
{
    use WithPagination;

    public string $search = '';
    public string $searchBy = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?SubjectsOfLearningCenter $editingSubject = null;

    public array $form = [
        'subject_name' => '',
        'teacher_id' => '',
        'subject_type' => '',
        'subject_icon' => '',
        'price' => '',
        'currency' => 'so\'m',
        'period' => '',
        'description' => '',
        'learning_centers_id' => '',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'searchBy' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function getFilteredTeachers()
    {
        $centerId = $this->form['learning_centers_id'] ?? $this->centerFilter;
        if (empty($centerId)) {
            return Teacher::pluck('name', 'id');
        }
        return Teacher::where('learning_centers_id', $centerId)->pluck('name', 'id');
    }

    public function sortBy(string $field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function create()
    {
        $this->reset('form');
        $this->editingSubject = null;
        $this->showCreateModal = true;
    }

    public function store()
    {
        $validated = $this->validate([
            'form.subject_name' => 'required|string|max:255',
            'form.learning_centers_id' => 'required|exists:learning_centers,id',
            'form.teacher_id' => 'nullable|exists:teachers,id',
            'form.subject_type' => 'nullable|string|max:255',
            'form.subject_icon' => 'nullable|string|max:255',
            'form.price' => 'nullable|integer',
            'form.currency' => 'nullable|string|max:50',
            'form.period' => 'nullable|string|max:50',
            'form.description' => 'nullable|string',
        ]);

        $subject = SubjectsOfLearningCenter::create([
            'subject_name' => $this->form['subject_name'],
            'learning_centers_id' => $this->form['learning_centers_id'],
        ]);

        // Create teacher subject if teacher selected
        if (!empty($this->form['teacher_id'])) {
            TeacherSubject::create([
                'subject_id' => $subject->id,
                'teacher_id' => $this->form['teacher_id'],
                'subject_type' => $this->form['subject_type'] ?: null,
                'subject_icon' => $this->form['subject_icon'] ?: null,
                'price' => $this->form['price'] ?: null,
                'currency' => $this->form['currency'] ?: null,
                'period' => $this->form['period'] ?: null,
                'description' => $this->form['description'] ?: null,
            ]);
        }

        $this->showCreateModal = false;
        $this->reset('form');
        session()->flash('message', 'Fan qo\'shildi.');
    }

    public function edit(int $id)
    {
        $this->editingSubject = SubjectsOfLearningCenter::with(['teacherSubjects.teacher', 'learningCenter'])->findOrFail($id);
        $teacherSubject = $this->editingSubject->teacherSubjects->first();
        $this->form = [
            'subject_name' => $this->editingSubject->subject_name,
            'learning_centers_id' => $this->editingSubject->learning_centers_id,
            'teacher_id' => $teacherSubject?->teacher_id ?? '',
            'subject_type' => $teacherSubject?->subject_type ?? '',
            'subject_icon' => $teacherSubject?->subject_icon ?? '',
            'price' => $teacherSubject?->price ?? '',
            'currency' => $teacherSubject?->currency ?? 'so\'m',
            'period' => $teacherSubject?->period ?? '',
            'description' => $teacherSubject?->description ?? '',
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.subject_name' => 'required|string|max:255',
            'form.learning_centers_id' => 'required|exists:learning_centers,id',
            'form.teacher_id' => 'nullable|exists:teachers,id',
            'form.subject_type' => 'nullable|string|max:255',
            'form.subject_icon' => 'nullable|string|max:255',
            'form.price' => 'nullable|integer',
            'form.currency' => 'nullable|string|max:50',
            'form.period' => 'nullable|string|max:50',
            'form.description' => 'nullable|string',
        ]);

        $this->editingSubject->update([
            'subject_name' => $this->form['subject_name'],
            'learning_centers_id' => $this->form['learning_centers_id'],
        ]);

        // Update or create teacher subject
        if (!empty($this->form['teacher_id'])) {
            TeacherSubject::updateOrCreate(
                ['subject_id' => $this->editingSubject->id],
                [
                    'teacher_id' => $this->form['teacher_id'],
                    'subject_type' => $this->form['subject_type'] ?: null,
                    'subject_icon' => $this->form['subject_icon'] ?: null,
                    'price' => $this->form['price'] ?: null,
                    'currency' => $this->form['currency'] ?: null,
                    'period' => $this->form['period'] ?: null,
                    'description' => $this->form['description'] ?: null,
                ]
            );
        } else {
            // Remove existing relation if no teacher selected
            $this->editingSubject->teacherSubjects()->delete();
        }

        $this->showEditModal = false;
        $this->reset('form', 'editingSubject');
        session()->flash('message', 'Fan yangilandi.');
    }

    public function delete(int $id)
    {
        SubjectsOfLearningCenter::findOrFail($id)->delete();
        session()->flash('message', 'Fan o\'chirildi.');
    }

    public function render()
    {
        $query = SubjectsOfLearningCenter::with(['learningCenter:id,name', 'teacherSubjects.teacher']);

        if ($this->search) {
            $query->when($this->searchBy === '' || $this->searchBy === 'name', function ($q) {
                $q->where('subject_name', 'like', '%' . $this->search . '%');
            })
            ->when($this->searchBy === 'center', function ($q) {
                $q->whereHas('learningCenter', function ($lq) {
                    $lq->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->searchBy === 'teachers', function ($q) {
                $q->whereHas('teacherSubjects.teacher', function ($tq) {
                    $tq->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->searchBy === 'description', function ($q) {
                $q->whereHas('teacherSubjects', function ($tq) {
                    $tq->where('description', 'like', '%' . $this->search . '%');
                });
            });
        }

        $subjects = $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);

        $centers = LearningCenter::pluck('name', 'id');
        $teachers = $this->getFilteredTeachers();

        return view('livewire.admin.subjects', [
            'subjects' => $subjects,
            'centers' => $centers,
            'teachers' => $teachers,
        ])->layout('layouts.admin.app', ['title' => 'Fanlar']);
    }
}
