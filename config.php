<?php
$host = 'localhost';
$db = 'db_bus';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error){
    die("Connection_error" . $conn->connect_error);
}
?>