<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    // Show login form
    public function show(): View
    {
        return view('pages.login');
    }

    // Login
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Silakan masukkan username Kamu',
            'password.required' => 'Silakan masukkan password Kamu',
        ]);

        $loginCredential = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        if (Auth::attempt($loginCredential)) {
            // return redirect('/login');
            // echo "Login Successful";
            if (Auth::user()->role == 'user') {
                return redirect('user/dashboard');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('admin/dashboard');
            } else {
                return redirect('superadmin/dashboard');
            }
        } else {
            return redirect('/login')->withErrors('Username atau password yang dimasukkan salah')->withInput();
        }
    }

    // Logout
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect('/home');
    }
}
