<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewAffiliateNotification;
use Illuminate\Support\Facades\Notification;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            if ($user->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            } else {
                return redirect()->intended('affiliate/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'affiliate',
            'affiliate_id' => 'AFF-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'status' => 'active',
        ]);

        // Create Affiliate Record
        \App\Models\Affiliate::create([
            'affiliate_id' => $user->affiliate_id,
            'user_id' => $user->id,
            'level' => 'outer', // Default level
            'referral_code' => \Illuminate\Support\Str::slug($user->name) . '-' . rand(100, 999),
            'status' => 'active',
        ]);

        // Notify Admins
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new NewAffiliateNotification($affiliate));

        Auth::login($user);

        return redirect()->route('affiliate.dashboard');
    }
}
