<?php

use Illuminate\Support\Facades\Route;
// Route beranda tanpa middleware auth
Route::get('/', [\App\Http\Controllers\HomeController::class, 'spots']);

// Route yang dilindungi oleh middleware auth
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/detail-spot/{slug}',[\App\Http\Controllers\HomeController::class,'detailSpot'])->name('detail-spot');
    Route::get('/choroplethhome', [App\Http\Controllers\HomeController::class, 'choroplethhome'])->name('choroplethhome');
    
    // Testing filter
    Route::get('/daftarumkm/data', [\App\Http\Controllers\Backend\DataController::class, 'spot'])->name('spot.data');
    Route::resource('daftarumkm', \App\Http\Controllers\DaftarUMKMController::class);

    // Route Datatable (Dashboard Manage Data)
    Route::get('/centre-point/data', [\App\Http\Controllers\Backend\DataController::class, 'centrepoint'])->name('centre-point.data');
    Route::resource('centre-point', \App\Http\Controllers\Backend\CentrePointController::class);
    
    
    Route::get('/umkm_data/data', [\App\Http\Controllers\Backend\DataController::class, 'umkm_data'])->name('umkm_data.data');
    Route::get('/spot/data', [\App\Http\Controllers\Backend\DataController::class, 'spot'])->name('spot.data');
    Route::resource('spot', \App\Http\Controllers\Backend\SpotController::class);
     // ROUTES DIBAWAH INI HANYA BISA DIAKSES ADMIN
     Route::middleware(['admin'])->group(function () {
        Route::get('/choropleth', [App\Http\Controllers\HomeController::class, 'choropleth'])->name('choropleth');
        // vvvv
        Route::get('api/umkm-stats', [\App\Http\Controllers\Backend\DataController::class, 'getUmkmStats']);
        // ^^^^
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
        Route::post('/users/{user}/toggle-admin', [App\Http\Controllers\UserController::class, 'toggleAdmin'])->name('user.toggleAdmin');
    });
});

Auth::routes();













// Route::get('/map', [App\Http\Controllers\HomeController::class, 'map'])->name('map');
// Route::get('/marker', [App\Http\Controllers\HomeController::class, 'marker'])->name('marker');
// Route::get('/circle', [App\Http\Controllers\HomeController::class, 'circle'])->name('circle');
// Route::get('/polygon', [App\Http\Controllers\HomeController::class, 'polygon'])->name('polygon');
// Route::get('/polyline', [App\Http\Controllers\HomeController::class, 'polyline'])->name('polyline');
// Route::get('/rectangle', [App\Http\Controllers\HomeController::class, 'rectangle'])->name('rectangle');
// Route::get('/layer', [App\Http\Controllers\HomeController::class, 'layers'])->name('layer');
// Route::get('/layer-group', [App\Http\Controllers\HomeController::class, 'layer_group'])->name('layer-group');
// Route::get('/geojson', [App\Http\Controllers\HomeController::class, 'geojson'])->name('geojson');
// Route::get('/get-coordinate', [App\Http\Controllers\HomeController::class, 'getCoordinate'])->name('getCoordinate');
