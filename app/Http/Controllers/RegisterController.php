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
            'reg_number' => 'required|unique:users,reg_number',
            'department' => 'required',
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
            'reg_number.required' => 'Silakan masukkan  NIM atau NIP Kamu',
            'reg_number.unique' => 'NIM atau NIP sudah terdaftar',
            'department.required' => 'Silakan masukkan departemen Kamu',
        ]);

        $registerCredential = [
            'name' => $request->name,
            'hp_number' => $request->hp_number,
            'username' => $request->username,
            'email' => $request->email,
            'reg_number' => $request->reg_number,
            'department' => $request->department,
            'password' => Hash::make($request->password),
        ];

        User::create($registerCredential);

        session()->flash('message', 'Registrasi berhasil, silakan login dengan akun yang baru saja dibuat.');

        return redirect('/login');
    }
}
