<?php
header("Content-Type: text/css");
require 'db.php';

// Get all colors from database
$result = $conn->query("SELECT name, hex_value FROM colors");

if ($result) {
    while ($row = $result->fetch_assoc()) {
        // Normalize name to safe CSS class format
        $className = strtolower(trim($row['name']));
        $className = preg_replace('/[^a-z0-9\-]/', '-', $className);

        $hex = trim($row['hex_value']);

        // Output CSS class
        echo ".color-$className {\n";
        echo "    background-color: $hex;\n";
        echo "}\n\n";
    }
}
?>