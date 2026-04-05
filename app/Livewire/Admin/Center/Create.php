<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\User;
use Livewire\Component;

class Create extends Component
{
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

    public function save()
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

        session()->flash('message', 'O\'quv markazi yaratildi.');
        return redirect()->route('admin.centers');
    }

    public function render()
    {
        $users = User::where('role', '!=', 'banned')->pluck('name', 'id');

        return view('livewire.admin.center.create', [
            'users' => $users,
        ])->layout('layouts.admin.app', ['title' => 'Yangi o\'quv markazi']);
    }
}
