@extends('layouts.dashboard-volt')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
        integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    <style>
        #map {
            height: 600px;
        }
    </style>
@endsection

@section('content')

<div class="container my-4">
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Choropleth Persebaran UMKM per 2 Juni 2024</h4>
                    {{--  --}}
                        <select id="categoryDropdown" class="form-select mb-3" style="width: 200px;">
                            <option value=""selected  disabled>Pilih Kategori UMKM</option>
                            <option value="Semua" >Semua</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    {{--  --}}
                    </div>
                    <div class="card-body">
                        <div id="map" style="height: 500px"></div>
                      <div id="explanation" style="margin-top: 20px;"></div>
                    </div>
                </div>
                {{-- <div class="card" style="margin-top: 20px;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Statistik UMKM Terdata</h4>
                    </div>
                    <div class="card-body">
                        <span><h5>Jumlah UMKM di terdata: {{ $totalUMKM }}</h5></span>
                        <ol>
                            <li>Bogor Barat: {{ $umkmPerKecamatan['Bogor Barat']['jumlah'] ?? 0 }}</li>
                            <li>Bogor Selatan: {{ $umkmPerKecamatan['Bogor Selatan']['jumlah'] ?? 0 }}</li>
                            <li>Bogor Tengah: {{ $umkmPerKecamatan['Bogor Tengah']['jumlah'] ?? 0 }}</li>
                            <li>Bogor Timur: {{ $umkmPerKecamatan['Bogor Timur']['jumlah'] ?? 0 }}</li>
                            <li>Bogor Utara: {{ $umkmPerKecamatan['Bogor Utara']['jumlah'] ?? 0 }}</li>
                            <li>Tanah Sareal: {{ $umkmPerKecamatan['Tanah Sareal']['jumlah'] ?? 0 }}</li>
                        </ol>
                        <h5>Perhitungan Klasifikasi</h5>
                        <ul>
                            <li>Rata-rata: {{ $rataRataUMKM }}</li>
                            <li>Standar Deviasi: {{ $standarDeviasi }}</li>
                            <li>Batas Atas: {{ $batasAtas }}</li>
                            <li>Batas Bawah: {{ $batasBawah }}</li>
                        </ul>
                    </div>
                </div> --}}
                <div class="card" style="margin-top: 20px;">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Statistik UMKM Terdata</h4>
                        <h5>Kategori UMKM : <span id="selectedCategory">Kategori</span></h5>
                        <select id="categoryDropdownStats" class="form-select mb-3" style="width: 200px;">
                            <option value="Semua">Semua</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-body">
                        <span><h5>Jumlah UMKM di terdata: <span id="totalUMKM">{{ $totalUMKM }}</span></h5></span>
                        
                        <ol id="umkmList">
                            <li>Bogor Barat: <span id="umkmBogorBarat">{{ $umkmPerKecamatan['Bogor Barat']['jumlah'] ?? 0 }}</span></li>
                            <li>Bogor Selatan: <span id="umkmBogorSelatan">{{ $umkmPerKecamatan['Bogor Selatan']['jumlah'] ?? 0 }}</span></li>
                            <li>Bogor Tengah: <span id="umkmBogorTengah">{{ $umkmPerKecamatan['Bogor Tengah']['jumlah'] ?? 0 }}</span></li>
                            <li>Bogor Timur: <span id="umkmBogorTimur">{{ $umkmPerKecamatan['Bogor Timur']['jumlah'] ?? 0 }}</span></li>
                            <li>Bogor Utara: <span id="umkmBogorUtara">{{ $umkmPerKecamatan['Bogor Utara']['jumlah'] ?? 0 }}</span></li>
                            <li>Tanah Sareal: <span id="umkmTanahSareal">{{ $umkmPerKecamatan['Tanah Sareal']['jumlah'] ?? 0 }}</span></li>
                        </ol>
                        <h5>Perhitungan Klasifikasi</h5>
                        <ul>
                            <li>Rata-rata : <span id="rataRataUMKM">{{ $rataRataUMKM }}</span></li>
                            <li>Standar Deviasi : <span id="standarDeviasi">{{ $standarDeviasi }}</span></li>
                            <li>Batas Atas : <span id="batasAtas">{{ $batasAtas }}</span></li>
                            <li>Batas Bawah : <span id="batasBawah">{{ $batasBawah }}</span></li>
                        </ul>
                        {{--  --}}
                        <h5>Pembagian Warna</h5>
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <div style="width: 30px; height: 30px; background-color: green; margin-right: 10px;"></div>
                            <div>
                                <strong>Zona Hijau :</strong> Jumlah UMKM > <span id="batasAtasHijau"></span><br>
                                Kecamatan : <span id="kecamatanHijau">Nama Kecamatan</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 10px;">
                            <div style="width: 30px; height: 30px; background-color: yellow; margin-right: 10px;"></div>
                            <div>
                                <strong>Zona Kuning :</strong> Jumlah UMKM < <span id="batasAtasKuning"></span> dan Jumlah UMKM > <span id="batasBawahKuning"></span><br>
                                Kecamatan : <span id="kecamatanKuning">Nama Kecamatan</span>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <div style="width: 30px; height: 30px; background-color: red; margin-right: 10px;"></div>
                            <div>
                                <strong>Zona Merah :</strong> Jumlah UMKM < <span id="batasBawahMerah"></span><br>
                                Kecamatan : <span id="kecamatanMerah">Nama Kecamatan</span>
                            </div>
                        </div>
                        {{--  --}}
                        <p style="color: red;margin-top: 50px;">Catatan : Data pada bagian ini diambil dari database</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('javascript')
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet-providers/1.5.0/leaflet-providers.js"></script>

<script>
// document.getElementById('categoryDropdownStats').addEventListener('change', function() {
//     const selectedCategory = this.value;
//     fetch(`{{ url('api/umkm-stats') }}?category=${selectedCategory}`)
//         .then(response => response.json())
//         .then(data => {
//             document.getElementById('totalUMKM').textContent = data.totalUMKM;
//             document.getElementById('umkmBogorBarat').textContent = data.umkmPerKecamatan['Bogor Barat'] ? data.umkmPerKecamatan['Bogor Barat'].jumlah : 0;
//             document.getElementById('umkmBogorSelatan').textContent = data.umkmPerKecamatan['Bogor Selatan'] ? data.umkmPerKecamatan['Bogor Selatan'].jumlah : 0;
//             document.getElementById('umkmBogorTengah').textContent = data.umkmPerKecamatan['Bogor Tengah'] ? data.umkmPerKecamatan['Bogor Tengah'].jumlah : 0;
//             document.getElementById('umkmBogorTimur').textContent = data.umkmPerKecamatan['Bogor Timur'] ? data.umkmPerKecamatan['Bogor Timur'].jumlah : 0;
//             document.getElementById('umkmBogorUtara').textContent = data.umkmPerKecamatan['Bogor Utara'] ? data.umkmPerKecamatan['Bogor Utara'].jumlah : 0;
//             document.getElementById('umkmTanahSareal').textContent = data.umkmPerKecamatan['Tanah Sareal'] ? data.umkmPerKecamatan['Tanah Sareal'].jumlah : 0;
//             document.getElementById('rataRataUMKM').textContent = data.rataRataUMKM;
//             document.getElementById('standarDeviasi').textContent = data.standarDeviasi;
//             document.getElementById('batasAtas').textContent = data.batasAtas;
//             document.getElementById('batasBawah').textContent = data.batasBawah;
//         });
// });

function updateStats(selectedCategory) {
    fetch(`{{ url('api/umkm-stats') }}?category=${selectedCategory}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalUMKM').textContent = data.totalUMKM;
            document.getElementById('umkmBogorBarat').textContent = data.umkmPerKecamatan['Bogor Barat'] ? data.umkmPerKecamatan['Bogor Barat'].jumlah : 0;
            document.getElementById('umkmBogorSelatan').textContent = data.umkmPerKecamatan['Bogor Selatan'] ? data.umkmPerKecamatan['Bogor Selatan'].jumlah : 0;
            document.getElementById('umkmBogorTengah').textContent = data.umkmPerKecamatan['Bogor Tengah'] ? data.umkmPerKecamatan['Bogor Tengah'].jumlah : 0;
            document.getElementById('umkmBogorTimur').textContent = data.umkmPerKecamatan['Bogor Timur'] ? data.umkmPerKecamatan['Bogor Timur'].jumlah : 0;
            document.getElementById('umkmBogorUtara').textContent = data.umkmPerKecamatan['Bogor Utara'] ? data.umkmPerKecamatan['Bogor Utara'].jumlah : 0;
            document.getElementById('umkmTanahSareal').textContent = data.umkmPerKecamatan['Tanah Sareal'] ? data.umkmPerKecamatan['Tanah Sareal'].jumlah : 0;
            document.getElementById('rataRataUMKM').textContent = data.rataRataUMKM;
            document.getElementById('standarDeviasi').textContent = data.standarDeviasi;
            document.getElementById('batasAtas').textContent = data.batasAtas;
            document.getElementById('batasBawah').textContent = data.batasBawah;

            document.getElementById('selectedCategory').textContent = selectedCategory;

            // Update batas atas dan bawah
            document.getElementById('batasAtasHijau').textContent = data.batasAtas;
            document.getElementById('batasAtasKuning').textContent = data.batasAtas;
            document.getElementById('batasBawahKuning').textContent = data.batasBawah;
            document.getElementById('batasBawahMerah').textContent = data.batasBawah;

            // Update kecamatan berdasarkan jumlah UMKM
            const kecamatanHijau = [];
            const kecamatanKuning = [];
            const kecamatanMerah = [];
            for (const [kecamatan, stats] of Object.entries(data.umkmPerKecamatan)) {
                if (stats.jumlah > data.batasAtas) {
                    kecamatanHijau.push(kecamatan);
                } else if (stats.jumlah < data.batasAtas && stats.jumlah > data.batasBawah) {
                    kecamatanKuning.push(kecamatan);
                } else {
                    kecamatanMerah.push(kecamatan);
                }
            }
            document.getElementById('kecamatanHijau').textContent = kecamatanHijau.join(', ') || 'Tidak ada';
            document.getElementById('kecamatanKuning').textContent = kecamatanKuning.join(', ') || 'Tidak ada';
            document.getElementById('kecamatanMerah').textContent = kecamatanMerah.join(', ') || 'Tidak ada';
        });
}

document.getElementById('categoryDropdownStats').addEventListener('change', function() {
    updateStats(this.value);
});

// Initial load
document.addEventListener('DOMContentLoaded', function() {
    updateStats('Semua');
});


// ddtest
      // Parse GeoJSON data from the server
      const geojsonData = {!! $geojson !!};
        const dataBogor = @json($dataBogor);
        const categoryData = @json($categoryData);
        const colorThresholds = @json($colorThresholds);

        const map = L.map('map').setView([-6.5951935, 106.791892], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let geoJsonLayer;

        function getDataByCode(code, category) {
            const data = categoryData[category];
            return data ? data[code] : null;
        }

        function getColor(value, category) {
            const thresholds = colorThresholds[category];
            return value > thresholds.upper ? '#00ff00' :
                   value > thresholds.lower ? '#ffff00' :
                   value > 0 ? '#ff0000' :
                   'transparent';
        }

        function style(feature, category) {
            const data = getDataByCode(feature.properties.ADM3_PCODE, category);
            const value = data ? parseInt(data, 10) : 0;
            return {
                fillColor: getColor(value, category),
                weight: 2,
                opacity: 1,
                color: 'white',
                dashArray: '3',
                fillOpacity: 0.7
            };
        }

        function onEachFeature(feature, layer, category) {
            const data = getDataByCode(feature.properties.ADM3_PCODE, category);
            if (data) {
                const popupContent = `
                    <b>Kecamatan: ${feature.properties.ADM3_EN}</b><br/>
                    Jumlah UMKM di kategori ${category}: ${data}
                `;
                layer.bindPopup(popupContent);
            }
        }

// 

function updateExplanation(category) {
            const explanationDiv = document.getElementById('explanation');
            let thresholds;

            // Set thresholds untuk kategori "Semua"
            if (category === 'Semua') {
                thresholds = {
                    upper: 1815,
                    lower: 1369
                };
            } else {
                thresholds = colorThresholds[category];
            }

            const explanationHtml = `
                <h4>Penjelasan</h4>
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div style="width: 20px; height: 20px; background-color: #00ff00; margin-right: 10px;"></div>
                    <span>Warna Hijau: Jumlah UMKM > ${thresholds.upper}</span>
                </div>
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div style="width: 20px; height: 20px; background-color: #ffff00; margin-right: 10px;"></div>
                    <span>Warna Kuning: Jumlah UMKM <= ${thresholds.upper} dan Jumlah UMKM > ${thresholds.lower}</span>
                </div>
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div style="width: 20px; height: 20px; background-color: #ff0000; margin-right: 10px;"></div>
                    <span>Warna Merah: Jumlah UMKM <= ${thresholds.lower}</span>
                </div>
                <h4>Daftar Jumlah UMKM per kecamatan${category === 'Semua' ? '' : ' dengan kategori ' + category}</h4>
                <ol>
                    ${category === 'Semua' ? `
                    <li>Bogor Barat : 1653</li>
                    <li>Bogor Selatan : 2091</li>
                    <li>Bogor Tengah : 2216</li>
                    <li>Bogor Timur : 1030</li>
                    <li>Bogor Utara : 1726</li>
                    <li>Tanah Sareal : 836</li>
                    ` : `
                    ${dataBogor.map(item => `<li>${item.Kecamatan} : ${getDataByCode(item.KodeBPS, category) || 0}</li>`).join('')}
                    `}
                </ol>
                `;

            explanationDiv.innerHTML = explanationHtml;
        }
        function updateMap(category) {
            if (geoJsonLayer) {
                map.removeLayer(geoJsonLayer);
            }
            geoJsonLayer = L.geoJson(geojsonData, {
                style: (feature) => style(feature, category),
                onEachFeature: (feature, layer) => onEachFeature(feature, layer, category)
            }).addTo(map);

            // 
            updateExplanation(category);
        }
        document.getElementById('categoryDropdown').addEventListener('change', function(e) {
            const category = e.target.value;
            if (category === "Semua") {
                updateMapForAll();
                updateExplanation(category);
            } else {
                updateMapForCategory(category);
                updateExplanation(category);
                }
            });
// 
document.addEventListener('DOMContentLoaded', function() {
                updateExplanation('Semua');
                updateMapForAll();
});

// 
function updateMapForAll() {
    if (geoJsonLayer) {
        map.removeLayer(geoJsonLayer);
    }
    geoJsonLayer = L.geoJson(geojsonData, {
        style: styleForAll,
        onEachFeature: onEachFeatureForAll
    }).addTo(map);
}

function updateMapForCategory(category) {
    if (geoJsonLayer) {
        map.removeLayer(geoJsonLayer);
    }
    geoJsonLayer = L.geoJson(geojsonData, {
        style: (feature) => style(feature, category),
        onEachFeature: (feature, layer) => onEachFeature(feature, layer, category)
    }).addTo(map);
}
function styleForAll(feature) {
    const code = feature.properties.ADM3_PCODE;
    const data = dataBogor.find(item => item.KodeBPS === code);
    const value = data ? parseInt(data.JumlahUMKM, 10) : 0;
    return {
        fillColor: getColorForAll(value),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}
function onEachFeatureForAll(feature, layer) {
    const code = feature.properties.ADM3_PCODE;
    const data = dataBogor.find(item => item.KodeBPS === code);
    if (data) {
        const popupContent = `
            <b>Kecamatan: ${feature.properties.ADM3_EN}</b><br/>
            Jumlah UMKM: ${data.JumlahUMKM}
        `;
        layer.bindPopup(popupContent);
    }
}
function getColorForAll(d) {
    return d > 1815   ? '#00ff00' :
           d > 1369   ? '#ffff00' :
           d > 0      ? '#ff0000' :
                        'transparent';
}
        const initialCategory = document.getElementById('categoryDropdown').options[1].value;
        updateMap(initialCategory);
    </script>
@endpush
