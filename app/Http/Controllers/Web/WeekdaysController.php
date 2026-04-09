<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Models\LearningCenter;
use App\Models\LearningCentersCalendar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WeekdaysController extends Controller
{
    public function edit(LearningCenter $center)
    {
        $LearningCenter = $center;
        Gate::authorize('isOun', $LearningCenter);

        // O'quv markazining mavjud vaqtlarini olish - id kaliti bilan
        $schedules = LearningCentersCalendar::where('learning_centers_id', $LearningCenter->id)->get();

        // Weekdays massivini yaratish (kunlar ro'yxati)
        $allWeekdays = ['Dushanba', 'Seshanba', 'Chorshanba', 'Payshanba', 'Juma', 'Shanba', 'Yakshanba'];

        $weekdays = collect($allWeekdays)->map(function ($day) use ($schedules) {
            $schedule = $schedules->firstWhere('weekdays', $day);
            return (object) [
                'id' => $schedule ? $schedule->id : strtolower($day),
                'weekdays' => $day,
                'open_time' => $schedule ? $schedule->open_time : null,
                'close_time' => $schedule ? $schedule->close_time : null,
                'schedule_id' => $schedule ? $schedule->id : null,
                'existing_open_time' => $schedule ? $schedule->open_time : null,
                'existing_close_time' => $schedule ? $schedule->close_time : null,
            ];
        });

        return view('center.weekday', compact('LearningCenter', 'weekdays'));
    }

    public function update(Request $request, LearningCenter $center)
    {
        $validated = $request->validate([
            'days' => 'nullable|array',
            'days.*.weekdays' => 'required|string|max:255',
            'days.*.open_time' => 'nullable',
            'days.*.close_time' => 'nullable',
        ]);

        if (!empty($validated['days'])) {
            foreach ($validated['days'] as $day) {
                // Agar vaqt kiritilgan bo'lsa saqlash, bo'lmasa o'tkazib yuborish
                if (!empty($day['open_time']) || !empty($day['close_time'])) {
                    LearningCentersCalendar::updateOrCreate(
                        [
                            'learning_centers_id' => $center->id,
                            'weekdays' => $day['weekdays'],
                        ],
                        [
                            'open_time' => $day['open_time'] ?: null,
                            'close_time' => $day['close_time'] ?: null,
                        ]
                    );
                }
            }
        }

        return redirect()->route('center', $center->slug)->with('success', "Muvaffaqiyatli yangilandi");
    }

    public function add(Request $request, LearningCenter $center)
    {
        $validated = $request->validate([
            'weekdays' => 'required|string|max:255',
            'open_time' => 'nullable',
            'close_time' => 'nullable',
        ]);

        // Avval bu kun uchun jadval borligini tekshirish
        $existingSchedule = LearningCentersCalendar::where('learning_centers_id', $center->id)
            ->where('weekdays', $validated['weekdays'])
            ->first();

        if ($existingSchedule) {
            // Agar mavjud bo'lsa, yangilash
            $existingSchedule->update([
                'open_time' => $validated['open_time'] ?? null,
                'close_time' => $validated['close_time'] ?? null,
            ]);

            $message = 'Hafta kuni ma\'lumotlari muvaffaqiyatli yangilandi';
        } else {
            // Agar mavjud bo'lmasa, yangi yaratish
            LearningCentersCalendar::create([
                'learning_centers_id' => $center->id,
                'weekdays' => $validated['weekdays'],
                'open_time' => $validated['open_time'] ?? null,
                'close_time' => $validated['close_time'] ?? null,
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
