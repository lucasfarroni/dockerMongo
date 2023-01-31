<?php
require '../vendor/autoload.php';
// Connexion à la base de données MongoDB
$m = new MongoDB\Client('mongodb://mongodb');
$db = $m->selectDatabase('initmongodb');
$collection = $db->selectCollection('pis');

// Récupération des données depuis la collection
$parkingData = iterator_to_array($collection->find());


// Conversion des données en format JSON pour la transmission

$jsonData = json_encode($parkingData);

// Envoi des données en réponse à la requête AJAX
echo $jsonData;
?>
