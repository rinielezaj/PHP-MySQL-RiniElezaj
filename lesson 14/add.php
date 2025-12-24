<?php
include_once("config.php");

/* Fetch categories safely */
$categories = [];
$catStmt = $conn->prepare("SELECT id, name FROM categories");
$catStmt->execute();
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

/* Handle form submit */
if (isset($_POST['submit'])) {

    // Safety checks
    if (!isset($_POST['name']) || !isset($_POST['category_id'])) {
        die("Invalid form submission");
    }

    $name = trim($_POST['name']);
    $category_id = (int) $_POST['category_id'];

    if ($category_id === 0) {
        die("Please select a category");
    }

    $sql = "INSERT INTO products (name, category_id)
            VALUES (:name, :category_id)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
</head>
<body>

<h2>Add Product</h2>

<form method="POST" action="add.php">
    <input type="text" name="name" placeholder="Product name" required>

    <select name="category_id" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id']; ?>">
                <?= htmlspecialchars($cat['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="submit">Add</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
