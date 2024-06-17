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
                        <h4>UMKM Mapping</h4>
                        {{-- <label for="category" class="form-label">Pilih Kategori</label> --}}
                        <select id="category" class="form-select"style="width: 200px;">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                        </div>
                    <div class="card-body">
                        <!-- Dropdown untuk kategori -->
                        <div class="mb-3">

                        </div>
                        <div id="map" style="height: 500px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('javascript')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script src="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.src.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@2.4.0/Control.FullScreen.min.js"></script>

    <script>
        var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });
        var Stadia_Dark = L.tileLayer(
            'https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}{r}.png', {
                maxZoom: 20,
                attribution: '&copy; <a href="https://stadiamaps.com/">Stadia Maps</a>, &copy; <a href="https://openmaptiles.org/">OpenMapTiles</a> &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
            });
        var Esri_WorldStreetMap = L.tileLayer(
            'https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ, USGS, Intermap, iPC, NRCAN, Esri Japan, METI, Esri China (Hong Kong), Esri (Thailand), TomTom, 2012'
            });
        
        var map = L.map('map', {
            center: [{{ $centerPoint->coordinates }}],
            zoom: 12,
            layers: [osm],
            fullscreenControl: {
                pseudoFullscreen: false
            }
        }).setView([-6.5951935, 106.791892], 12);

        const baseLayers = {
            'Openstreetmap': osm,
            'StadiaDark': Stadia_Dark,
            'Esri': Esri_WorldStreetMap
        };

        var markersLayer = new L.layerGroup().addTo(map);

        
        function updateMarkers(category) {
            markersLayer.clearLayers();
            @foreach ($spot as $item)
            if (category === "" || category === "{{ $item->category }}") {
                L.marker([{{ $item->coordinates }}])
                        .bindPopup(
                            // "<div class='my-2'><img src='{{ $item->getImageAsset() }}' class='img-fluid' width='700px'></div>" +
                            "<div class='my-2'><strong>Nama UMKM : </strong> <br>{{ $item->name }}</div>" +
                            "<div><a href='{{ route('detail-spot', $item->slug) }}' class='btn btn-outline-info'>Detail UMKM</a></div>"
                        )
                        .addTo(markersLayer);
                    }
            @endforeach
        }

        document.getElementById('category').addEventListener('change', function() {
            updateMarkers(this.value);
        });
        
        updateMarkers("");  // Initialize with all markers
        
        L.control.layers(baseLayers).addTo(map);
        </script>
@endpush
