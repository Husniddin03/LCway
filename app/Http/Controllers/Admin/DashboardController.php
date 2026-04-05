<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AiChat;
use App\Models\LearningCenter;
use App\Models\LearningCentersComment;
use App\Models\RiasecResult;
use App\Models\SubjectsOfLearningCenter;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Get dashboard statistics
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'users' => [
                'total' => User::count(),
                'active' => User::where('status', 'active')->count(),
                'inactive' => User::where('status', 'inactive')->count(),
                'new_today' => User::whereDate('created_at', today())->count(),
                'new_this_week' => User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            ],
            'learning_centers' => [
                'total' => LearningCenter::count(),
                'verified' => LearningCenter::where('checked', 1)->count(),
                'pending' => LearningCenter::where('checked', 0)->count(),
                'premium' => LearningCenter::where('premium', 1)->count(),
            ],
            'teachers' => [
                'total' => Teacher::count(),
            ],
            'subjects' => [
                'total' => SubjectsOfLearningCenter::count(),
            ],
            'comments' => [
                'total' => LearningCentersComment::count(),
                'pending' => LearningCentersComment::where('checked', 0)->count(),
            ],
            'ai_chats' => [
                'total' => AiChat::count(),
                'today' => AiChat::whereDate('created_at', today())->count(),
            ],
            'riasec_tests' => [
                'total' => RiasecResult::count(),
                'today' => RiasecResult::whereDate('created_at', today())->count(),
            ],
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get recent activities
     */
    public function recentActivities(): JsonResponse
    {
        $activities = [];

        // Recent users
        $recentUsers = User::latest()->limit(5)->get(['id', 'name', 'email', 'created_at']);
        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user_registered',
                'title' => 'New user registered',
                'description' => $user->name . ' (' . $user->email . ')',
                'created_at' => $user->created_at,
            ];
        }

        // Recent learning centers
        $recentCenters = LearningCenter::with('user:id,name')->latest()->limit(5)->get();
        foreach ($recentCenters as $center) {
            $activities[] = [
                'type' => 'center_created',
                'title' => 'New learning center added',
                'description' => $center->name . ' by ' . ($center->user->name ?? 'Unknown'),
                'created_at' => $center->created_at,
            ];
        }

        // Recent comments
        $recentComments = LearningCentersComment::with('user:id,name')->latest()->limit(5)->get();
        foreach ($recentComments as $comment) {
            $activities[] = [
                'type' => 'comment_added',
                'title' => 'New comment',
                'description' => 'By ' . ($comment->user->name ?? 'Unknown'),
                'created_at' => $comment->created_at,
            ];
        }

        // Sort by created_at desc
        usort($activities, function ($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return response()->json([
            'success' => true,
            'data' => array_slice($activities, 0, 10)
        ]);
    }

    /**
     * Get chart data
     */
    public function chartData(): JsonResponse
    {
        // User registration by month (last 6 months)
        $userStats = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Learning centers by month
        $centerStats = LearningCenter::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'users' => $userStats,
                'centers' => $centerStats,
            ]
        ]);
    }
}
