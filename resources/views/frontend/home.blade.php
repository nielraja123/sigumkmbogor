<!-- resources/views/home.blade.php -->
@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.src.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@2.4.0/Control.FullScreen.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center mb-4">
            <div class="col-md-12 text-center">
                <img src="{{ asset('asset/img/messageImage_1717846776544.jpg') }}" alt="UMKM Mapping" style="max-width: 100%; height: auto;">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Peta UMKM Kota Bogor</h4>
                        @include('components.category-dropdown')
                    </div>
                    <div class="card-body">
                        @include('components.map')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
