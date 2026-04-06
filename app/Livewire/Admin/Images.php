<?php

namespace App\Livewire\Admin;

use App\Models\LearningCentersImage;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Images extends Component
{
    use WithPagination;

    public $search = '';
    public $confirmingDelete = null;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function confirmDelete($imageId)
    {
        $this->confirmingDelete = $imageId;
    }

    public function delete($imageId)
    {
        $image = LearningCentersImage::findOrFail($imageId);
        
        // Delete file from storage
        if ($image->image && Storage::exists('public/' . $image->image)) {
            Storage::delete('public/' . $image->image);
        }
        
        $image->delete();
        
        $this->confirmingDelete = null;
        session()->flash('message', 'Rasm o\'chirildi.');
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = null;
    }

    public function render()
    {
        $images = LearningCentersImage::with('learningCenter')
            ->when($this->search, function ($query) {
                $query->whereHas('learningCenter', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate(24);

        $centers = \App\Models\LearningCenter::orderBy('name')
            ->pluck('name', 'id');

        return view('livewire.admin.images', [
            'images' => $images,
            'centers' => $centers,
        ])->layout('layouts.admin.app', ['title' => 'Rasmlar']);
    }
}
