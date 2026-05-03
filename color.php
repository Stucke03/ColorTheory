
<?php
$isPost = $_SERVER["REQUEST_METHOD"] === "POST";
$rowsCols = $_POST['size'] ?? '';
$numColors = $_POST['colors'] ?? '';

$errors = [
    'size' => '',
    'colors' => ''
];

if ($isPost) {

    if ($rowsCols === '' || !is_numeric($rowsCols) || $rowsCols < 1 || $rowsCols > 26) {
        $errors['size'] = "Rows and Columns must be between 1 and 26.";
    }

    if ($numColors === '' || !is_numeric($numColors) || $numColors < 1 || $numColors > 10) {
        $errors['colors'] = "Number of Colors must be between 1 and 10.";
    }

    if (empty($errors['size']) && empty($errors['colors'])) {
        $rowsCols = (int)$rowsCols;
        $numColors = (int)$numColors;
    }
}

$hasErrors = !empty($errors['size']) || !empty($errors['colors']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ColorTheory homepage</title>
    <meta name="authors" content="Nathan Stucke, Morgan Mitchell">
    <meta name="description" content="A homepage for the ColorTheory website">
    <meta name="keywords" content="Webpage, HTML5, Nathan Stucke, Morgan Mitchell, ColorTheory, CS312, Web Development, Colorado State University">
    <link rel="stylesheet" href="style-color.css">

    <script defer src="color.js"></script>
</head>

<body>
    <header>
        <img src=assets/nav-logo.png width="500">
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="color.php">Color Coordinates</a>
        <a href="colors.php">Color Selection</a>
    </header>
    <hr>
    <main>
    <form method="POST">
        <label>Rows and Columns 1-26:</label>
        <input type="number" name="size"
                value="<?= htmlspecialchars($rowsCols) ?>"
                class="<?= !empty($errors['size']) ? 'input-error' : '' ?>">

        <?php if ($errors['size']): ?>
            <div class="error"><?= $errors['size'] ?></div>
        <?php endif; ?>

        <label>Number of Colors 1-10:</label>
        <input type="number" name="colors"
                value="<?= htmlspecialchars($numColors) ?>"
                class="<?= !empty($errors['colors']) ? 'input-error' : '' ?>">

        <?php if ($errors['colors']): ?>
            <div class="error"><?= $errors['colors'] ?></div>
        <?php endif; ?>

        <button type="submit">Generate</button>
    </form>

    <?php if ($isPost && !$hasErrors): ?>

    <form method="POST" action="print.php" id="print-form">
        <input type="hidden" name="size" value="<?= htmlspecialchars($rowsCols) ?>">
        <input type="hidden" name="colors" value="<?= htmlspecialchars($numColors) ?>">
        <div id="hidden-color-inputs"></div>
        <button type="submit">Printable View</button>
    </form>

    <table class="color-table">
<?php
$colors = ["Red","Orange","Yellow","Green","Blue","Purple","Grey","Brown","Black","Teal"];

for ($i = 0; $i < $numColors; $i++): ?>
<tr>
    <td>
        <select class="color-dropdown">
            <?php foreach ($colors as $color): ?>
                <option value="<?= $color ?>" <?= $i === array_search($color, $colors) ? 'selected' : '' ?>><?= $color ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>

    <td class="radio-button">
        <input type="radio" name="selected_color" value="<?= $i ?>" <?= $i === 0 ? 'checked' : '' ?>>
    </td>

    <td class="color-preview coord-display"></td>
</tr>
<?php endfor; ?>
</table>

<div id="color-warning" class="message"></div>

<table id="grid" class="grid" data-size="<?= (int)$rowsCols ?>"></table>

<?php endif; ?>

</main>
</body>
</html>