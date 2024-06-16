@extends('layouts.dashboard-volt')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

    <style>
        #map {
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tambah UMKM</div>
                    <div class="card-body">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Tambah UMKM Baru</div>
                    <div class="card-body">
                        <form action="{{ route('spot.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group ">
                                <label for="">Koordinat</label>
                                <input type="text" class="form-control @error('coordinate')
                                    is-invalid
                                @enderror" name="coordinate" id="coordinate">
                                @error('coordinate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group my-3">
                                <label for="">Nama UMKM</label>
                                <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" name="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="">Deskripsi</label>
                                <textarea name="description" id="" class="form-control @error('description')
                                    is-invalid
                                @enderror" cols="30" rows="10"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="category">Kategori</label>
                                <select name="category" id="category" class="form-control @error('category') is-invalid @enderror">
                                    <option value="">Pilih Kategori</option>
                                    <option value="Makanan">Makanan</option>
                                    <option value="Pangan">Pangan</option>
                                    <option value="Gas">Gas</option>
                                    <option value="Kendaraan">Kendaraan</option>
                                    <option value="Kerajinan">Kerajinan</option>
                                    <option value="Fashion">Fashion</option>
                                    <option value="Kecantikan">Kecantikan</option>
                                    <option value="Kantin Sekolah">Kantin Sekolah</option>
                                    <option value="Kuliner">Kuliner</option>
                                    <option value="Otomotif">Otomotif</option>
                                    <option value="Pendidikan">Pendidikan</option>
                                    <option value="PKL">PKL</option>
                                    <option value="Teknologi Internet">Teknologi Internet</option>
                                    <option value="Rumah/Warung Makan">Rumah/Warung Makan</option>
                                    <option value="Agrobisnis">Agrobisnis</option>
                                    <option value="Minuman">Minuman</option>
                                    <option value="Jasa">Jasa</option>
                                    <option value="Kesehatan">Kesehatan</option>
                                    <option value="Warung Sembako">Warung Sembako</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group my-3">
                                <label for="">Nama Pemilik</label>
                                <input type="text" class="form-control @error('nama_pemilik')
                                    is-invalid
                                @enderror" name="nama_pemilik">
                                @error('nama_pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="">Nomor Telepon</label>
                                <input type="text" class="form-control @error('nomor_telepon')
                                    is-invalid
                                @enderror" name="nomor_telepon">
                                @error('nomor_telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="">Alamat</label>
                                <textarea name="alamat" id="" class="form-control @error('alamat')
                                    is-invalid
                                @enderror" cols="30" rows="10"></textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="kecamatan">Kecamatan</label>
                                <select name="kecamatan" id="kecamatan" class="form-control @error('kecamatan') is-invalid @enderror">
                                    <option value="">Pilih Kecamatan</option>
                                    <option value="Bogor Selatan">Bogor Selatan</option>
                                    <option value="Bogor Timur">Bogor Timur</option>
                                    <option value="Bogor Tengah">Bogor Tengah</option>
                                    <option value="Bogor Barat">Bogor Barat</option>
                                    <option value="Bogor Utara">Bogor Utara</option>
                                    <option value="Tanah Sareal">Tanah Sareal</option>
                                </select>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            

                            {{-- <div class="form-group my-3">
                                <label for="">Upload Gambar</label>
                                <input type="file" class="form-control @error('image')
                                    is-invalid
                                @enderror" name="image" >
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}


                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-sm my-2">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('javascript')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
        integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
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
            zoom: 10,
            layers: [osm]
        })
        var marker = L.marker([{{ $centerPoint->coordinates }}], {
            draggable: true
        }).addTo(map);
        var baseMaps = {
            'Open Street Map': osm,
            'Esri World': Esri_WorldStreetMap,
            'Stadia Dark': Stadia_Dark
        }
        L.control.layers(baseMaps).addTo(map)
        // CARA PERTAMA
        function onMapClick(e) {
            var coords = document.querySelector("[name=coordinate]")
            var latitude = document.querySelector("[name=latitude]")
            var longitude = document.querySelector("[name=longitude]")
            var lat = e.latlng.lat
            var lng = e.latlng.lng
            if (!marker) {
                marker = L.marker(e.latlng).addTo(map)
            } else {
                marker.setLatLng(e.latlng)
            }
            coords.value = lat + "," + lng
            latitude.value = lat,
                longitude.value = lng
        }
        map.on('click', onMapClick)
        // CARA PERTAMA
        // CARA KEDUA
        marker.on('dragend', function() {
            var coordinate = marker.getLatLng();
            marker.setLatLng(coordinate, {
                draggable: true
            })
            $('#coordinate').val(coordinate.lat + "," + coordinate.lng).keyup()
            $('#latitude').val(coordinate.lat).keyup()
            $('#longitude').val(coordinate.lng).keyup()
        })
        // CARA KEDUA
    </script>
@endpush