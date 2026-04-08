<?php

namespace App\Livewire\Admin;

use App\Models\LearningCenter;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Centers extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;
    public string $searchTin = '';
    public string $searchLicense = '';
    public string $searchManager = '';

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?LearningCenter $editingCenter = null;

    public array $form = [
        'name' => '',
        'description' => '',
        'address' => '',
        'phone' => '',
        'email' => '',
        'users_id' => '',
        'checked' => false,
        'premium' => false,
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'searchTin' => ['except' => ''],
        'searchLicense' => ['except' => ''],
        'searchManager' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSearchTin()
    {
        $this->resetPage();
    }

    public function updatingSearchLicense()
    {
        $this->resetPage();
    }

    public function updatingSearchManager()
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
        $this->form['checked'] = false;
        $this->form['premium'] = false;
        $this->showCreateModal = true;
    }

    public function store()
    {
        $validated = $this->validate([
            'form.name' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.address' => 'required|string|max:500',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email',
            'form.users_id' => 'required|exists:users,id',
            'form.checked' => 'boolean',
            'form.premium' => 'boolean',
        ]);

        LearningCenter::create($this->form);

        $this->showCreateModal = false;
        $this->reset('form');
        session()->flash('message', 'O\'quv markazi yaratildi.');
    }

    public function edit(int $id)
    {
        $this->editingCenter = LearningCenter::findOrFail($id);
        $this->form = [
            'name' => $this->editingCenter->name,
            'description' => $this->editingCenter->description,
            'address' => $this->editingCenter->address,
            'phone' => $this->editingCenter->phone,
            'email' => $this->editingCenter->email,
            'users_id' => $this->editingCenter->users_id,
            'checked' => $this->editingCenter->checked,
            'premium' => $this->editingCenter->premium,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.description' => 'required|string',
            'form.address' => 'required|string|max:500',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email',
            'form.users_id' => 'required|exists:users,id',
            'form.checked' => 'boolean',
            'form.premium' => 'boolean',
        ]);

        $this->editingCenter->update($this->form);

        $this->showEditModal = false;
        $this->reset('form', 'editingCenter');
        session()->flash('message', 'O\'quv markazi yangilandi.');
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
                  ->orWhere('address', 'like', '%' . $this->search . '%')
                  ->orWhere('legal_address', 'like', '%' . $this->search . '%')
                  ->orWhere('territory', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->searchTin) {
            $query->where('tin', 'like', '%' . $this->searchTin . '%');
        }

        if ($this->searchLicense) {
            $query->where('license_number', 'like', '%' . $this->searchLicense . '%');
        }

        if ($this->searchManager) {
            $query->where('manager_name', 'like', '%' . $this->searchManager . '%');
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

        $users = User::where('role', '!=', 'banned')->pluck('name', 'id');

        return view('livewire.admin.center.index', [
            'centers' => $centers,
            'users' => $users,
        ])->layout('layouts.admin.app', ['title' => 'O\'quv markazlari']);
    }
}
