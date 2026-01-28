<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

$thread_id = $_GET['thread_id'] ?? null;
if (!$thread_id) die("No thread specified.");

// Fetch thread + author info
$stmt = $pdo->prepare("SELECT threads.*, users.username FROM threads JOIN users ON threads.user_id = users.id WHERE threads.id = ?");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch();
if (!$thread) die("Thread not found.");

// Fetch replies with author info
$stmt = $pdo->prepare("SELECT replies.*, users.username FROM replies JOIN users ON replies.user_id = users.id WHERE replies.thread_id = ? ORDER BY created_at ASC");
$stmt->execute([$thread_id]);
$replies = $stmt->fetchAll();

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $body = trim($_POST['body'] ?? '');
    if (!$body) {
        $error = "Reply cannot be empty.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO replies (thread_id, user_id, body) VALUES (?, ?, ?)");
        $stmt->execute([$thread_id, $_SESSION['user_id'], $body]);
        header("Location: thread.php?thread_id=$thread_id");
        exit;
    }
}
?>

<h1><?= htmlspecialchars($thread['title']) ?></h1>
<p>By <?= htmlspecialchars($thread['username']) ?> at <?= $thread['created_at'] ?></p>
<p><?= nl2br(htmlspecialchars($thread['body'])) ?></p>

<hr>

<h2>Replies</h2>

<?php foreach ($replies as $reply): ?>
    <div style="border-bottom:1px solid #ccc; margin-bottom: 10px; padding-bottom: 5px;">
        <p><strong><?= htmlspecialchars($reply['username']) ?></strong> at <?= $reply['created_at'] ?></p>
        <p><?= nl2br(htmlspecialchars($reply['body'])) ?></p>
    </div>
<?php endforeach; ?>

<hr>

<h3>Post a Reply</h3>

<?php if ($error): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form method="POST">
    <textarea name="body" rows="5" placeholder="Write your reply here..." required></textarea><br>
    <button>Submit Reply</button>
</form>

<a href="threads.php?category_id=<?= $thread['category_id'] ?>">Back to Threads</a>
