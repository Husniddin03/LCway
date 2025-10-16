<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LogController extends Controller
{
    /**
     * Register new user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6', // password_confirmation bilan ishlaydi
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('index')->with('success', 'User registered successfully');
    }

    /**
     * Login user1
     */
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route('index')->with('success', 'Logged in successfully');
            
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Logout user
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('index')->with('success', 'Logged out successfully');
    }
}
