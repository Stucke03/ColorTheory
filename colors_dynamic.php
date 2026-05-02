<?php
header("Content-Type: text/css");
require 'db.php';

$result = $conn->query("SELECT * FROM colors");

while ($row = $result->fetch_assoc()) {
    $name = strtolower($row['name']);
    $hex = $row['hex_value'];

    echo ".color-$name { background-color: $hex; }\n";
}
?>