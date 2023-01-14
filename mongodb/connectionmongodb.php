<?php
require_once '/usr/local/etc/php/8.2/vendor/autoload.php';
$client = new MongoDB\Client('mongodb://localhost:27017');
$database = $client->Arduino_Test_DB2;
?>