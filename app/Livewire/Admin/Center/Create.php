<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\User;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $logoFile = null;

    public array $form = [
        'logo' => '',
        'name' => '',
        'type' => "O'quv markaz",
        'about' => '',
        'country' => '',
        'province' => '',
        'region' => '',
        'address' => '',
        'location' => '',
        'phone' => '',
        'email' => '',
        'users_id' => '',
        'checked' => false,
        'premium' => false,
        'tin' => '',
        'legal_address' => '',
        'territory' => '',
        'license_number' => '',
        'license_registration_date' => '',
        'license_validity_period' => '',
        'manager_name' => '',
        'phone_number' => '',
        'ifut_code' => '',
    ];

    public function save()
    {
        $validated = $this->validate([
            'logoFile' => 'nullable|image|max:2048',
            'form.name' => 'required|string|max:255',
            'form.type' => 'required|string|max:100',
            'form.about' => 'required|string',
            'form.country' => 'required|string|max:100',
            'form.province' => 'required|string|max:100',
            'form.region' => 'required|string|max:100',
            'form.address' => 'required|string|max:500',
            'form.location' => 'nullable|string|max:100',
            'form.phone' => 'required|string|max:20',
            'form.email' => 'nullable|email',
            'form.users_id' => 'required|exists:users,id',
            'form.checked' => 'boolean',
            'form.premium' => 'boolean',
            'form.tin' => 'nullable|string|max:20',
            'form.legal_address' => 'nullable|string',
            'form.territory' => 'nullable|string|max:255',
            'form.license_number' => 'nullable|string|max:255',
            'form.license_registration_date' => 'nullable|date',
            'form.license_validity_period' => 'nullable|date',
            'form.manager_name' => 'nullable|string|max:255',
            'form.phone_number' => 'nullable|string|max:50',
            'form.ifut_code' => 'nullable|string|max:255',
        ]);

        // Handle logo upload with optimization
        if ($this->logoFile) {
            $imageService = new ImageOptimizationService();
            $path = $imageService->optimizeImage($this->logoFile, 'uploads/2');
            $this->form['logo'] = $path;
            $this->logoFile = null;
        }

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
