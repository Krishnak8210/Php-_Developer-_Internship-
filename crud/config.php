<?php
$host = "127.0.0.1";  // use 127.0.0.1 instead of localhost
$port = 3306;         // change if you are using a custom port
$user = "root";       
$pass = "";           
$dbname = "blog";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
