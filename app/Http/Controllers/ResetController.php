<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResetController extends Controller
{
    // Show registration form
    public function show(): View
    {
        return view('pages.reset');
    }

    // Register
    public function reset(Request $request): RedirectResponse
    {
        return redirect('/login');
    }
}
