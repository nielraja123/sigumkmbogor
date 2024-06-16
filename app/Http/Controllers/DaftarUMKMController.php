<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Centre_Point;
use App\Models\Spot;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DaftarUMKMController extends Controller
{
    public function index()
    {
        $categories = Spot::select('category')->distinct()->get()->pluck('category');
        $kecamatans = Spot::select('kecamatan')->distinct()->get()->pluck('kecamatan');
    
        return view('frontend.daftarumkm', compact('categories', 'kecamatans'));
    }
}