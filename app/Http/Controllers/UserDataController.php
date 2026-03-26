<?php

namespace App\Http\Controllers;

use App\Models\UserData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserDataController extends Controller
{
    public function index()
    {
        $user = Auth::user()->load(['userData', 'centers']);
        return view('pages.profile', compact('user'));
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
            'bio' => 'nullable|string|max:1000',
            'name'     => 'required|string|max:32',
        ], [
            'first_name.required' => 'Ism maydoni to\'ldirilishi shart.',
            'last_name.required' => 'Familiya maydoni to\'ldirilishi shart.',
            'phone.required' => 'Telefon raqami maydoni to\'ldirilishi shart.',
            'gander.required' => 'Jinsni tanlash shart.',
            'gander.in' => 'Noto\'g\'ri jins tanlovi.',
            'birthday.required' => 'Tug\'ilgan kun maydoni to\'ldirilishi shart.',
            'birthday.date' => 'Tug\'ilgan kun sana formati noto\'g\'ri.',
            'birthday.before' => 'Tug\'ilgan kun bugungi sanadan oldin bo\'lishi kerak.',
            'bio.max' => 'Bio maydoni 1000 belgidan oshmasligi kerak.',
            'name.required' => 'Ism maydoni to\'ldirilishi shart.',
            'name.max' => 'Ism 32 belgidan oshmasligi kerak.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update User model data (name, email, bio, avatar)
        $user = Auth::user();
        if ($request->has('name')) {
            $user->name = $request->name;
        }
        if ($request->hasFile('avatar')) {
            // remove old avatar img
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $avatar = $request->file('avatar');
            $filename = time() . '_' . $avatar->getClientOriginalName();
            $path = $avatar->storeAs('avatars', $filename, 'public');
            $user->avatar = $path;
        }
        $user->save();

        // Update UserData model data (personal information)
        $userData = UserData::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'user_id' => Auth::id(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'gander' => $request->gander,
                'birthday' => $request->birthday,
                'bio' => $request->bio,
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

    public function changePassword(Request $request) {
        $user = Auth::user();
        
        // Different validation rules based on password_status
        if ($user->password_status === 'google') {
            // For Google users, only new password is required
            $validator = Validator::make($request->all(), [
                'password' => 'required|string|min:8|confirmed',
            ], [
                'password.required' => 'Yangi parol maydoni to\'ldirilishi shart.',
                'password.min' => 'Yangi parol kamida 8 belgidan iborat bo\'lishi kerak.',
                'password.confirmed' => 'Yangi parol tasdiqlashi bilan mos kelmaydi.',
            ]);
        } else {
            // For regular users, current password is required
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'password' => 'required|string|min:8|confirmed',
            ], [
                'current_password.required' => 'Joriy parol maydoni to\'ldirilishi shart.',
                'password.required' => 'Yangi parol maydoni to\'ldirilishi shart.',
                'password.min' => 'Yangi parol kamida 8 belgidan iborat bo\'lishi kerak.',
                'password.confirmed' => 'Yangi parol tasdiqlashi bilan mos kelmaydi.',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check current password only for regular users
        if ($user->password_status !== 'google') {
            if (!password_verify($request->current_password, $user->password)) {
                return redirect()->back()
                    ->with('error', 'Joriy parol noto\'g\'ri.')
                    ->withInput();
            }
        }

        // Update password and status
        $user->password = bcrypt($request->password);
        $user->password_status = 'user';
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Parol muvaffaqiyatli o\'zgartirildi!');
    }
}
