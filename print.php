<?php 
$n = (int)($_POST['size'] ?? 3); 
$numColors = (int)($_POST['colors'] ?? 1); 
$selectedColors = $_POST['selected_colors'] ?? [];

$allColors = ["Red","Orange","Yellow","Green","Blue","Purple","Grey","Brown","Black","Teal"]; 

$colorMap = [ 
    "Red" => "#FF0000", 
    "Orange" => "#FFA500", 
    "Yellow" => "#FFFF00", 
    "Green" => "#008000", 
    "Blue" => "#0000FF", 
    "Purple" => "#800080", 
    "Grey" => "#808080", 
    "Brown" => "#A52A2A", 
    "Black" => "#000000", 
    "Teal" => "#008080" 
]; 

for ($i = count($selectedColors); $i < $numColors; $i++) { 
    $selectedColors[] = $allColors[$i]; 
} 

?> 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="utf-8"> 
    <title>ColorTheory - Print View</title> 
    <link rel="stylesheet" href="print.css"> 
    <script defer src="color.js"></script> 
</head> 

<body> 

<header> 
    <img src="assets/nav-logo.png" alt="ColorTheory logo"> 
    <a href="color.php">Back to Color Coordinates</a> 
    <span>ColorTheory</span> 
</header> 

<table class="color-table"> 
<?php for ($i = 0; $i < $numColors; $i++):
    $colorName = $selectedColors[$i];
    $hex = $colorMap[$colorName];
    ?>
<tr>
    <td><?= htmlspecialchars("$colorName --- $hex") ?></td>
    <td><?= htmlspecialchars(" ") ?></td>
</tr>
<?php endfor; ?>
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
            <?php for ($j = 1; $j <= $n; $j++): ?> 
                <td></td> 
            <?php endfor; ?> 
        </tr> 
    <?php endfor; ?> 
</table> 

<button onclick="window.print()">Print this page</button> 

</body> 
</html>