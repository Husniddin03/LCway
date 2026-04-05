<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Users extends Component
{
    use WithPagination;

    public string $search = '';
    public string $role = '';
    public string $status = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';
    public int $perPage = 20;

    public bool $showCreateModal = false;
    public bool $showEditModal = false;
    public ?User $editingUser = null;

    public array $form = [
        'name' => '',
        'email' => '',
        'password' => '',
        'role' => 'user',
        'status' => 'active',
    ];

    protected $queryString = [
        'search' => ['except' => ''],
        'role' => ['except' => ''],
        'status' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
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
        $this->form['role'] = 'user';
        $this->form['status'] = 'active';
        $this->showCreateModal = true;
    }

    public function store()
    {
        $validated = $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|unique:users,email',
            'form.password' => 'required|min:8',
            'form.role' => 'required|in:user,admin,moderator',
            'form.status' => 'required|in:active,inactive,banned',
        ]);

        User::create([
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'password' => bcrypt($this->form['password']),
            'role' => $this->form['role'],
            'status' => $this->form['status'],
        ]);

        $this->showCreateModal = false;
        $this->reset('form');
        session()->flash('message', 'Foydalanuvchi yaratildi.');
    }

    public function edit(int $id)
    {
        $this->editingUser = User::findOrFail($id);
        $this->form = [
            'name' => $this->editingUser->name,
            'email' => $this->editingUser->email,
            'password' => '',
            'role' => $this->editingUser->role,
            'status' => $this->editingUser->status,
        ];
        $this->showEditModal = true;
    }

    public function update()
    {
        $rules = [
            'form.name' => 'required|string|max:255',
            'form.email' => 'required|email|unique:users,email,' . $this->editingUser->id,
            'form.role' => 'required|in:user,admin,moderator',
            'form.status' => 'required|in:active,inactive,banned',
        ];

        if (!empty($this->form['password'])) {
            $rules['form.password'] = 'min:8';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->form['name'],
            'email' => $this->form['email'],
            'role' => $this->form['role'],
            'status' => $this->form['status'],
        ];

        if (!empty($this->form['password'])) {
            $data['password'] = bcrypt($this->form['password']);
        }

        $this->editingUser->update($data);

        $this->showEditModal = false;
        $this->reset('form', 'editingUser');
        session()->flash('message', 'Foydalanuvchi yangilandi.');
    }

    public function toggleStatus(int $id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        session()->flash('message', 'Status yangilandi.');
    }

    public function delete(int $id)
    {
        if (auth()->id() === $id) {
            session()->flash('error', 'O\'zingizni o\'chira olmaysiz.');
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('message', 'Foydalanuvchi o\'chirildi.');
    }

    public function render()
    {
        $query = User::query();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->role) {
            $query->where('role', $this->role);
        }

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $users = $query->orderBy($this->sortField, $this->sortDirection)
                       ->paginate($this->perPage);

        return view('livewire.admin.users', [
            'users' => $users,
        ])->layout('layouts.admin.app', ['title' => 'Foydalanuvchilar']);
    }
}
