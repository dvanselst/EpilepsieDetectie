<?php
$username = "danique";
$pass = "Testdatabase123!";
$host = "localhost";
$db_name = "Arduino_Test";
$con = mysqli_connect ($host, $username, $pass);
$db = mysqli_select_db ( $con, $db_name );
?>
