<?php

namespace App\Livewire\Admin\Center;

use App\Models\LearningCenter;
use Livewire\Component;

class Show extends Component
{
    public LearningCenter $center;

    public function mount(LearningCenter $center)
    {
        $this->center = $center->loadCount(['teachers', 'subjects', 'comments', 'images']);
    }

    public function render()
    {
        return view('livewire.admin.center.show', [
            'center' => $this->center,
        ])->layout('layouts.admin.app', ['title' => $this->center->name]);
    }
}
