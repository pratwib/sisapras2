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
        $userLocationId = $user->location_id;
        $userId = $user->user_id;

        $adminCount = User::where('role', 'admin')->count();

        $locationCount = Location::count();

        $itemCount = Item::count();
        $itemByLocationCount = Item::where('location_id', $userLocationId)->count();

        $borrowCount = Borrow::whereIn('lend_status', ['requested', 'approved', 'borrowed', 'overdue'])->count();
        $borrowByLocationCount = Borrow::where('location_id', $userLocationId)
            ->whereIn('lend_status', ['requested', 'approved', 'borrowed', 'overdue'])
            ->count();
        $borrowByUserCount = Borrow::where('user_id', $userId)
            ->whereIn('lend_status', ['requested', 'approved', 'borrowed', 'overdue'])
            ->count();

        $historyCount = Borrow::whereIn('lend_status', ['canceled', 'returned', 'declined'])->count();
        $historyByLocationCount = Borrow::where('location_id', $userLocationId)
            ->whereIn('lend_status', ['canceled', 'returned', 'declined'])
            ->count();
        $historyByUserCount = Borrow::where('user_id', $userId)
            ->whereIn('lend_status', ['canceled', 'returned', 'declined'])
            ->count();

        return view('pages.dashboard', compact('user', 'adminCount', 'locationCount', 'itemCount', 'itemByLocationCount', 'borrowCount', 'borrowByLocationCount', 'borrowByUserCount', 'historyCount', 'historyByLocationCount', 'historyByUserCount'));
    }
}
