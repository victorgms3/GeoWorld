<?php
require_once 'header.php'; 
require_once 'inc/manager-db.php';

// Récupérer les données des pays
$countries = getAllCountries(); // Fonction qui retourne les pays avec leurs coordonnées
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte interactive</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        #map {
            height: 600px;
            width: 100%;
        }
    </style>
</head>
<body>
    <h1>Carte interactive des pays</h1>
    <div id="map"></div>

    <script>
        var map = L.map('map').setView([20, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Récupérer les données des pays depuis PHP
        var countries = <?php echo json_encode($countries); ?>;

        // Ajouter des marqueurs pour chaque pays
        countries.forEach(function(country) {
            L.marker([country.latitude, country.longitude])
                .addTo(map)
                .bindPopup(`<b>${country.Name}</b><br><a href="detailPays.php?id=${country.id}">Voir les détails</a>`)
                .on('click', function() {
                    window.location.href = `detailPays.php?id=${country.id}`;
                });
        });
    </script>
<?php 
require_once "javascripts.php";
require_once "footer.php"
?>
</body>
</html>