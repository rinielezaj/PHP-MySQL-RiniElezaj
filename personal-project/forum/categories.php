<?php
session_start();
require "../config/db.php";
require "../core/auth.php";

require_login();

/* Fetch categories */
$stmt = $pdo->prepare("SELECT * FROM categories");
$stmt->execute();
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title>Forum Categories</title>
  <link rel="stylesheet" href="../public/style.css">
</head>

<body>

<div class="navbar">
  <a href="../public/index.php">Dashboard</a>
  <a href="categories.php">Categories</a>
  <a href="../auth/logout.php">Logout</a>
</div>

<div class="container">

  <h1>🎵 Music Forum Categories</h1>
  <p class="meta">Pick a genre or discussion section below.</p>

  <?php foreach ($categories as $cat): ?>
    <div class="card">
      <h2>
        <a class="thread-title"
           href="threads.php?category_id=<?= $cat['id'] ?>">
          <?= htmlspecialchars($cat['name']) ?>
        </a>
      </h2>

      <p class="meta">
        <?= htmlspecialchars($cat['description']) ?>
      </p>
    </div>
  <?php endforeach; ?>

</div>

</body>
</html>
