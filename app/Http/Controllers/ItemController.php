<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ItemController extends Controller
{
    // Page for item

    // Show all items (for user)
    public function showAll(): View
    {
        $user = Auth::user();

        $items = DB::table('locations')
            ->join('items', 'locations.location_id', '=', 'items.location_id')
            ->select('items.*', 'locations.location_name')
            ->where('items.deleted_at', null)
            ->get();

        $locations = Location::orderBy('location_name')->get();
        session()->flash('locations', $locations);

        session()->flash('user', $user);

        return view('pages.item', compact('user', 'items'));
    }

    // Show item in a location based on admin
    public function showByLocation(): View
    {
        $user = Auth::user();

        $items = DB::table('locations')
            ->join('items', 'locations.location_id', '=', 'items.location_id')
            ->select('items.*', 'locations.location_name')
            ->where('items.location_id', $user->location_id)
            ->where('items.deleted_at', null)
            ->get();

        return view('pages.item', compact('user', 'items'));
    }

    // Store a new item
    public function create(Request $request): RedirectResponse
    {
        $itemLocationId = Auth::user()->location_id;

        $request->validate([
            'item_name' => 'required',
        ], [
            'item_name.required' => 'Silakan masukkan nama barang'
        ]);

        $newItem = [
            'location_id' => $itemLocationId === null ? $request->location_id : $itemLocationId,
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'item_quantity' => $request->item_quantity,
        ];

        Item::create($newItem);

        session()->flash('message', 'Barang baru berhasil ditambahkan');

        $url = '/' . auth()->user()->role . '/item';
        return redirect($url);
    }

    // Storing an edited item
    public function update(Request $request, $id): RedirectResponse
    {
        // $item = Item::find($request->item_id);
        $item = Item::find($id);

        $request->validate([
            'item_name' => 'required',
        ], [
            'item_name.required' => 'Silakan masukkan nama barang'
        ]);

        if (isset($request->location_id)) {
            $item->location_id = $request->location_id;
        }
        $item->item_name = $request->item_name;
        $item->item_desc = $request->item_desc;
        $item->item_quantity = $request->item_quantity;

        $item->update();

        session()->flash('message', 'Data barang ' . $item->item_name . ' berhasil diubah');

        $url = '/' . auth()->user()->role . '/item';
        return redirect($url);
    }

    // Deleting an item
    public function delete($id): RedirectResponse
    {
        $item = Item::findOrFail($id);

        $item->delete();

        session()->flash('message', 'Barang ' . $item->item_name . ' telah dihapus dari daftar');

        $url = '/' . auth()->user()->role . '/item';
        return redirect($url);
    }
}
