<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LocationController extends Controller
{
    // Show location list (only for superadmin)
    public function show(): View
    {
        $user = Auth::user();
        $locations = Location::all();

        return view('pages.location', compact('user', 'locations'));
    }

    // Store a new location (only for superadmin)
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'location_name' => 'required|unique:locations,location_name',
        ], [
            'location_name.required' => 'Silakan masukkan nama lokasi',
            'location_name.unique' => 'Lokasi sudah terdaftar',
        ]);

        $newLocation = ['location_name' => $request->location_name];

        Location::create($newLocation);

        session()->flash('message', 'Lokasi baru berhasil ditambahkan');

        $url = '/' . auth()->user()->role . '/location';
        return redirect($url);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $location = Location::find($id);

        $request->validate([
            'location_name' => 'required|unique:locations,location_name,' . $location->location_id . ',location_id',
        ], [
            'location_name.required' => 'Silakan masukkan nama lokasi',
            'location_name.unique' => 'Lokasi sudah terdaftar',
        ]);

        $location->location_name = $request->location_name;

        $location->update();

        session()->flash('message', 'Data lokasi ' . $location->location_name . ' berhasil diubah');

        $url = '/' . auth()->user()->role . '/location';
        return redirect($url);
    }

    // Deleting a location with soft delete (only for super admin)
    public function delete($id): RedirectResponse
    {
        $location = Location::findOrFail($id);

        $location->delete();

        session()->flash('message', 'Lokasi ' . $location->location_name . ' telah dihapus dari daftar');

        $url = '/' . auth()->user()->role . '/location';
        return redirect($url);
    }
}
