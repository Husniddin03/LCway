<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;

class Teachers extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $centerFilter = null;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?Teacher $editingTeacher = null;

    public array $form = [
        'name' => '',
        'phone' => '',
        'email' => '',
        'bio' => '',
        'learning_center_id' => '',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'centerFilter' => ['except' => ''],
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
        $this->showCreateModal = true;
    }

    public function store()
    {
        $validated = $this->validate([
            'form.name' => 'required|string|max:255',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email',
            'form.bio' => 'nullable|string',
            'form.learning_center_id' => 'required|exists:learning_centers,id',
        ]);

        Teacher::create($this->form);

        $this->showCreateModal = false;
        $this->reset('form');
        session()->flash('message', 'O\'qituvchi yaratildi.');
    }

    public function edit(int $id)
    {
        $this->editingTeacher = Teacher::findOrFail($id);
        $this->form = [
            'name' => $this->editingTeacher->name,
            'phone' => $this->editingTeacher->phone,
            'email' => $this->editingTeacher->email,
            'bio' => $this->editingTeacher->bio,
            'learning_center_id' => $this->editingTeacher->learning_center_id,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email',
            'form.bio' => 'nullable|string',
            'form.learning_center_id' => 'required|exists:learning_centers,id',
        ]);

        $this->editingTeacher->update($this->form);

        $this->showEditModal = false;
        $this->reset('form', 'editingTeacher');
        session()->flash('message', 'O\'qituvchi yangilandi.');
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
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->centerFilter) {
            $query->where('learning_center_id', $this->centerFilter);
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
