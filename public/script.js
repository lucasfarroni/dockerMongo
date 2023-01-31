var map = L.map('map').setView([48.6880844, 6.1559293], 13);
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

// Requête AJAX pour récupérer les données depuis le script PHP
$.ajax({
    url: 'testInclude.php',
    dataType: 'json',
    success: function(data) {
        // Boucle sur les données de la base de données
        data.forEach(function(parking) {
            console.log(parking);
            var marker = L.marker([parking.geometry.y, parking.geometry.x]).addTo(map);
            marker.bindPopup(parking.name + "<br>" + parking.address + "<br>" + parking.places + "/" + parking.capacity);
        });
    }
});
