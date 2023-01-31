var map = L.map('map').setView([48.6880844, 6.1559293], 13);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

const markergreen = L.icon({
    iconUrl: './marker-green.png',
    iconSize: [25, 40],
    iconAnchor: [17, 40],
    popupAnchor: [-5, -40],
    shadowSize: [25, 40],
    shadowAnchor: [17, 40],
});

//Requête AJAX pour récupérer les données depuis le script PHP
$.ajax({
    url: 'testInclude.php',
    dataType: 'json',
    success: function (data) {
        // Boucle sur les données de la base de données
        data.forEach(function (parking) {
            //console.log(parking);
            var markerparking = L.marker([parking.geometry.y, parking.geometry.x]).addTo(map);
            markerparking.bindPopup("Parking voiture <br>" + parking.name + "<br>" + parking.address + "<br>" + parking.places + "/" + parking.capacity);
        });
    }
});

$.ajax({
    url: 'testvelo.php',
    dataType: 'json',
    success: function (data) {
        data.forEach(function (bike) {
            console.log(bike.position);

            var markervelo = L.marker([bike.position.latitude, bike.position.longitude],{icon: markergreen}).addTo(map);
            markervelo.bindPopup("VeloStan <br>" + bike.name + "<br>" + bike.address + "<br>" + bike.bikeDisponible + "/" + bike.capacity);
        });
    }
});
