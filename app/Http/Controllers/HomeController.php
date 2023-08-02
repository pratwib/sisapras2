<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function show(): View
    {
        return view('pages.home');
    }

    public function downloadSOP()
    {
        $fileName = "sop_peminjaman.pdf";
        $filePath = 'downloads/' . $fileName;

        if (Storage::exists($filePath)) {
            return response()->download(storage_path('app/' . $filePath));
        } else {
            abort(404, 'File not found');
        }
    }
}
