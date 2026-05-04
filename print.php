<?php
$n          = (int)($_POST['size']   ?? 3);
$numColors  = (int)($_POST['colors'] ?? 1);

$colorMap = [
    "red"    => "#FF0000",
    "orange" => "#FFA500",
    "yellow" => "#FFFF00",
    "green"  => "#008000",
    "blue"   => "#0000FF",
    "purple" => "#800080",
    "grey"   => "#808080",
    "brown"  => "#A52A2A",
    "black"  => "#000000",
    "teal"   => "#008080"
];

// Parse each row_i input sent by preparePrintData()
// Format: "colorname|coord1, coord2, ..."
$rows = [];
for ($i = 0; $i < $numColors; $i++) {
    $raw = $_POST['row_' . $i] ?? '';
    if ($raw === '') continue;

    $parts  = explode('|', $raw, 2);
    $color  = strtolower(trim($parts[0]));
    $coords = isset($parts[1]) ? trim($parts[1]) : '';
    $hex    = $colorMap[$color] ?? '#cccccc';

    $rows[] = [
        'color'  => ucfirst($color),
        'hex'    => $hex,
        'coords' => $coords,
    ];
}

// Build a lookup: coord -> hex for coloring the grid
$coordColor = [];
foreach ($rows as $row) {
    if ($row['coords'] === '') continue;
    foreach (explode(',', $row['coords']) as $coord) {
        $coord = trim($coord);
        if ($coord !== '') {
            $coordColor[$coord] = $row['hex'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ColorTheory - Print View</title>
    <link rel="stylesheet" href="print.css">
</head>

<body>

<header>
    <img src="assets/nav-logo.png" alt="ColorTheory logo">
    <a href="color.php">Back to Color Coordinates</a>
    <span>ColorTheory</span>
</header>

<table class="color-table">
<?php foreach ($rows as $row): ?>
<tr>
    <td style="background-color: white; color: black; padding: 4px 8px;">
        <?= htmlspecialchars($row['color']) ?> &mdash; <?= htmlspecialchars($row['hex']) ?>
    </td>
    <td style="background-color: white; color: black; padding: 4px 8px;">
        <?= htmlspecialchars($row['coords']) ?>
    </td>
</tr>
<?php endforeach; ?>
</table>

<table class="grid">
    <tr>
        <td></td>
        <?php for ($j = 1; $j <= $n; $j++): ?>
            <td><?= chr(64 + $j) ?></td>
        <?php endfor; ?>
    </tr>

    <?php for ($i = 1; $i <= $n; $i++): ?>
        <tr>
            <td><?= $i ?></td>
            <?php for ($j = 1; $j <= $n; $j++):
                $coord = chr(64 + $j) . $i;
                $bg    = $coordColor[$coord] ?? '';
                $style = $bg ? " style=\"background-color: {$bg};\"" : '';
            ?>
                <td></td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>

<button onclick="window.print()">Print this page</button>

</body>
</html>