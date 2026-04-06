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
