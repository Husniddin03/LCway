<?php

namespace App\View\Components;

use App\Models\LearningCenter;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * Create a new component instance.
     */

    public $LearningCenters;
    public function __construct()
    {
        $this->LearningCenters = LearningCenter::all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout', [
            'LearningCentersLayout' => $this->LearningCenters,
        ]);
    }
}
