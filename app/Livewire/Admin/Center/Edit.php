<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\User;
use Livewire\Component;

class Edit extends Component
{
    public LearningCenter $center;

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

    public function mount(LearningCenter $center)
    {
        $this->center = $center;
        $this->form = [
            'name' => $center->name,
            'description' => $center->description,
            'address' => $center->address,
            'phone' => $center->phone,
            'email' => $center->email,
            'users_id' => $center->users_id,
            'checked' => $center->checked,
            'premium' => $center->premium,
        ];
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

        $this->center->update($this->form);

        session()->flash('message', 'O\'quv markazi yangilandi.');
        return redirect()->route('admin.centers');
    }

    public function render()
    {
        $users = User::where('role', '!=', 'banned')->pluck('name', 'id');

        return view('livewire.admin.center.edit', [
            'users' => $users,
        ])->layout('layouts.admin.app', ['title' => 'O\'quv markazini tahrirlash']);
    }
}
