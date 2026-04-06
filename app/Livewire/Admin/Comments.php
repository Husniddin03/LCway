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
    public string $searchBy = '';
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
        'searchBy' => ['except' => ''],
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
            $query->when($this->searchBy === '' || $this->searchBy === 'comment', function ($q) {
                $q->where('comment', 'like', '%' . $this->search . '%');
            })
            ->when($this->searchBy === 'user', function ($q) {
                $q->whereHas('user', function ($uq) {
                    $uq->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->searchBy === 'center', function ($q) {
                $q->whereHas('learningCenter', function ($lq) {
                    $lq->where('name', 'like', '%' . $this->search . '%');
                });
            });
        }

        if ($this->status === 'approved') {
            $query->where('checked', true);
        } elseif ($this->status === 'pending') {
            $query->where('checked', false);
        }

        $comments = $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);

        // Get favorites count for each learning center
        $centerIds = $comments->pluck('learning_centers_id')->unique()->toArray();
        $favoritesCount = \App\Models\Favorite::whereIn('learning_centers_id', $centerIds)
            ->selectRaw('learning_centers_id, COUNT(*) as count')
            ->groupBy('learning_centers_id')
            ->pluck('count', 'learning_centers_id');

        return view('livewire.admin.comments', [
            'comments' => $comments,
            'favoritesCount' => $favoritesCount,
        ])->layout('layouts.admin.app', ['title' => 'Izohlar']);
    }
}
