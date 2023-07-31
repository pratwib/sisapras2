<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use App\Models\Item;
use App\Models\Location;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function show(): View
    {
        $user = Auth::user();
        $adminCount = User::where('role', 'admin')->count();
        $locationCount = Location::count();
        $itemCount = Item::count();
        $borrowCount = Borrow::whereIn('lend_status', ['requested', 'approved', 'borrowed', 'overdue'])->count();
        $historyCount = Borrow::whereIn('lend_status', ['canceled', 'returned', 'declined'])->count();

        return view('pages.dashboard', compact('user', 'adminCount', 'locationCount', 'itemCount', 'borrowCount', 'historyCount'));
    }
}
