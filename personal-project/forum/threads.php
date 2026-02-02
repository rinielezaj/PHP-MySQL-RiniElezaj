<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

/* Get category_id */
$category_id = $_GET["category_id"] ?? null;
if (!$category_id) die("No category selected.");

/* Fetch category */
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();

if (!$category) die("Category not found.");

/* Fetch threads + vote score */
$stmt = $pdo->prepare("
    SELECT threads.*, users.username,
    COALESCE(SUM(votes.vote), 0) AS score
    FROM threads
    JOIN users ON threads.user_id = users.id
    LEFT JOIN votes ON threads.id = votes.thread_id
    WHERE threads.category_id = ?
    GROUP BY threads.id
    ORDER BY score DESC, threads.created_at DESC
");
$stmt->execute([$category_id]);
$threads = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($category['name']) ?> Threads</title>
  <link rel="stylesheet" href="../public/style.css">
</head>

<body>

<div class="navbar">
  <a href="categories.php">← Back</a>
</div>

<div class="container">

  <h1><?= htmlspecialchars($category['name']) ?></h1>
  <p class="meta"><?= htmlspecialchars($category['description']) ?></p>

  <a href="create_thread.php?category_id=<?= $category_id ?>">
    <button>Create New Thread</button>
  </a>

  <hr>

  <?php if (empty($threads)): ?>
    <p>No threads yet. Be the first to post!</p>
  <?php else: ?>

    <?php foreach ($threads as $thread): ?>
      <div class="card">

        <p class="meta">⭐ Score: <?= $thread["score"] ?></p>

        <a class="thread-title"
           href="thread.php?thread_id=<?= $thread['id'] ?>">
          <?= htmlspecialchars($thread['title']) ?>
        </a>

        <p class="meta">
          Posted by <?= htmlspecialchars($thread['username']) ?>
          • <?= $thread['created_at'] ?>
        </p>

      </div>
    <?php endforeach; ?>

  <?php endif; ?>

</div>

</body>
</html>
