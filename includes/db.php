<?php


$host = "localhost:3307" ; // or localhost
$db = "darshanrestaurant";
$user = "root";
$password = "";

$conn = new mysqli($host, $user, $password, $db);

if (!$conn) {
    echo $conn->error;
}


?>
