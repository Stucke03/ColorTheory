<?php
header("Content-Type: text/css");
require 'db.php';

$result = $conn->query("SELECT name, hex_value FROM colors");

while ($row = $result->fetch_assoc()) {
    $class = strtolower($row['name']);
    $class = preg_replace('/[^a-z0-9]/', '-', $class);

    echo ".color-$class {\n";
    echo "    background-color: {$row['hex_value']};\n";
    echo "}\n\n";
}
?>