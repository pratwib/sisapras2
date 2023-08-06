<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    // Show email form for requesting reset password
    public function showForgot(): View
    {
        return view('pages.forgot');
    }

    // Handling email request form submission
    public function email(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'Silahkan masukkan email Kamu'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => 'Link reset password telah dikirim! Silakan cek inbox email Kamu'])
            : back()->withErrors(['email' => 'Email tidak terdaftar dalam sistem']);
    }

    // Show password reset form
    public function showReset(string $token): View
    {
        return view('pages.reset', ['token' => $token]);
    }

    // Handling reset password form
    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ]);

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('message', 'Password kamu berhasil diubah! Silakan login')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
