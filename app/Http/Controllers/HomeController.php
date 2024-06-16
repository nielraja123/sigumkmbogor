<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centre_Point;
use App\Models\Spot;
use App\Models\UMKM_Data;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk menggunakan DB

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function __construct()
    {
        $this->middleware('auth')->except(['spots']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
        // return view('frontend.home');
    }
    public function map()
    {
        return view('leaflet.map');
    }

    // testing shp file
    public function choropleth()
    {
        $geojsonPath = public_path('TESTDATAFORCHOROPLETH/map_line.json');
        $geojson = file_get_contents($geojsonPath);
    
        $csvPath = storage_path('TESTDATAFORCHOROPLETH/Demografi-Bogor.csv');
        $csv = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csv);
        $dataBogor = [];
        foreach ($csv as $row) {
            $dataBogor[] = array_combine($header, $row);
        }
        // Load category data
        $categoryCsvPath = storage_path('TESTDATAFORCHOROPLETH/kategori-jumlah.csv');
        $categoryCsv = array_map('str_getcsv', file($categoryCsvPath));
        $categoryHeader = array_shift($categoryCsv);
        $categoryData = [];
        foreach ($categoryCsv as $row) {
            $kategori = $row[1];
            $categoryData[$kategori] = [
                'ID3271010' => $row[2],
                'ID3271020' => $row[3],
                'ID3271040' => $row[4],
                'ID3271050' => $row[5],
                'ID3271030' => $row[6],
                'ID3271060' => $row[7],
            ];
        }
        // Load color threshold data
        $thresholdCsvPath = storage_path('TESTDATAFORCHOROPLETH/data-kategori.csv');
        $thresholdCsv = array_map('str_getcsv', file($thresholdCsvPath));
        $thresholdHeader = array_shift($thresholdCsv);
        $colorThresholds = [];
        foreach ($thresholdCsv as $row) {
            $kategori = $row[1];
            $colorThresholds[$kategori] = [
                'lower' => (float) $row[3],
                'upper' => (float) $row[4],
            ];
        }
        $categories = array_keys($categoryData);

        // Fetch UMKM data per kecamatan from spots table
    $totalUMKM = Spot::count();
    $umkmPerKecamatan = Spot::select('kecamatan', DB::raw('count(*) as jumlah'))
                            ->groupBy('kecamatan')
                            ->get()
                            ->keyBy('kecamatan')
                            ->toArray();
    
     // Calculate rata-rata
     $rataRataUMKM = $totalUMKM / 6;

     // Calculate (xi - xbar)^2
     $sumOfSquares = 0;
     foreach ($umkmPerKecamatan as $kecamatan => $data) {
        //  $sumOfSquares += pow($data['jumlah'] - $rataRataUMKM, 2);
         $sumOfSquares += pow($data['jumlah'] - $rataRataUMKM, 2);
     }

     // Calculate standar deviasi
     $standarDeviasi = sqrt($sumOfSquares / (6 - 1));

     // Calculate batas atas and batas bawah
     $batasAtas = $rataRataUMKM + (0.4 * $standarDeviasi);
     $batasBawah = $rataRataUMKM - (0.4 * $standarDeviasi);
     
     return view('leaflet.choropleth', compact(
         'geojson', 'dataBogor', 'categories', 'categoryData', 'colorThresholds', 
         'totalUMKM', 'umkmPerKecamatan', 'rataRataUMKM', 'standarDeviasi', 'batasAtas', 'batasBawah'
     ));
    }

    public function choroplethhome()
{
    $geojsonPath = public_path('TESTDATAFORCHOROPLETH/map_line.json');
    $geojson = file_get_contents($geojsonPath);

    $csvPath = storage_path('TESTDATAFORCHOROPLETH/Demografi-Bogor.csv');
    $csv = array_map('str_getcsv', file($csvPath));
    $header = array_shift($csv);
    $dataBogor = [];
    foreach ($csv as $row) {
        $dataBogor[] = array_combine($header, $row);
    }

    // Load category data
    $categoryCsvPath = storage_path('TESTDATAFORCHOROPLETH/kategori-jumlah.csv');
    $categoryCsv = array_map('str_getcsv', file($categoryCsvPath));
    $categoryHeader = array_shift($categoryCsv);
    $categoryData = [];
    foreach ($categoryCsv as $row) {
        $kategori = $row[1];
        $categoryData[$kategori] = [
            'ID3271010' => $row[2],
            'ID3271020' => $row[3],
            'ID3271040' => $row[4],
            'ID3271050' => $row[5],
            'ID3271030' => $row[6],
            'ID3271060' => $row[7],
        ];
    }

    // Load color threshold data
    $thresholdCsvPath = storage_path('TESTDATAFORCHOROPLETH/data-kategori.csv');
    $thresholdCsv = array_map('str_getcsv', file($thresholdCsvPath));
    $thresholdHeader = array_shift($thresholdCsv);
    $colorThresholds = [];
    foreach ($thresholdCsv as $row) {
        $kategori = $row[1];
        $colorThresholds[$kategori] = [
            'lower' => (float) $row[3],
            'upper' => (float) $row[4],
        ];
    }

    $categories = array_keys($categoryData);

    return view('frontend.choroplethhome', compact('geojson', 'dataBogor', 'categories', 'categoryData', 'colorThresholds'));
}

    // public function choroplethhome()
    // {
    // // Membaca data GeoJSON dan CSV
    // // $geojsonPath = public_path('TESTDATAFORCHOROPLETH/idn_admbnda_adm3_bps_20200401.json'); 
    //     $geojsonPath = public_path('TESTDATAFORCHOROPLETH/map_line.json'); // Path ke file GeoJSON
    //     $geojson = file_get_contents($geojsonPath);
    
    //     $csvPath = storage_path('TESTDATAFORCHOROPLETH/Demografi-Bogor.csv'); // Path ke file CSV
    //     $csv = array_map('str_getcsv', file($csvPath));
    //     $header = array_shift($csv);
    //     $dataBogor = [];
    //     foreach ($csv as $row) {
    //         $dataBogor[] = array_combine($header, $row);
    // }

    // return view('frontend.choroplethhome', compact('geojson', 'dataBogor'));
    // }

    // testing shp file
    
    public function spots()
    {
        $centerPoint = Centre_Point::first();
        $spot = Spot::all();
        $categories = Spot::select('category')->distinct()->get();
        
        return view('frontend.home', [
            'centerPoint' => $centerPoint,
            'spot' => $spot,
            'categories' => $categories,
    ]);
}
    
public function detailSpot($slug)
{
    $spot = Spot::where('slug',$slug)->first();
    return view('frontend.detail',['spot' => $spot]);
}
// public function spots()
    // {
    //     $centerPoint = Centre_Point::get()->first();
    //     $spot = Spot::get();

    //     return view('frontend.home',[
    //         'centerPoint' => $centerPoint,
    //         'spot' => $spot
    //     ]);
    // }

}


    // public function marker()
    // {
    //     return view('leaflet.marker');
    // }
    // public function circle()
    // {
    //     return view('leaflet.circle');
    // }
    // public function polygon()
    // {
    //     return view('leaflet.polygon');
    // }
    // public function polyline()
    // {
    //     return view('leaflet.polyline');
    // }
    // public function rectangle()
    // {
    //     return view('leaflet.rectangle');
    // }
    // public function layers()
    // {
    //     return view('leaflet.layer');
    // }
    // public function layer_group()
    // {
    //     return view('leaflet.layer_group');
    // }
    // public function geojson()
    // {
    //     return view('leaflet.geojson');
    // }
    // public function getCoordinate()
    // {
    //     return view('leaflet.get_coordinate');
    // }