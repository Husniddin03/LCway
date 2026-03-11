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
            'bio' => 'nullable|string|max:1000',
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
        if ($request->has('email')) {
            $user->email = $request->email;
        }
        if ($request->hasFile('avatar')) {
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
}
