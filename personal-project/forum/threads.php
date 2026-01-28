<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

// Get category ID from URL
$category_id = $_GET['category_id'] ?? null;
if (!$category_id) die("No category selected.");

// Fetch category info
$stmt = $pdo->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->execute([$category_id]);
$category = $stmt->fetch();
if (!$category) die("Category not found.");

// Fetch all threads in this category with author username
$stmt = $pdo->prepare("
    SELECT threads.*, users.username 
    FROM threads 
    JOIN users ON threads.user_id = users.id 
    WHERE category_id = ? 
    ORDER BY created_at DESC
");
$stmt->execute([$category_id]);
$threads = $stmt->fetchAll();
?>

<h1><?= htmlspecialchars($category['name']) ?> Threads</h1>

<a href="categories.php">Back to Categories</a> |
<a href="create_thread.php?category_id=<?= $category_id ?>">Create New Thread</a>

<?php if (empty($threads)): ?>
    <p>No threads yet. Be the first to create one!</p>
<?php else: ?>
    <ul>
    <?php foreach ($threads as $thread): ?>
        <li>
            <a href="thread.php?thread_id=<?= $thread['id'] ?>">
                <?= htmlspecialchars($thread['title']) ?>
            </a>
            by <?= htmlspecialchars($thread['username']) ?>
            <span style="color: gray;">(<?= $thread['created_at'] ?>)</span>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
