<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use App\Models\User;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public LearningCenter $center;

    public $logoFile = null;

    public array $form = [
        'logo' => '',
        'name' => '',
        'type' => '',
        'about' => '',
        'country' => '',
        'province' => '',
        'region' => '',
        'address' => '',
        'location' => '',
        'status' => 'active',
        'users_id' => '',
        'student_count' => 0,
        'rating' => null,
        'checked' => false,
        'premium' => false,
        'premium_until' => null,
        'tin' => '',
        'legal_address' => '',
        'territory' => '',
        'license_number' => '',
        'license_registration_date' => '',
        'license_validity_period' => '',
        'manager_name' => '',
        'phone_number' => '',
        'email' => '',
        'ifut_code' => '',
    ];

    public function mount(LearningCenter $center)
    {
        $this->center = $center;
        $this->form = [
            'logo' => $center->logo,
            'name' => $center->name,
            'type' => $center->type,
            'about' => $center->about,
            'country' => $center->country,
            'province' => $center->province,
            'region' => $center->region,
            'address' => $center->address,
            'location' => $center->location,
            'status' => $center->status,
            'users_id' => $center->users_id,
            'student_count' => $center->student_count,
            'rating' => $center->rating,
            'checked' => $center->checked,
            'premium' => $center->premium,
            'premium_until' => $center->premium_until?->format('Y-m-d'),
            'tin' => $center->tin ?? '',
            'legal_address' => $center->legal_address ?? '',
            'territory' => $center->territory ?? '',
            'license_number' => $center->license_number ?? '',
            'license_registration_date' => $center->license_registration_date ? \Carbon\Carbon::parse($center->license_registration_date)->format('Y-m-d') : '',
            'license_validity_period' => $center->license_validity_period ? \Carbon\Carbon::parse($center->license_validity_period)->format('Y-m-d') : '',
            'manager_name' => $center->manager_name ?? '',
            'phone_number' => $center->phone_number ?? '',
            'email' => $center->email ?? '',
            'ifut_code' => $center->ifut_code ?? '',
        ];
    }

    public function update()
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
            'form.status' => 'required|in:active,inactive',
            'form.users_id' => 'required|exists:users,id',
            'form.student_count' => 'nullable|integer|min:0',
            'form.rating' => 'nullable|numeric|min:0|max:5',
            'form.checked' => 'boolean',
            'form.premium' => 'boolean',
            'form.premium_until' => 'nullable|date',
            'form.tin' => 'nullable|string|max:20',
            'form.legal_address' => 'nullable|string',
            'form.territory' => 'nullable|string|max:255',
            'form.license_number' => 'nullable|string|max:255',
            'form.license_registration_date' => 'nullable|date',
            'form.license_validity_period' => 'nullable|date',
            'form.manager_name' => 'nullable|string|max:255',
            'form.phone_number' => 'nullable|string|max:50',
            'form.email' => 'nullable|email|max:255',
            'form.ifut_code' => 'nullable|string|max:255',
        ]);

        // Handle logo upload with optimization
        if ($this->logoFile) {
            $imageService = new ImageOptimizationService();
            
            // Delete old logo if exists (check both webp and original extensions)
            if ($this->center->logo) {
                $oldPath = $this->center->logo;
                $oldPathWebp = preg_replace('/\.[^.]+$/', '.webp', $oldPath);
                
                if (Storage::exists('public/' . $oldPath)) {
                    Storage::delete('public/' . $oldPath);
                }
                if (Storage::exists('public/' . $oldPathWebp) && $oldPathWebp !== $oldPath) {
                    Storage::delete('public/' . $oldPathWebp);
                }
            }
            
            // Optimize and store new logo
            $path = $imageService->optimizeImage($this->logoFile, 'uploads/2');
            $this->form['logo'] = $path;
            $this->logoFile = null;
        }

        // Remove empty premium_until to avoid null issues
        if (empty($this->form['premium_until'])) {
            $this->form['premium_until'] = null;
        }

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
