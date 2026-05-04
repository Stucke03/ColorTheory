<?php
$host = "";
$username = "";   // e.g. arefin or C8xxxxxxx
$password = ""; // your CS Linux password
$database = "";   // same as username

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>