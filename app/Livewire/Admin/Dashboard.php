<?php

namespace App\Livewire\Admin;

use App\Models\AiChat;
use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use App\Models\RiasecResult;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public array $stats = [];
    public array $recentActivities = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivities();
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
        $activities = [];

        // Recent users
        $recentUsers = User::latest()->limit(5)->get(['id', 'name', 'created_at']);
        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user',
                'title' => 'Yangi foydalanuvchi',
                'description' => $user->name,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user-add',
                'color' => 'blue',
            ];
        }

        // Recent centers
        $recentCenters = LearningCenter::with('user:id,name')->latest()->limit(5)->get();
        foreach ($recentCenters as $center) {
            $activities[] = [
                'type' => 'center',
                'title' => 'Yangi o\'quv markazi',
                'description' => $center->name,
                'time' => $center->created_at->diffForHumans(),
                'icon' => 'building',
                'color' => 'green',
            ];
        }

        // Sort by time
        usort($activities, fn($a, $b) => strtotime($b['time']) - strtotime($a['time']));
        $this->recentActivities = array_slice($activities, 0, 10);
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('layouts.admin.app', ['title' => 'Dashboard']);
    }
}
