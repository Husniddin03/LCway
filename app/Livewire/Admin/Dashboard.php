<?php

namespace App\Livewire\Admin;

use App\Models\Activity;
use App\Models\AiChat;
use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use App\Models\RiasecResult;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\User;
use App\Services\ActivityService;
use Carbon\Carbon;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $recentActivities = [];
    public array $contributionData = [];
    public int $selectedYear;

    protected $queryString = [
        'selectedYear' => ['except' => ''],
    ];

    public function mount()
    {
        $this->selectedYear = now()->year;
        $this->loadStats();
        $this->loadRecentActivities();
        $this->loadContributionData();
    }

    public function updatingSelectedYear()
    {
        $this->loadContributionData();
    }

    public function loadStats()
    {
        $this->stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('status', 'active')->count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'icon' => 'users',
                'color' => 'blue',
            ],
            'centers' => [
                'total' => LearningCenter::count(),
                'verified' => LearningCenter::where('checked', 1)->count(),
                'pending' => LearningCenter::where('checked', 0)->count(),
                'icon' => 'building',
                'color' => 'green',
            ],
            'teachers' => [
                'total' => Teacher::count(),
                'icon' => 'academic-cap',
                'color' => 'purple',
            ],
            'subjects' => [
                'total' => SubjectsOfLearningCenter::count(),
                'icon' => 'book-open',
                'color' => 'yellow',
            ],
            'comments' => [
                'total' => LearningCentersComment::count(),
                'pending' => LearningCentersComment::where('checked', 0)->count(),
                'icon' => 'chat',
                'color' => 'red',
            ],
            'ai_chats' => [
                'total' => AiChat::count(),
                'today' => AiChat::whereDate('created_at', today())->count(),
                'icon' => 'chip',
                'color' => 'indigo',
            ],
        ];
    }

    public function loadRecentActivities()
    {
        $this->recentActivities = Activity::latest()
            ->limit(10)
            ->get()
            ->map(function ($activity) {
                $colorMap = [
                    'user_created' => 'blue',
                    'center_created' => 'green',
                    'teacher_added' => 'purple',
                    'comment_added' => 'yellow',
                    'default' => 'gray',
                ];
                
                return [
                    'type' => $activity->type,
                    'title' => $activity->title,
                    'description' => $activity->description,
                    'time' => $activity->created_at->diffForHumans(),
                    'color' => $colorMap[$activity->type] ?? $colorMap['default'],
                ];
            })
            ->toArray();
    }

    public function loadContributionData()
    {
        $this->contributionData = ActivityService::getContributionDataForYear($this->selectedYear);
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'contributionData' => $this->contributionData,
            'selectedYear' => $this->selectedYear,
        ])->layout('layouts.admin.app', ['title' => 'Dashboard']);
    }
}
