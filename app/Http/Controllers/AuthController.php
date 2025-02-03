<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Super-admin kontrolü
            if (!$request->user()->hasRole('super-admin')) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Bu sayfaya erişim yetkiniz yok.',
                ]);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Girilen bilgiler sistemde kayıtlı değil.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 