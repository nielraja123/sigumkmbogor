<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Centre_Point;
use App\Models\Spot;
use App\Models\UMKM_Data;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['spots']);
    }

    public function index()
    {
        return view('home');
    }

    public function map()
    {
        return view('leaflet.map');
    }

    public function choropleth()
    {
        $geojson = $this->loadGeojson('TESTDATAFORCHOROPLETH/map_line.json');
        $dataBogor = $this->loadCsvData('TESTDATAFORCHOROPLETH/Demografi-Bogor.csv');
        $categoryData = $this->loadCategoryData('TESTDATAFORCHOROPLETH/kategori-jumlah.csv');
        $colorThresholds = $this->loadColorThresholds('TESTDATAFORCHOROPLETH/data-kategori.csv');
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
        foreach ($umkmPerKecamatan as $data) {
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
        $geojson = $this->loadGeojson('TESTDATAFORCHOROPLETH/map_line.json');
        $dataBogor = $this->loadCsvData('TESTDATAFORCHOROPLETH/Demografi-Bogor.csv');
        $categoryData = $this->loadCategoryData('TESTDATAFORCHOROPLETH/kategori-jumlah.csv');
        $colorThresholds = $this->loadColorThresholds('TESTDATAFORCHOROPLETH/data-kategori.csv');
        $categories = array_keys($categoryData);

        return view('frontend.choroplethhome', compact('geojson', 'dataBogor', 'categories', 'categoryData', 'colorThresholds'));
    }

    public function spots()
    {
        $centerPoint = Centre_Point::first();
        $spots = Spot::all();
        $categories = Spot::select('category')->distinct()->get();

        return view('frontend.home', [
            'centerPoint' => $centerPoint,
            'spot' => $spots,
            'categories' => $categories,
        ]);
    }

    public function detailSpot($slug)
    {
        $spot = Spot::where('slug', $slug)->first();
        return view('frontend.detail', ['spot' => $spot]);
    }

    // Helper function to load GeoJSON
    private function loadGeojson($path)
    {
        $geojsonPath = public_path($path);
        return file_get_contents($geojsonPath);
    }

    // Helper function to load CSV data
    private function loadCsvData($path)
    {
        $csvPath = storage_path($path);
        $csv = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csv);
        $data = [];
        foreach ($csv as $row) {
            $data[] = array_combine($header, $row);
        }
        return $data;
    }

    // Helper function to load category data
    private function loadCategoryData($path)
    {
        $csvPath = storage_path($path);
        $csv = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csv);
        $data = [];
        foreach ($csv as $row) {
            $kategori = $row[1];
            $data[$kategori] = [
                'ID3271010' => $row[2],
                'ID3271020' => $row[3],
                'ID3271040' => $row[4],
                'ID3271050' => $row[5],
                'ID3271030' => $row[6],
                'ID3271060' => $row[7],
            ];
        }
        return $data;
    }

    // Helper function to load color thresholds
    private function loadColorThresholds($path)
    {
        $csvPath = storage_path($path);
        $csv = array_map('str_getcsv', file($csvPath));
        $header = array_shift($csv);
        $data = [];
        foreach ($csv as $row) {
            $kategori = $row[1];
            $data[$kategori] = [
                'lower' => (float) $row[3],
                'upper' => (float) $row[4],
            ];
        }
        return $data;
    }
}
