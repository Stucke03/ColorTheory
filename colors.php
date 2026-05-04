<?php
session_start();
require 'db.php';

$message = "";

// =====================
// ADD COLOR
// =====================
if (isset($_POST['add'])) {
    $name = trim($_POST['name']);
    $hex = trim($_POST['hex']);

    if ($name === "" || $hex === "") {
        $message = "Both name and hex value are required.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM colors WHERE name=? OR hex_value=?");
        $stmt->bind_param("ss", $name, $hex);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            $message = "Color name or hex value already exists.";
        } else {
            $stmt = $conn->prepare("INSERT INTO colors (name, hex_value) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $hex);
            $stmt->execute();
            $message = "Color added successfully.";
        }
    }
}

// =====================
// EDIT COLOR (supports partial updates)
// =====================
if (isset($_POST['edit'])) {
    $id = $_POST['edit_id'];
    $newName = trim($_POST['new_name']);
    $newHex = trim($_POST['new_hex']);

    // Get current values
    $stmt = $conn->prepare("SELECT name, hex_value FROM colors WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $current = $stmt->get_result()->fetch_assoc();

    $finalName = $newName !== "" ? $newName : $current['name'];
    $finalHex = $newHex !== "" ? $newHex : $current['hex_value'];

    // Check uniqueness excluding self
    $stmt = $conn->prepare(
        "SELECT id FROM colors WHERE (name=? OR hex_value=?) AND id != ?"
    );
    $stmt->bind_param("ssi", $finalName, $finalHex, $id);
    $stmt->execute();

    if ($stmt->get_result()->num_rows > 0) {
        $message = "Another color already uses that name or hex.";
    } else {
        $stmt = $conn->prepare(
            "UPDATE colors SET name=?, hex_value=? WHERE id=?"
        );
        $stmt->bind_param("ssi", $finalName, $finalHex, $id);
        $stmt->execute();
        $message = "Color updated successfully.";
    }
}

// =====================
// DELETE STEP 1
// =====================
if (isset($_POST['delete'])) {
    $_SESSION['delete_id'] = $_POST['delete_id'];
}

// =====================
// DELETE STEP 2
// =====================
if (isset($_POST['confirm_delete'])) {
    $count = $conn->query("SELECT COUNT(*) AS total FROM colors")
                  ->fetch_assoc()['total'];

    if ($count < 2) {
        $message = "Cannot delete: at least 2 colors must remain.";
    } else {
        $id = $_SESSION['delete_id'];
        $stmt = $conn->prepare("DELETE FROM colors WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        unset($_SESSION['delete_id']);
        $message = "Color deleted successfully.";
    }
}

// Cancel delete
if (isset($_POST['cancel_delete'])) {
    unset($_SESSION['delete_id']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Color Selection</title>
    <link rel="stylesheet" href="style-color.css">
    <style>
        .message { color: red; margin: 10px 0; }
        .section { margin-bottom: 30px; }
    </style>
</head>

<body>

<header>
    <img src="assets/nav-logo.png" width="500">
    <a href="index.php">Home</a>
    <a href="about.php">About</a>
    <a href="color.php">Color Coordinates</a>
    <a href="colors.php">Color Selection</a>
</header>

<hr>

<div class="message"><?= htmlspecialchars($message) ?></div>

<!-- ===================== -->
<!-- ADD COLOR -->
<!-- ===================== -->
<div class="section">
    <h2>Add Color</h2>
    <form method="POST">
        <input name="name" placeholder="Color Name">
        <input name="hex" placeholder="#RRGGBB">
        <button type="submit" name="add">Add</button>
    </form>
</div>

<!-- ===================== -->
<!-- EDIT COLOR -->
<!-- ===================== -->
<div class="section">
    <h2>Edit Color</h2>
    <form method="POST">
        <select name="edit_id">
            <?php
            $result = $conn->query("SELECT * FROM colors");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>
                        {$row['name']} ({$row['hex_value']})
                      </option>";
            }
            ?>
        </select>

        <input name="new_name" placeholder="New Name (optional)">
        <input name="new_hex" placeholder="New Hex (optional)">
        <button type="submit" name="edit">Update</button>
    </form>
</div>

<!-- ===================== -->
<!-- DELETE COLOR -->
<!-- ===================== -->
<div class="section">
    <h2>Delete Color</h2>

    <?php if (!isset($_SESSION['delete_id'])): ?>
        <form method="POST">
            <select name="delete_id">
                <?php
                $result = $conn->query("SELECT * FROM colors");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                }
                ?>
            </select>
            <button type="submit" name="delete">Delete</button>
        </form>

    <?php else: ?>
        <p>Are you sure you want to delete this color?</p>
        <form method="POST">
            <button name="confirm_delete">Yes, Delete</button>
        </form>
        <form method="POST">
            <button name="cancel_delete">Cancel</button>
        </form>
    <?php endif; ?>
</div>

<h2>Current Colors</h2>

<table border="1" cellpadding="8" style="border-collapse: collapse; width: 100%;">
    <tr>
        <th>Color Name</th>
        <th>Hex Value</th>
        <th>Preview</th>
    </tr>

    <?php
    $result = $conn->query("SELECT * FROM colors");

    while ($row = $result->fetch_assoc()):
        $name = htmlspecialchars($row['name']);
        $hex = htmlspecialchars($row['hex_value']);
    ?>
        <tr>
            <td><?= $name ?></td>
            <td><?= $hex ?></td>
            <td style="background-color: <?= $hex ?>;"></td>
        </tr>
    <?php endwhile; ?>
</table>

</body>
</html>