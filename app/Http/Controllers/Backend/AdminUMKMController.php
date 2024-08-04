<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Centre_Point;
use App\Models\Spot;
use App\Models\UMKM_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk menggunakan DB
class AdminUMKMController extends Controller
{
    public function index()
    {
        $umkms = Spot::where('confirmed', false)->get();
        return view('backend.admin.umkm.index', compact('umkms'));
    }

    public function confirm($id)
    {
        $umkm = Spot::findOrFail($id);
        $umkm->confirmed = true;
        $umkm->save();

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil dikonfirmasi.');
    }
}
