<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use Livewire\Component;
use Livewire\WithPagination;

class Comments extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showEditModal = false;
    public ?LearningCentersComment $editingComment = null;

    public array $form = [
        'comment' => '',
        'rating' => 5,
        'checked' => false,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
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

    public function approve(int $id)
    {
        $comment = LearningCentersComment::findOrFail($id);
        $comment->checked = true;
        $comment->save();
        session()->flash('message', 'Izoh tasdiqlandi.');
    }

    public function reject(int $id)
    {
        $comment = LearningCentersComment::findOrFail($id);
        $comment->checked = false;
        $comment->save();
        session()->flash('message', 'Izoh rad etildi.');
    }

    public function edit(int $id)
    {
        $this->editingComment = LearningCentersComment::findOrFail($id);
        $this->form = [
            'comment' => $this->editingComment->comment,
            'rating' => $this->editingComment->rating,
            'checked' => $this->editingComment->checked,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.comment' => 'required|string',
            'form.rating' => 'required|integer|min:1|max:5',
            'form.checked' => 'boolean',
        ]);

        $this->editingComment->update($this->form);

        $this->showEditModal = false;
        $this->reset('form', 'editingComment');
        session()->flash('message', 'Izoh yangilandi.');
    }

    public function delete(int $id)
    {
        LearningCentersComment::findOrFail($id)->delete();
        session()->flash('message', 'Izoh o\'chirildi.');
    }

    public function render()
    {
        $query = LearningCentersComment::with(['user:id,name', 'learningCenter:id,name']);

        if ($this->search) {
            $query->where('comment', 'like', '%' . $this->search . '%');
        }

        if ($this->status === 'approved') {
            $query->where('checked', true);
        } elseif ($this->status === 'pending') {
            $query->where('checked', false);
        }

        $comments = $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);

        return view('livewire.admin.comments', [
            'comments' => $comments,
        ])->layout('layouts.admin.app', ['title' => 'Izohlar']);
    }
}
