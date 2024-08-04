<!-- map.blade.php -->
<div id="map" style="height: 400px; margin-top: 24px;"></div>

<script>
    var map = L.map('map').setView([-6.6003, 106.7972], 13);
    var baseLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    });

    map.addLayer(baseLayer);

    var currentMarker = L.marker([{{ old('coordinate', $spot->coordinate ?? '-6.6003, 106.7972') }}]).addTo(map);

    map.on('click', function(e) {
        var coord = e.latlng.lat + ', ' + e.latlng.lng;
        document.getElementById('coordinate').value = coord;
        if (currentMarker) {
            map.removeLayer(currentMarker);
        }
        currentMarker = L.marker(e.latlng).addTo(map);
    });
</script>
