<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'tailwind';

    public string $search = '';
    public string $status = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
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

    public function toggleVerification(int $id)
    {
        $center = LearningCenter::findOrFail($id);
        $center->checked = !$center->checked;
        $center->save();
        session()->flash('message', 'Tasdiqlash holati o\'zgartirildi.');
    }

    public function togglePremium(int $id)
    {
        $center = LearningCenter::findOrFail($id);
        $center->premium = !$center->premium;
        if ($center->premium && !$center->premium_until) {
            $center->premium_until = now()->addMonth();
        }
        $center->save();
        session()->flash('message', 'Premium holati o\'zgartirildi.');
    }

    public function delete(int $id)
    {
        LearningCenter::findOrFail($id)->delete();
        session()->flash('message', 'O\'quv markazi o\'chirildi.');
    }

    public function render()
    {
        $query = LearningCenter::with('user:id,name');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->status === 'verified') {
            $query->where('checked', true);
        } elseif ($this->status === 'pending') {
            $query->where('checked', false);
        } elseif ($this->status === 'premium') {
            $query->where('premium', true);
        }

        $centers = $query->orderBy($this->sortField, $this->sortDirection)
                         ->paginate($this->perPage);

        return view('livewire.admin.center.index', [
            'centers' => $centers,
        ])->layout('layouts.admin.app', ['title' => 'O\'quv markazlari']);
    }
}
