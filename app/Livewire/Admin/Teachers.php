<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\Teacher;
use App\Models\SubjectsOfLearningCenter;
use App\Models\TeacherSubject;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Teachers extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public string $searchBy = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?Teacher $editingTeacher = null;

    public $teacherPhoto = null;
    public $teacherPhotoPreview = null;

    public array $form = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'bio' => '',
        'learning_centers_id' => '',
        'subject_id' => '',
        'subject_type' => '',
        'subject_icon' => '',
        'price' => '',
        'currency' => 'so\'m',
        'period' => '',
        'description' => '',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'searchBy' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
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
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = null;
        $this->editingTeacher = null;
        $this->showCreateModal = true;
    }

    public function updatedTeacherPhoto()
    {
        $this->validate([
            'teacherPhoto' => 'image|max:2048',
        ]);
        $this->teacherPhotoPreview = $this->teacherPhoto->temporaryUrl();
    }

    public function store()
    {
        $validated = $this->validate([
            'form.name' => 'required|string|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.email' => 'nullable|email',
            'form.bio' => 'nullable|string',
            'form.learning_centers_id' => 'required|exists:learning_centers,id',
            'form.subject_id' => 'nullable|exists:subjects_of_learning_centers,id',
            'form.subject_type' => 'nullable|string|max:255',
            'form.subject_icon' => 'nullable|string|max:255',
            'form.price' => 'nullable|integer',
            'form.currency' => 'nullable|string|max:50',
            'form.period' => 'nullable|string|max:50',
            'form.description' => 'nullable|string',
        ]);

        $teacherData = [
            'name' => $this->form['name'],
            'phone' => $this->form['phone'] ?: null,
            'email' => $this->form['email'] ?: null,
            'bio' => $this->form['bio'] ?: null,
            'learning_centers_id' => $this->form['learning_centers_id'],
        ];

        // Handle photo upload
        if ($this->teacherPhoto) {
            $path = $this->teacherPhoto->store('uploads/teachers', 'public');
            $teacherData['photo'] = $path;
        }

        $teacher = Teacher::create($teacherData);

        // Handle subject assignment
        if (!empty($this->form['subject_id'])) {
            TeacherSubject::create([
                'teacher_id' => $teacher->id,
                'subject_id' => $this->form['subject_id'],
                'subject_type' => $this->form['subject_type'] ?: null,
                'subject_icon' => $this->form['subject_icon'] ?: null,
                'price' => $this->form['price'] ?: null,
                'currency' => $this->form['currency'] ?: null,
                'period' => $this->form['period'] ?: null,
                'description' => $this->form['description'] ?: null,
            ]);
        }

        $this->showCreateModal = false;
        $this->reset('form', 'teacherPhoto', 'teacherPhotoPreview');
        session()->flash('message', 'O\'qituvchi qo\'shildi.');
    }

    public function edit(int $id)
    {
        $this->editingTeacher = Teacher::with('teacherSubjects.subject')->findOrFail($id);
        $teacherSubject = $this->editingTeacher->teacherSubjects->first();
        
        $this->teacherPhoto = null;
        $this->teacherPhotoPreview = $this->editingTeacher->photo ? asset('storage/' . $this->editingTeacher->photo) : null;
        
        $this->form = [
            'name' => $this->editingTeacher->name,
            'phone' => $this->editingTeacher->phone ?? '',
            'email' => $this->editingTeacher->email ?? '',
            'bio' => $this->editingTeacher->bio ?? '',
            'learning_centers_id' => $this->editingTeacher->learning_centers_id,
            'subject_id' => $teacherSubject?->subject_id ?? '',
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
            'form.name' => 'required|string|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.email' => 'nullable|email',
            'form.bio' => 'nullable|string',
            'form.learning_centers_id' => 'required|exists:learning_centers,id',
            'form.subject_id' => 'nullable|exists:subjects_of_learning_centers,id',
            'form.subject_type' => 'nullable|string|max:255',
            'form.subject_icon' => 'nullable|string|max:255',
            'form.price' => 'nullable|integer',
            'form.currency' => 'nullable|string|max:50',
            'form.period' => 'nullable|string|max:50',
            'form.description' => 'nullable|string',
        ]);

        $teacherData = [
            'name' => $this->form['name'],
            'phone' => $this->form['phone'] ?: null,
            'email' => $this->form['email'] ?: null,
            'bio' => $this->form['bio'] ?: null,
            'learning_centers_id' => $this->form['learning_centers_id'],
        ];

        // Handle photo upload
        if ($this->teacherPhoto) {
            $path = $this->teacherPhoto->store('uploads/teachers', 'public');
            $teacherData['photo'] = $path;
            
            // Delete old photo if exists
            if ($this->editingTeacher->photo) {
                if (\Storage::exists('public/' . $this->editingTeacher->photo)) {
                    \Storage::delete('public/' . $this->editingTeacher->photo);
                }
            }
        }

        $this->editingTeacher->update($teacherData);

        // Handle subject assignment
        if (!empty($this->form['subject_id'])) {
            TeacherSubject::updateOrCreate(
                ['teacher_id' => $this->editingTeacher->id],
                [
                    'subject_id' => $this->form['subject_id'],
                    'subject_type' => $this->form['subject_type'] ?: null,
                    'subject_icon' => $this->form['subject_icon'] ?: null,
                    'price' => $this->form['price'] ?: null,
                    'currency' => $this->form['currency'] ?: null,
                    'period' => $this->form['period'] ?: null,
                    'description' => $this->form['description'] ?: null,
                ]
            );
        } else {
            // Remove existing relation if no subject selected
            $this->editingTeacher->teacherSubjects()->delete();
        }

        $this->showEditModal = false;
        $this->reset('form', 'editingTeacher', 'teacherPhoto', 'teacherPhotoPreview');
        session()->flash('message', 'O\'qituvchi yangilandi.');
    }

    public function getCenterSubjects()
    {
        if (empty($this->form['learning_centers_id'])) {
            return collect();
        }
        return SubjectsOfLearningCenter::where('learning_centers_id', $this->form['learning_centers_id'])->get();
    }

    public function delete(int $id)
    {
        Teacher::findOrFail($id)->delete();
        session()->flash('message', 'O\'qituvchi o\'chirildi.');
    }

    public function render()
    {
        $query = Teacher::with('learningCenter:id,name');

        if ($this->search) {
            $query->when($this->searchBy === 'name' || empty($this->searchBy), function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->when($this->searchBy === 'phone', function ($q) {
                $q->where('phone', 'like', '%' . $this->search . '%');
            })
            ->when($this->searchBy === 'center', function ($q) {
                $q->whereHas('learningCenter', function ($lq) {
                    $lq->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        $teachers = $query->orderBy($this->sortField, $this->sortDirection)
                        ->paginate($this->perPage);

        $centers = LearningCenter::pluck('name', 'id');

        return view('livewire.admin.teachers', [
            'teachers' => $teachers,
            'centers' => $centers,
        ])->layout('layouts.admin.app', ['title' => 'O\'qituvchilar']);
    }
}
