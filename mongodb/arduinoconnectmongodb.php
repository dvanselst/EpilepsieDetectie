<?php
require_once '/usr/local/etc/php/8.2/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost:27017');
$database = $client->Arduino_Test_DB2;
$temperatuur = $_GET["temperature"];
$vochtigheid = $_GET["humidity"];
$hindex = $_GET["heat_index"];
$isaanval = $_GET["aanval"];
$collection = $database->data;
$datum = date("Y-m-d h:i:sa");
$insertOneResult = $insertOneResult = $collection->insertOne([
//    '_id' => getNextSequenceValue("productid"),
    //'date' => new MongoDate,
    'date' => $datum, 
    'temperature' => intval($temperatuur),
    'humidity' => intval($vochtigheid),
    'heat_index' => intval($hindex),
    'Aanval' => intval($isaanval),
    'sequence_value' => 0
    

]);
printf("Inserted %d document(s)\n", $insertOneResult->getInsertedCount());
?>
