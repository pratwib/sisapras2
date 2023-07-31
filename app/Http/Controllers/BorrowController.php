<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BorrowController extends Controller
{
    // Storing a new borrow
    public function borrow(Request $request): RedirectResponse
    {
        $request->validate([
            'return_date' => 'required',
            'lend_quantity' => 'required',
            'lend_detail' => 'required',
            'lend_photo' => 'required',
        ], [
            'return_date.required' => 'Silakan masukkan tanggal pengembalian',
            'lend_quantity.required' => 'Silakan masukkan jumlah pinjam',
            'lend_detail.required' => 'Silakan masukkan tujuan peminjaman',
            'lend_photo.required' => 'Silakan upload foto selfie kamu',
        ]);

        $photoFile = $request->file('lend_photo');
        $photoFileExtention = $photoFile->extension();
        $photoFilename = date('ymdhis') . "." . $photoFileExtention;

        // Storing image file into app storage
        $destination_path = 'public/images/borrows';
        $photoFile->storeAs($destination_path, $photoFilename);

        // $time = time();

        // dd(date('Y-m-d'));

        $borrowData = [
            'location_id' => $request->location_id,
            'item_id' => $request->item_id,
            'user_id' => $request->user_id,
            'return_date' => $request->return_date,
            'lend_quantity' => $request->lend_quantity,
            'lend_detail' => $request->lend_detail,
            'lend_photo' => $photoFilename,
            'lend_status' => 'requested',
        ];

        Borrow::create($borrowData);

        $item = Item::find($request->item_id);
        $item->item_quantity = $item->item_quantity - $request->lend_quantity;
        // dd($item->item_quantity);

        $item->update();

        session()->flash('message', 'Peminjaman barang ' . $item->item_name . ' berhasil ditambahkan. Silakan menunggu proses pengajuan maksimal 1 hari kerja.');

        $url = '/' . auth()->user()->role . '/borrow';
        return redirect($url);
    }

    // Show list of ongoing borrow that a user make
    public function showUser(): View
    {
        $user = Auth::user();
        $userId = $user->user_id;

        $borrows = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name')
            ->where('users.user_id', $userId)
            ->where(function (Builder $query) {
                $query->orWhere('borrows.lend_status', 'requested')
                    ->orWhere('borrows.lend_status', 'approved')
                    ->orWhere('borrows.lend_status', 'borrowed')
                    ->orWhere('borrows.lend_status', 'overdue');
            })
            ->get();

        return view('pages.borrow', compact('user', 'borrows'));
    }


    // Show list of borrow to be approved by admin based on admin location
    public function showAdmin(): View
    {
        $user = Auth::user();
        $adminLocation = $user->location_id;

        $borrows = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name')
            ->where('borrows.location_id', $adminLocation)
            ->where(function (Builder $query) {
                $query->orWhere('borrows.lend_status', 'requested')
                    ->orWhere('borrows.lend_status', 'approved')
                    ->orWhere('borrows.lend_status', 'borrowed')
                    ->orWhere('borrows.lend_status', 'overdue');
            })
            ->get();

        return view('pages.borrow', compact('user', 'borrows'));
    }

    // Show user borrow history and declined borrow request
    public function historyUser(): View
    {
        $user = Auth::user();
        $userId = $user->user_id;

        $borrows = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name')
            ->where('users.user_id', $userId)
            ->where(function (Builder $query) {
                $query->orWhere('borrows.lend_status', 'declined')
                    ->orWhere('borrows.lend_status', 'canceled')
                    ->orWhere('borrows.lend_status', 'returned');
            })
            ->get();


        return view('pages.history', compact('user', 'borrows'));
    }

    public function historyAdmin(): View
    {
        $user = Auth::user();
        $adminLocation = $user->location_id;

        $borrows = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name')
            ->where('borrows.location_id', $adminLocation)
            ->where(function (Builder $query) {
                $query->orWhere('borrows.lend_status', 'declined')
                    ->orWhere('borrows.lend_status', 'canceled')
                    ->orWhere('borrows.lend_status', 'returned');
            })
            ->get();


        return view('pages.history', compact('user', 'borrows'));
    }

    // Approve borrow request by admin
    public function approved(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);

        // $borrow->lend_status = $request->lend_status;
        // OR
        $borrow->lend_status = 'approved';
        $borrow->update();
        // Mending gimana yak
        // kalo pake cara pertama berarti bikin hidden input dengan value lend_status itu
        // kalo cara kedua yaa gausa ada hidden inputnya

        session()->flash('message', 'Peminjaman barang telah disetujui.');

        $url = '/' . auth()->user()->role . '/borrow';
        return redirect($url);
    }

    // Lending item (for admin)
    public function borrowed(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);

        $borrow->lend_status = 'borrowed';
        $borrow->update();

        session()->flash('message', 'Barang sudah diambil untuk dipinjam.');

        $url = '/' . auth()->user()->role . '/borrow';
        return redirect($url);
    }

    public function overdue()
    {
        $overdue = Borrow::where('lend_status', 'overdue')
            ->where('lend_date', '<', Carbon::now())
            ->get();

        return view('pages.borrow', compact('overdue'));
    }

    // Cancel borrow request by user
    public function canceled(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);

        // $borrow->lend_status = $request->lend_status;
        // OR
        $borrow->lend_status = 'canceled';
        $borrow->update();

        // Updating item quantity back to normal
        $borrowItem = Borrow::find($request->borrow_id);
        $item = Item::where('item_id', $borrowItem->item_id)->first();

        // dd($item);

        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah dibatalkan');

        $url = '/' . auth()->user()->role . '/history';
        return redirect($url);
    }

    // Decline borrow request by admin
    public function declined(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);

        // $borrow->lend_status = $request->lend_status;
        // OR
        $borrow->lend_status = 'declined';
        $borrow->update();

        // Updating item quantity back to normal
        $borrowItem = Borrow::find($request->borrow_id);
        $item = Item::where('item_id', $borrowItem->item_id)->first();

        // dd($item);

        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah ditolak.');

        $url = '/' . auth()->user()->role . '/history';
        return redirect($url);
    }

    // Item returned by admin
    public function returned(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);

        $borrow->lend_status = 'returned';
        $borrow->update();

        // Updating item quantity back to normal
        $borrowItem = Borrow::find($request->borrow_id);
        $item = Item::where('item_id', $borrowItem->item_id)->first();

        // dd($item);

        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah dikembalikan.');

        $url = '/' . auth()->user()->role . '/history';
        return redirect($url);
    }
}
