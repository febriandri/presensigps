<style>
#map { 
    height: 180px; 
}
</style>

<div id="map"></div>

<script>
    var lokasi = "{{ $presensi->lokasi_in }}";
    var lok = lokasi.split(",");
    var latitude = lok[0];
    var longitude = lok[1];

    var map = L.map('map').setView([latitude, longitude], 18);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([latitude, longitude]).addTo(map);

    var circle = L.circle([0.5224382,101.4406392], { //pengadilan
        color: 'red',
        fillColor: '#f03',
        fillOpacity: 0.5,
        radius: 40
    }).addTo(map);

    // var popup = L.popup()
    //     .setLatLng([latitude, longitude])
    //     .setContent("{{ $presensi->nama_lengkap }}")
    //     .openOn(map);
</script>