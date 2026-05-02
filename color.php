

<?php
$rowsCols = $_POST['size'] ?? '';
$numColors = $_POST['colors'] ?? '';

$errors = [
    'size' => '',
    'colors' => ''
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

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

    <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        td {
            border: 1px solid black;
            text-align: center;
        }

        .color-table td:first-child { width: 20%; }
        .color-table td:last-child { width: 80%; }

        .grid td {
            width: 30px;
            height: 30px;
        }

        .error { color: red; }
        .message { color: orange; }
    </style>
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

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !$hasErrors): ?>
    <form method="POST" action="print.php" id="print-form">
        <input type="hidden" name="size" value="<?= htmlspecialchars($rowsCols) ?>">
        <input type="hidden" name="colors" value="<?= htmlspecialchars($numColors) ?>">
        <div id="hidden-color-inputs"></div>
        <button type="submit" onclick="collectColors()">Printable View</button>
    </form>

<script>
function collectColors() {
    const container = document.getElementById("hidden-color-inputs");
    container.innerHTML = "";
    document.querySelectorAll(".color-dropdown").forEach((drop, i) => {
        const input = document.createElement("input");
        input.type = "hidden";
        input.name = "selected_colors[]";
        input.value = drop.value;
        container.appendChild(input);
    });
}
</script>
<?php endif; ?>

    <main>
        <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        td {
            border: 3px solid #6689A1;
            text-align: center;
        }

        .color-table td:first-child {
            width: 20%;
        }

        .color-table td:last-child {
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
        }

        .error {
            color: red;
            margin: 5px 0;
        }

        .message {
            color: black;
        }

        .input-error {
            border: 2px solid red;
            background-color: #ffe6e6;
        }

        .radio-button {
            background-color: #6F4460;
        }

    </style>

    <?php if ($_SERVER["REQUEST_METHOD"] === "POST" && !$hasErrors): ?>

        <table class="color-table">
<?php
$colors = ["Red","Orange","Yellow","Green","Blue","Purple","Grey","Brown","Black","Teal"];

for ($i = 0; $i < $numColors; $i++):
?>
<tr>
    <td>
        <select class="color-dropdown">
            <?php foreach ($colors as $color): ?>
                <option value="<?= $color ?>" <?= $i === array_search($color, $colors) ? 'selected' : '' ?>>
                    <?= $color ?>
                </option>
            <?php endforeach; ?>
        </select>
    </td>
    <td class="radio-button">
        <input type="radio" name="selected_color" value="<?= $i ?>" <?= $i === 0 ? 'checked' : '' ?>>
    </td>
    <td class="color-preview"></td>
</tr>
<?php endfor; ?>
</table>

<div id="color-warning" class="message"></div>

<script>
const dropdowns = document.querySelectorAll(".color-dropdown");
const warning = document.getElementById("color-warning");

dropdowns.forEach(drop => {
    drop.dataset.previous = drop.value;

    drop.addEventListener("change", () => {
        const selectedValues = [];

        dropdowns.forEach(d => {
            if (d !== drop) selectedValues.push(d.value);
        });

        if (selectedValues.includes(drop.value)) {
            warning.textContent = "That color is already in use.";
            drop.value = drop.dataset.previous;
        } else {
            warning.textContent = "";
            drop.dataset.previous = drop.value;
        }

        updatePreviews();
    });
});

function updatePreviews() {
    document.querySelectorAll(".color-preview").forEach((cell, index) => {
        const color = dropdowns[index].value;
        cell.style.backgroundColor = color.toLowerCase();
    });
}

updatePreviews();
</script>

<table class="grid">
<?php
$n = (int)$rowsCols;

for ($i = 0; $i <= $n; $i++):
    echo "<tr>";

    for ($j = 0; $j <= $n; $j++) {

        if ($i === 0 && $j === 0) {
            echo "<td></td>";
        } elseif ($i === 0) {
            echo "<td>" . chr(64 + $j) . "</td>";
        } elseif ($j === 0) {
            echo "<td>$i</td>";
        } else {
            echo "<td></td>";
        }
    }

    echo "</tr>";
endfor;
?>
</table>

<?php endif; ?>
    </main>
</body>

</html>