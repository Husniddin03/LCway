<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\LearningCenter;
use App\Models\LearningCentersCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WeekdaysController extends Controller
{
    public function edit(string $id)
    {
        $LearningCenter = LearningCenter::find($id);
        Gate::authorize('isOun', $LearningCenter);
        
        // Barcha kunlarni olish
        $allDays = Calendar::all();
        
        // O'quv markazining mavjud vaqtlarini olish
        $existingSchedules = LearningCentersCalendar::where('learning_centers_id', $id)
            ->get()
            ->keyBy('calendar_id');
        
        // Har bir kun uchun existing vaqtlarni qo'shish
        $weedays = $allDays->map(function($day) use ($existingSchedules) {
            $schedule = $existingSchedules->get($day->id);
            $day->existing_open_time = $schedule->open_time ?? null;
            $day->existing_close_time = $schedule->close_time ?? null;
            return $day;
        });
        
        return view('course.weekday', compact('LearningCenter', 'weedays'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'days' => 'nullable|array',
            'days.*.calendar_id' => 'nullable|exists:calendar,id',
            'days.*.open_time'   => 'nullable',
            'days.*.close_time'  => 'nullable',
        ]);

        if (!empty($validated['days'])) {

            LearningCentersCalendar::where('learning_centers_id', $id)->delete();

            foreach ($validated['days'] as $day) {
                LearningCentersCalendar::create([
                    'learning_centers_id' => $id,
                    'calendar_id'         => $day['calendar_id'] ?? null,
                    'open_time'           => $day['open_time'] ?? null,
                    'close_time'          => $day['close_time'] ?? null,
                ]);
            }
        }

        return redirect()->route('blog-single', $id)->with('success', "Muvaffaqiyatli yangilandi");
    }


    public function delete(string $id) {}
}
