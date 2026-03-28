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
            $day->schedule_id = $schedule->id ?? null;
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

    public function add(Request $request, string $id)
    {
        $validated = $request->validate([
            'calendar_id' => 'required|exists:calendar,id',
            'open_time'   => 'nullable',
            'close_time'  => 'nullable',
        ]);

        // Avval bu kun uchun jadval borligini tekshirish
        $existingSchedule = LearningCentersCalendar::where('learning_centers_id', $id)
            ->where('calendar_id', $validated['calendar_id'])
            ->first();

        if ($existingSchedule) {
            // Agar mavjud bo'lsa, yangilash
            $existingSchedule->update([
                'open_time'  => $validated['open_time'] ?? null,
                'close_time' => $validated['close_time'] ?? null,
            ]);

            $message = 'Hafta kuni ma\'lumotlari muvaffaqiyatli yangilandi';
        } else {
            // Agar mavjud bo'lmasa, yangi yaratish
            LearningCentersCalendar::create([
                'learning_centers_id' => $id,
                'calendar_id'         => $validated['calendar_id'],
                'open_time'           => $validated['open_time'] ?? null,
                'close_time'          => $validated['close_time'] ?? null,
            ]);

            $message = 'Hafta kuni muvaffaqiyatli qo\'shildi';
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    public function delete(string $id)
    {
        $schedule = LearningCentersCalendar::findOrFail($id);
        $learningCenterId = $schedule->learning_centers_id;
        
        Gate::authorize('isOun', $schedule->learningCenter);
        
        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hafta kuni muvaffaqiyatli o\'chirildi'
        ]);
    }
}
