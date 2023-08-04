<?php

namespace App\Http\Controllers;

use App\Mail\NewRequestNotification;
use App\Models\Item;
use App\Models\Borrow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class BorrowController extends Controller
{
    // Storing a new borrow
    public function borrow(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'return_date' => 'required',
            'lend_quantity' => 'required',
            'lend_detail' => 'required',
            'lend_photo' => 'required|image',
        ], [
            'return_date.required' => 'Silakan masukkan tanggal pengembalian',
            'lend_quantity.required' => 'Silakan masukkan jumlah pinjam',
            'lend_detail.required' => 'Silakan masukkan tujuan peminjaman',
            'lend_photo.required' => 'Silakan upload foto selfie kamu',
            'lend_photo.image' => 'File yang kamu masukkan bukan foto',
        ]);

        $photoFile = $request->file('lend_photo');
        $photoFileExtention = $photoFile->extension();
        $photoFilename = date('ymdhis') . "." . $photoFileExtention;

        // Storing image file into app storage
        $destination_path = 'public/images/borrows';
        $photoFile->storeAs($destination_path, $photoFilename);

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
        $item->update();

        // Email notification for admin(s)
        // Getting data needed for the email
        $admins = User::where('location_id', $borrowData['location_id'])->get();
        $borrowerName = User::where('user_id', $borrowData['user_id'])->first();
        $itemName = Item::where('item_id', $borrowData['item_id'])->first();

        // Looping in case there is more than one admin
        foreach ($admins as $key => $value) {
            $emailDetails = [
                'admin_name' => $value['name'],
                'borrower_name' => $borrowerName->name,
                'item_name' => $itemName->item_name,
                'lend_quantity' => $borrowData['lend_quantity'],
            ];
            // Send email
            Mail::to($value['email'])->send(new NewRequestNotification($emailDetails));
        }

        session()->flash('message', 'Peminjaman barang ' . $item->item_name . ' berhasil ditambahkan. Silakan menunggu proses pengajuan maksimal 1 hari kerja.');

        session()->flash('user', $user);

        $url = '/' . auth()->user()->role . '/borrow';
        return redirect($url);
    }

    // Show list of ongoing borrow that a user make
    public function show(): View
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $adminLocation = $user->location_id;

        $query = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name', 'users.hp_number');

        if ($user->role == 'user') {
            $query->where('users.user_id', $userId);
        } elseif ($user->role == 'admin') {
            $query->where('borrows.location_id', $adminLocation);
        }

        $query->where(function (Builder $query) {
            $query->orWhere('borrows.lend_status', 'requested')
                ->orWhere('borrows.lend_status', 'approved')
                ->orWhere('borrows.lend_status', 'borrowed')
                ->orWhere('borrows.lend_status', 'overdue');
        });

        $borrows = $query->get();

        $today = Carbon::now()->setTimezone('Asia/Jakarta');
        $overdueBorrow = Borrow::all();

        foreach ($overdueBorrow as $borrow) {
            // Parsing return date to a Carbon date
            $returnDate = Carbon::parse($borrow->return_date);

            // Check if today is greater than return date
            $isOverdue = $today->gt($returnDate);

            // Change lend status
            if ($borrow->lend_status === 'borrowed' && $isOverdue) {
                $borrow->lend_status = 'overdue';
                $borrow->update();
            }
        }

        session()->flash('user', $user);

        return view('pages.borrow', compact('user', 'borrows'));
    }

    // Show user borrow history
    public function history(): View
    {
        $user = Auth::user();
        $userId = $user->user_id;
        $adminLocation = $user->location_id;

        $query = DB::table('locations')
            ->join('borrows', 'locations.location_id', '=', 'borrows.location_id')
            ->join('users', 'borrows.user_id', '=', 'users.user_id')
            ->join('items', 'borrows.item_id', '=', 'items.item_id')
            ->select('borrows.*', 'locations.location_name', 'items.item_name', 'users.name', 'users.hp_number');

        if ($user->role == 'user') {
            $query->where('users.user_id', $userId);
        } elseif ($user->role == 'admin') {
            $query->where('borrows.location_id', $adminLocation);
        }

        $query->where(function (Builder $query) {
            $query->orWhere('borrows.lend_status', 'declined')
                ->orWhere('borrows.lend_status', 'canceled')
                ->orWhere('borrows.lend_status', 'returned');
        });

        $borrows = $query->get();


        return view('pages.history', compact('user', 'borrows'));
    }

    // Approve borrow request by admin
    public function approved(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);
        $borrow->lend_status = 'approved';
        $borrow->update();

        session()->flash('message', 'Peminjaman barang telah disetujui.');

        // Email notification for user if their request is approved
        $user = User::where('user_id', $borrow->user_id)->first();
        $emailDetails = [];

        session()->flash('user', $user);

        // Mail::to($user->email)->send(new RequestApproved($emailDetails));

        $url = '/' . auth()->user()->role . '/borrow';
        return redirect($url);
    }

    // Decline borrow request by admin
    public function declined(Request $request): RedirectResponse
    {
        $borrow = Borrow::find($request->borrow_id);
        $borrow->lend_status = 'declined';
        $borrow->update();

        // Updating item quantity back to normal
        $borrowItem = Borrow::find($request->borrow_id);
        $item = Item::where('item_id', $borrowItem->item_id)->first();

        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah ditolak.');

        // Email notification for user if their request is declined
        $user = User::where('user_id', $borrow->user_id)->first();
        $emailDetails = [];

        session()->flash('user', $user);

        // Mail::to($user->email)->send(new RequestDeclined($emailDetails));

        $url = '/' . auth()->user()->role . '/history';
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
        $borrow->lend_status = 'canceled';
        $borrow->update();

        // Updating item quantity back to normal
        $borrowItem = Borrow::find($request->borrow_id);
        $item = Item::where('item_id', $borrowItem->item_id)->first();


        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah dibatalkan');

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

        $item->item_quantity = $item->item_quantity + $borrowItem->lend_quantity;
        $item->update();

        session()->flash('message', 'Peminjaman barang telah dikembalikan.');

        $url = '/' . auth()->user()->role . '/history';
        return redirect($url);
    }
}
