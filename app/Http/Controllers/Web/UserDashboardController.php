<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\LearningCenter;
use App\Models\SubjectsOfLearningCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user->load(['centers.teachers', 'centers.subjects', 'centers.favorites', 'centers.comments']);
        
        return view('user.dashboard', compact('user'));
    }

    public function centers()
    {
        $user = Auth::user();
        $centers = $user->centers()
            ->with(['teachers', 'subjects', 'favorites', 'images'])
            ->latest()
            ->paginate(12);
        
        return view('user.centers', compact('user', 'centers'));
    }

    public function show(LearningCenter $center)
    {
        // Ensure the user owns this center
        if ($center->users_id !== Auth::id()) {
            abort(403, 'Sizga ruxsat etilmagan');
        }

        $center->load(['teachers.teacherSubjects.subject', 'subjects', 'images', 'connections']);
        
        // Get existing subjects for datalist
        $existingSubjects = SubjectsOfLearningCenter::select('subject_name')
            ->distinct()
            ->whereNotNull('subject_name')
            ->where('subject_name', '!=', '')
            ->orderBy('subject_name')
            ->pluck('subject_name');
        
        // Prepare data for Alpine.js to avoid Blade parsing issues
        $connectionsData = $center->connections->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->connection_name,
            'url' => $c->url,
            'icon' => $c->connection_icon
        ])->values();
        
        $teachersData = $center->teachers->map(fn($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'phone' => $t->phone,
            'photo' => $t->photo ? asset('storage/' . $t->photo) : null,
            'about' => $t->about,
            'subjects' => $t->teacherSubjects->map(fn($ts) => [
                'id' => $ts->subject_id,
                'name' => $ts->subject->subject_name ?? 'N/A',
                'pivot' => [
                    'subject_type' => $ts->subject_type,
                    'subject_icon' => $ts->subject_icon,
                    'description' => $ts->description,
                    'price' => $ts->price,
                    'currency' => $ts->currency,
                    'period' => $ts->period
                ]
            ])->values()
        ])->values();
        
        $subjectsData = $center->subjects->map(fn($s) => [
            'id' => $s->id,
            'name' => $s->subject_name,
            'teacher_count' => $s->teacherSubjects->count()
        ])->values();
        
        $imagesData = $center->images->map(fn($i) => [
            'id' => $i->id,
            'url' => asset('storage/' . $i->image)
        ])->values();
        
        // Prepare weekdays data
        $weekdaysData = $center->calendar()->orderByRaw("FIELD(weekdays, 'Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba')")
            ->get()
            ->map(fn($w) => [
                'id' => $w->id,
                'weekdays' => $w->weekdays,
                'open_time' => $w->open_time,
                'close_time' => $w->close_time,
            ])
            ->values();
        
        return view('user.center-manage', compact('center', 'existingSubjects', 'connectionsData', 'teachersData', 'subjectsData', 'imagesData', 'weekdaysData'));
    }
}
