<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\SubjectsOfLearningCenter;
use Livewire\Component;
use Livewire\WithPagination;

class Subjects extends Component
{
    use WithPagination;

    public string $search = '';
    public ?int $centerFilter = null;
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?SubjectsOfLearningCenter $editingSubject = null;

    public array $form = [
        'name' => '',
        'description' => '',
        'price' => '',
        'duration' => '',
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
            'form.description' => 'nullable|string',
            'form.price' => 'nullable|numeric|min:0',
            'form.duration' => 'nullable|string|max:100',
            'form.learning_center_id' => 'required|exists:learning_centers,id',
        ]);

        SubjectsOfLearningCenter::create($this->form);

        $this->showCreateModal = false;
        $this->reset('form');
        session()->flash('message', 'Fan yaratildi.');
    }

    public function edit(int $id)
    {
        $this->editingSubject = SubjectsOfLearningCenter::findOrFail($id);
        $this->form = [
            'name' => $this->editingSubject->name,
            'description' => $this->editingSubject->description,
            'price' => $this->editingSubject->price,
            'duration' => $this->editingSubject->duration,
            'learning_center_id' => $this->editingSubject->learning_center_id,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.description' => 'nullable|string',
            'form.price' => 'nullable|numeric|min:0',
            'form.duration' => 'nullable|string|max:100',
            'form.learning_center_id' => 'required|exists:learning_centers,id',
        ]);

        $this->editingSubject->update($this->form);

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
        $query = SubjectsOfLearningCenter::with('learningCenter:id,name');

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if ($this->centerFilter) {
            $query->where('learning_center_id', $this->centerFilter);
        }

        $subjects = $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);

        $centers = LearningCenter::pluck('name', 'id');

        return view('livewire.admin.subjects', [
            'subjects' => $subjects,
            'centers' => $centers,
        ])->layout('layouts.admin.app', ['title' => 'Fanlar']);
    }
}
