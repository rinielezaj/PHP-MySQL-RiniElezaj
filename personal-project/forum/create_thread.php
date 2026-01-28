<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

$category_id = $_GET['category_id'] ?? null;
if (!$category_id) die("No category selected.");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $body = trim($_POST['body'] ?? '');
    
    if (!$title || !$body) {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO threads (category_id, user_id, title, body) VALUES (?, ?, ?, ?)");
        $stmt->execute([$category_id, $_SESSION['user_id'], $title, $body]);
        
        header("Location: threads.php?category_id=$category_id");
        exit;
    }
}
?>

<h1>Create Thread</h1>
<a href="threads.php?category_id=<?= htmlspecialchars($category_id) ?>">Back to Threads</a>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <input name="title" placeholder="Thread title" required><br>
    <textarea name="body" placeholder="Your post..." required></textarea><br>
    <button>Create Thread</button>
</form>
