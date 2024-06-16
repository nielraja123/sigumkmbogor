<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Centre_Point;
use App\Models\Spot;
use App\Models\UMKM_Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk menggunakan DB

class DataController extends Controller
{
    public function centrepoint()
    {
        $centrepoint = Centre_Point::latest()->get();
        return datatables()->of($centrepoint)
        ->addColumn('action','backend.CentrePoint.action')
        ->addIndexColumn()
        ->rawColumns(['action'])
        ->toJson();
    }

    public function spot(Request $request)
    {
        $spot = Spot::query();
    
        if ($request->has('category') && $request->category != '') {
            $spot->where('category', $request->category);
        }
    
        if ($request->has('kecamatan') && $request->kecamatan != '') {
            $spot->where('kecamatan', $request->kecamatan);
        }
    
        return datatables()->of($spot->get())
            ->addColumn('action', 'backend.Spot.action')
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
    
    // public function spot()
    // {
    //     $spot = Spot::latest()->get();
    //     return datatables()->of($spot)
    //     ->addColumn('action','backend.Spot.action')
    //     ->addIndexColumn()
    //     ->rawColumns(['action'])
    //     ->toJson();
    // }
    public function daftarumkm()
    {
        $categories = Spot::select('category')->distinct()->get()->pluck('category');
        return view('daftarumkm', compact('categories'));
    }


    // test
    public function getUmkmStats(Request $request)
{
    $category = $request->input('category', 'Semua');
    $query = Spot::query();

    if ($category !== 'Semua') {
        $query->where('category', $category);
    }

    $totalUMKM = $query->count();

    $umkmPerKecamatan = $query->select('kecamatan', DB::raw('count(*) as jumlah'))
        ->groupBy('kecamatan')
        ->get()
        ->keyBy('kecamatan')
        ->map(function ($item) {
            // return $item->jumlah; // Mengambil nilai jumlah langsung dari objek stdClass
            return ['jumlah' => $item->jumlah];
        });

    $kecamatanList = ['Bogor Barat', 'Bogor Selatan', 'Bogor Tengah', 'Bogor Timur', 'Bogor Utara', 'Tanah Sareal'];
    foreach ($kecamatanList as $kecamatan) {
        if (!isset($umkmPerKecamatan[$kecamatan])) {
            $umkmPerKecamatan[$kecamatan] = ['jumlah' => 0];
            // $umkmPerKecamatan[$kecamatan] = 0; // Set nilai 0 jika tidak ada UMKM di kecamatan tersebut
        }
    }

    // Calculate rata-rata
    $rataRataUMKM = $totalUMKM / count($kecamatanList);

    // Calculate (xi - xbar)^2
    $sumOfSquares = 0;
    foreach ($umkmPerKecamatan as $kecamatan => $data) {
        $sumOfSquares += pow($data['jumlah'] - $rataRataUMKM, 2);
    }

    // Calculate standar deviasi
    $standarDeviasi = sqrt($sumOfSquares / (count($kecamatanList) - 1));

    // Calculate batas atas and batas bawah
    $batasAtas = $rataRataUMKM + (0.4 * $standarDeviasi);
    $batasBawah = $rataRataUMKM - (0.4 * $standarDeviasi);

    return response()->json([
        'totalUMKM' => $totalUMKM,
        'umkmPerKecamatan' => $umkmPerKecamatan,
        'rataRataUMKM' => $rataRataUMKM,
        'standarDeviasi' => $standarDeviasi,
        'batasAtas' => $batasAtas,
        'batasBawah' => $batasBawah,
    ]);
}

}