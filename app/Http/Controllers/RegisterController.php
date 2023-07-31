<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class RegisterController extends Controller
{
    // Show registration form
    public function show(): View
    {
        return view('pages.register');
    }

    // Register
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required',
            'hp_number' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
        ], [
            'name.required' => 'Silakan masukkan nama Kamu',
            'hp_number.required' => 'Silakan masukkan nomor hp Kamu',
            'hp_number.regex' => 'Silakan masukkan nomor telepon yang valid',
            'username.required' => 'Silakan masukkan username Kamu',
            'username.unique' => 'Username sudah digunakan',
            'email.required' => 'Silakan masukkan email Kamu',
            'email.unique' => 'Alamat email sudah terdaftar',
            'email.email' => 'Silakan masukkan email yang valid',
            'password.required' => 'Silakan masukkan password Kamu',
            'password.min' => 'Password harus terdiri dari setidaknya 8 karakter',
        ]);

        $registerCredential = [
            'name' => $request->name,
            'hp_number' => $request->hp_number,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        User::create($registerCredential);

        session()->flash('message', 'Registrasi berhasil, silakan login dengan akun yang baru saja dibuat.');

        return redirect('/login');
    }
}
