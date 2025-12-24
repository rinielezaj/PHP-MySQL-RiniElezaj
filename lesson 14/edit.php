<?php
include_once("config.php");

/* 1. Get product ID */
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];

/* 2. Fetch product */
$productSql = "SELECT * FROM products WHERE id = :id";
$productStmt = $conn->prepare($productSql);
$productStmt->bindParam(":id", $id, PDO::PARAM_INT);
$productStmt->execute();
$product = $productStmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("Product not found");
}

/* 3. Fetch categories */
$catSql = "SELECT id, name FROM categories";
$catStmt = $conn->prepare($catSql);
$catStmt->execute();
$categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

/* 4. Update product */
if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $category_id = (int) $_POST['category_id'];

    if ($category_id === 0) {
        die("Please select a category");
    }

    $updateSql = "UPDATE products 
                  SET name = :name, category_id = :category_id 
                  WHERE id = :id";

    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bindParam(":name", $name);
    $updateStmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
    $updateStmt->bindParam(":id", $id, PDO::PARAM_INT);
    $updateStmt->execute();

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
</head>
<body>

<h2>Edit Product</h2>

<form method="POST">
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']); ?>" required>

    <select name="category_id" required>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id']; ?>"
                <?= ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                <?= htmlspecialchars($cat['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" name="update">Update</button>
</form>

<br>
<a href="dashboard.php">Back to Dashboard</a>

</body>
</html>
