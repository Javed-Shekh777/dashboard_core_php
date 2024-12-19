<?php
$hostname = "127.0.0.1";
$useranme = "root";
$password = "";
$dbName = "Ekana";
$port = 3307;

$conn = mysqli_connect($hostname, $useranme, $password, "", $port);

if ($conn) {
    $query = "CREATE DATABASE IF NOT EXISTS $dbName";

    $result  = mysqli_query($conn, $query);

    if (!$result) {
        echo "Database not created or not exists.";
    }
} else {
    die("MySQL Connect Error : " . mysqli_connect_error());
};

?>



 