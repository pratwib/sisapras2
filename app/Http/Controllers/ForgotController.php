<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ForgotController extends Controller
{
    // Show registration form
    public function show(): View
    {
        return view('pages.forgot');
    }

    // Register
    public function forgot(Request $request): RedirectResponse
    {
        return redirect('/forgot-password');
    }
}
