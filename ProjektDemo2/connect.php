<?php
$servername = "localhost";
$database = "myschema1";
$username = "root";
$password = "admin";

$conn = mysqli_connect($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>