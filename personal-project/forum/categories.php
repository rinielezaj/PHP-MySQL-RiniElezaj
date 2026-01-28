<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

// Fetch categories
$stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
$categories = $stmt->fetchAll();
?>

<h1>Forum Categories</h1>
<a href="../public/index.php">Back to Dashboard</a>

<ul>
<?php foreach ($categories as $cat): ?>
    <li>
        <a href="threads.php?category_id=<?= $cat['id'] ?>">
            <?= htmlspecialchars($cat['name']) ?>
        </a>
        - <?= htmlspecialchars($cat['description']) ?>
    </li>
<?php endforeach; ?>
</ul>
