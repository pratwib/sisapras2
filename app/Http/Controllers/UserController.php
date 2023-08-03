<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function showProfile(Request $request): View
    {
        $user = Auth::user();

        // For Admin Profile
        $location_id = $user->location_id;
        $location = Location::where('location_id', $location_id)->first();

        return view('pages.profile', compact('user', 'location'));
    }

    // Edit user profile
    public function updateProfile(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);

        $rules = [
            'name' => 'required',
            'hp_number' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => 'required|unique:users,email,' . $user->user_id . ',user_id|email',
            'password' => 'required_if:role,user|min:8',
        ];

        $messages = [
            'name.required' => 'Silakan masukkan nama Kamu',
            'hp_number.required' => 'Silakan masukkan nomor hp Kamu',
            'hp_number.regex' => 'Silakan masukkan nomor telepon yang valid',
            'email.required' => 'Silakan masukkan email Kamu',
            'email.unique' => 'Alamat email sudah terdaftar',
            'email.email' => 'Silakan masukkan email yang valid',
            'password.required_if' => 'Silakan masukkan password Kamu',
            'password.min' => 'Password harus terdiri dari setidaknya 8 karakter',
        ];

        if (Auth::user()->role == 'user') {
            // Only apply validation reg_number and department if the role user
            $rules['department'] = 'required';
            $rules['reg_number'] = 'required|unique:users,reg_number,' . $user->user_id . ',user_id';

            $messages['department.required'] = 'Silakan masukkan departemen Kamu';
            $messages['reg_number.unique'] = 'NIM atau NIP sudah terdaftar';
            $messages['reg_number.required'] = 'Silakan masukkan  NIM atau NIP Kamu';
        }

        $request->validate($rules, $messages);

        $user->name = $request->name;
        $user->hp_number = $request->hp_number;
        $user->email = $request->email;
        $user->reg_number = $request->reg_number;
        $user->department = $request->department;

        if (Auth::user()->role == 'user') {
            // If the user role is 'user', update additional fields
            $user->update();
        } else {
            if ($user->password == $request->password) {
                $user->update();
            } else {
                $user->password = Hash::make($request->password);

                $user->update();
            }
        }

        session()->flash('message', 'Profile berhasil diubah');

        $url = '/' . auth()->user()->role . '/profile';
        return redirect($url);
    }

    // Show admin list (only for superadmin)
    public function showAdmin(): View
    {
        $user = Auth::user();
        $admins = DB::table('locations')
            ->join('users', 'locations.location_id', '=', 'users.location_id')
            ->select('users.*', 'locations.location_name')
            ->where('users.role', 'admin')
            ->where('users.deleted_at', null)
            ->get();

        $locations = Location::orderBy('location_name')->get();
        session()->flash('locations', $locations);

        // Show deleted admins only
        $deletedAdmins = User::onlyTrashed()->with('location')->where('role', 'admin')->get();

        // dd($deletedAdmins);

        return view('pages.admin', compact('user', 'admins', 'deletedAdmins'));
    }

    // Store a new admin (only for superadmin)
    public function createAdmin(Request $request): RedirectResponse
    {
        $request->validate([
            'location_id' => 'required',
            'name' => 'required',
            'hp_number' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8',
            'reg_number' => 'required|unique:users,reg_number',
            'department' => 'required',
        ], [
            'location_id' => 'Silakan pilih lokasi Kamu',
            'name.required' => 'Silakan masukkan nama Kamu',
            'hp_number.required' => 'Silakan masukkan nomor hp Kamu',
            'hp_number.regex' => 'Silakan masukkan nomor telepon yang valid',
            'email.required' => 'Silakan masukkan email Kamu',
            'email.unique' => 'Alamat email sudah terdaftar',
            'email.email' => 'Silakan masukkan email yang valid',
            'password.required' => 'Silakan masukkan password Kamu',
            'password.min' => 'Password harus terdiri dari setidaknya 8 karakter',
            'reg_number.required' => 'Silakan masukkan  NIM atau NIP Kamu',
            'reg_number.unique' => 'NIM atau NIP sudah terdaftar',
            'department.required' => 'Silakan masukkan departemen Kamu',
        ]);

        $newAdmin = [
            'name' => $request->name,
            'location_id' => $request->location_id,
            'hp_number' => $request->hp_number,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'reg_number' => $request->reg_number,
            'department' => $request->department,
        ];

        User::create($newAdmin);

        session()->flash('message', 'Admin baru berhasil ditambahkan');

        $url = '/' . auth()->user()->role . '/admin';
        return redirect($url);
    }

    public function updateAdmin(Request $request, $id): RedirectResponse
    {
        $admin = User::find($id);

        $request->validate([
            'location_id' => 'required',
            'name' => 'required',
            'hp_number' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,9}$/'],
            'email' => 'required|unique:users,email,' . $admin->user_id . ',user_id|email',
            'password' => 'required|min:8',
        ], [
            'location_id' => 'Silakan pilih lokasi Kamu',
            'name.required' => 'Silakan masukkan nama Kamu',
            'hp_number.required' => 'Silakan masukkan nomor hp Kamu',
            'hp_number.regex' => 'Silakan masukkan nomor telepon yang valid',
            'email.required' => 'Silakan masukkan email Kamu',
            'email.unique' => 'Alamat email sudah terdaftar',
            'email.email' => 'Silakan masukkan email yang valid',
            'password.required' => 'Silakan masukkan password Kamu',
            'password.min' => 'Password harus terdiri dari setidaknya 8 karakter',
        ]);

        if ($admin->password == $request->password) {
            $admin->name = $request->name;
            $admin->hp_number = $request->hp_number;
            $admin->location_id = $request->location_id;
            $admin->email = $request->email;
        } else {
            $admin->name = $request->name;
            $admin->hp_number = $request->hp_number;
            $admin->location_id = $request->location_id;
            $admin->email = $request->email;
            $admin->password = Hash::make($request->password);
        }

        $admin->update();

        session()->flash('message', 'Data admin ' . $admin->name . ' berhasil diubah');

        $url = '/' . auth()->user()->role . '/admin';
        return redirect($url);
    }

    public function deleteAdmin($id): RedirectResponse
    {
        $admin = User::findOrFail($id);

        $admin->delete();

        session()->flash('message', 'Admin ' . $admin->name . ' telah dihapus dari daftar');

        $url = '/' . auth()->user()->role . '/admin';
        return redirect($url);
    }

    // Restoring deleted admin
    public function restoreAdmin($id): RedirectResponse
    {
        $deletedAdmin = User::withTrashed()->find($id);
        $deletedAdmin->restore();

        session()->flash('message', 'Admin ' . $deletedAdmin->name . ' berhasil dikembalikan');

        $url = '/' . auth()->user()->role . '/admin';
        return redirect($url);
    }
}
