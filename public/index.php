<?php
// Code source permettant d'accéder aux données parking du Grand Nancy
require '../vendor/autoload.php';
$pis = [];

$db = (new MongoDB\Client('mongodb://mongodb'))->selectDatabase('initmongodb');
$data = json_decode(file_get_contents('https://geoservices.grand-nancy.org/arcgis/rest/services/public/VOIRIE_Parking/MapServer/0/query?where=1%3D1&text=&objectIds=&time=&geometry=&geometryType=esriGeometryEnvelope&inSR=&spatialRel=esriSpatialRelIntersects&relationParam=&outFields=nom%2Cadresse%2Cplaces%2Ccapacite&returnGeometry=true&returnTrueCurves=false&maxAllowableOffset=&geometryPrecision=&outSR=4326&returnIdsOnly=false&returnCountOnly=false&orderByFields=&groupByFieldsForStatistics=&outStatistics=&returnZ=false&returnM=false&gdbVersion=&returnDistinctValues=false&resultOffset=&resultRecordCount=&queryByDistance=&returnExtentsOnly=false&datumTransformation=&parameterValues=&rangeValues=&f=pjson'));
$dbpis = $db->selectCollection('pis');
$count = $dbpis->countDocuments();
if ($count == 0) {
    foreach ($data->features as $feature) {
        $pi = [
            'name' => $feature->attributes->NOM,
            'address' => $feature->attributes->ADRESSE,
            'description' => '',
            'category' => [
                'name' => 'parking',
                'icon' => 'fa-square-parking',
                'color' => 'blue'
            ],
            'geometry' => $feature->geometry,
            'places' => $feature->attributes->PLACES,
            'capacity' => $feature->attributes->CAPACITE,
        ];
        $pis[] = $pi;
    }

    if (count($pis) > 0) {
        $res = $dbpis->insertMany($pis);
    }
} else {
    header("Location: index.html");
    exit();
}

// Ajouter une nouvelle collection pour les vélos
$db = (new MongoDB\Client('mongodb://mongodb'))->selectDatabase('initmongodb');
$data = json_decode(file_get_contents('https://api.jcdecaux.com/vls/v3/stations?apiKey=frifk0jbxfefqqniqez09tw4jvk37wyf823b5j1i&contract=nancy'));
$db = $db->selectCollection('bikes');
$count = $db->countDocuments();
if ($count == 0) {
    foreach ($data as $feature) {
        $bike = [
            'name' => $feature->name,
            'address' => $feature->address,
            'description' => '',
            'category' => [
                'name' => 'bike',
                'icon' => 'fa-bicycle',
                'color' => 'green'
            ],
            'position' => $feature->position,
            'bikeDisponible' => $feature->totalStands->availabilities->bikes,
            'capacity' => $feature->totalStands->capacity,
            'status' => $feature->status,
        ];
        $bikes[] = $bike;
    }

    if (count($bikes) > 0) {
        $res = $db->insertMany($bikes);
    }
} else {
    header("Location: index.html");
    exit();
}