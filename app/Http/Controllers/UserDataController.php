<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserDataController extends Controller
{
    public function index()
    {
        $userData = UserData::where('user_id', Auth::id())->first();
        return view('pages.profile', compact('userData'));
    }

    public function edit()
    {
        $userData = UserData::where('user_id', Auth::id())->first();
        return view('pages.profile-edit', compact('userData'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'gander' => 'required|in:male,female',
            'birthday' => 'required|date|before:today',
        ], [
            'first_name.required' => 'Ism maydoni to\'ldirilishi shart.',
            'last_name.required' => 'Familiya maydoni to\'ldirilishi shart.',
            'phone.required' => 'Telefon raqami maydoni to\'ldirilishi shart.',
            'gander.required' => 'Jinsni tanlash shart.',
            'gander.in' => 'Noto\'g\'ri jins tanlovi.',
            'birthday.required' => 'Tug\'ilgan kun maydoni to\'ldirilishi shart.',
            'birthday.date' => 'Tug\'ilgan kun sana formati noto\'g\'ri.',
            'birthday.before' => 'Tug\'ilgan kun bugungi sanadan oldin bo\'lishi kerak.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = UserData::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'gander' => $request->gander,
                'birthday' => $request->birthday,
            ]
        );

        return redirect()->route('profile')
            ->with('success', 'Profil ma\'lumotlari muvaffaqiyatli saqlandi!');
    }

    public function destroy()
    {
        $userData = UserData::where('user_id', Auth::id())->first();
        
        if ($userData) {
            $userData->delete();
            return redirect()->route('profile')
                ->with('success', 'Profil ma\'lumotlari o\'chirildi!');
        }

        return redirect()->route('profile')
            ->with('error', 'O\'chiriladigan ma\'lumot topilmadi.');
    }
}
