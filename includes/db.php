<?php


$host = "localhost:3307" ;
$db = "darshanrestaurant";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $db);

if (!$conn) {
    echo $conn->error;
}


?>
