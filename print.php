<!--- /* At the bottom of the color coordinate page, add a button. When clicked, it takes the user to print.php. This page must:

Show the same two tables with the same dimensions and selected colors as the main page.
Display the selected color names as plain text in the cells where the dropdowns were.
Render in greyscale.
Include a greyscale version of your company logo and name as a header.
Be designed to easily print on one 8.5 x 11-inch page in portrait mode.*/ -->

<?php
$n = (int)($_POST['size'] ?? 3);
$numColors = (int)($_POST['colors'] ?? 1);
$selectedColors = $_POST['selected_colors'] ?? [];

$allColors = ["Red","Orange","Yellow","Green","Blue","Purple","Grey","Brown","Black","Teal"];

// Fill in defaults if selected_colors weren't passed
for ($i = count($selectedColors); $i < $numColors; $i++) {
    $selectedColors[] = $allColors[$i];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>ColorTheory - Print View</title>
    <style>
        * {
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body {
            background: white;
            color: black;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 16px;
            filter: grayscale(100%);
            width: 8.5in;
            box-sizing: border-box;
        }

        header {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
            border-bottom: 2px solid #555;
            padding-bottom: 8px;
        }

        header a{
            text-decoration: none;
        }

        header img {
            width: 120px;
        }

        header span {
            font-size: 22px;
            font-weight: bold;
            color: #222;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        td {
            border: 2px solid #555;
            text-align: center;
            padding: 4px;
        }

        .color-table td:first-child { 
            width: 20%; 
            font-weight: bold; 
        }

        .color-table td:last-child  { 
            width: 80%; 
        }

        .grid {
            width: auto;
        }

        .grid td {
            width: 30px;
            height: 30px;
            min-width: 30px;
            max-width: 30px;
            font-size: 13px;
        }

        .grid td:first-child,
        .grid tr:first-child td {
            background-color: #bbb;
            font-weight: bold;
        }

        .grid tr:first-child td:first-child {
            background-color: white;
        }

        @media print {
            body { padding: 0.25in; }
            button { display: none; }
        }
    </style>
</head>
<body>

<header>
    <img src="assets/nav-logo.png" alt="ColorTheory logo">
    <a href="color.php">Back to Color Coordinates</a>
    <span>ColorTheory</span>
</header>

<table class="color-table">
<?php for ($i = 0; $i < $numColors; $i++): ?>
<tr>
    <td><?= htmlspecialchars($selectedColors[$i]) ?></td>
    <td><?= htmlspecialchars($selectedColors[$i]) ?></td>
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