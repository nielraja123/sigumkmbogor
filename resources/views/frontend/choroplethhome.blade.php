@extends('layouts.frontend')

@section('css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet-search@3.0.9/dist/leaflet-search.src.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.fullscreen@2.4.0/Control.FullScreen.min.css">
@endsection

@section('content')
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Choropleth Persebaran UMKM</h4>
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
                        <p>Data diperbarui pada : 2 Juni 2024</p>
                        <div id="map" style="height: 500px"></div>
                      <div id="explanation" style="margin-top: 20px;"></div>
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