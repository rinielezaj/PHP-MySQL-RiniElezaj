<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

$thread_id = $_GET["thread_id"] ?? null;
if (!$thread_id) die("No thread selected.");

/* Fetch thread + score */
$stmt = $pdo->prepare("
    SELECT threads.*, users.username,
    COALESCE(SUM(votes.vote), 0) AS score
    FROM threads
    JOIN users ON threads.user_id = users.id
    LEFT JOIN votes ON threads.id = votes.thread_id
    WHERE threads.id = ?
    GROUP BY threads.id
");
$stmt->execute([$thread_id]);
$thread = $stmt->fetch();

if (!$thread) die("Thread not found.");

/* Fetch replies */
$stmt = $pdo->prepare("
    SELECT replies.*, users.username
    FROM replies
    JOIN users ON replies.user_id = users.id
    WHERE replies.thread_id = ?
    ORDER BY replies.created_at ASC
");
$stmt->execute([$thread_id]);
$replies = $stmt->fetchAll();

/* Add reply */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $content = trim($_POST["content"]);
    $user_id = $_SESSION["user_id"];

    if ($content) {

        $stmt = $pdo->prepare("
            INSERT INTO replies (thread_id, user_id, content)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$thread_id, $user_id, $content]);

        header("Location: thread.php?thread_id=$thread_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title><?= htmlspecialchars($thread["title"]) ?></title>
  <link rel="stylesheet" href="../public/style.css">
</head>

<body>

<div class="navbar">
  <a href="threads.php?category_id=<?= $thread["category_id"] ?>">← Back</a>
</div>

<div class="container">

  <!-- Thread Post -->
  <div class="card">
    <h1><?= htmlspecialchars($thread["title"]) ?></h1>

    <p class="meta">
      Posted by <?= htmlspecialchars($thread["username"]) ?>
      • <?= $thread["created_at"] ?>
    </p>

    <p class="meta">⭐ Score: <?= $thread["score"] ?></p>

    <!-- Voting Buttons -->
    <a href="vote.php?thread_id=<?= $thread_id ?>&vote=1">
      <button>⬆ Upvote</button>
    </a>

    <a href="vote.php?thread_id=<?= $thread_id ?>&vote=-1">
      <button>⬇ Downvote</button>
    </a>

    <hr>

    <p><?= nl2br(htmlspecialchars($thread["content"])) ?></p>
  </div>

  <!-- Replies -->
  <h2>Replies</h2>

  <?php foreach ($replies as $reply): ?>
    <div class="card">
      <p><?= nl2br(htmlspecialchars($reply["content"])) ?></p>

      <p class="meta">
        Reply by <?= htmlspecialchars($reply["username"]) ?>
        • <?= $reply["created_at"] ?>
      </p>
    </div>
  <?php endforeach; ?>

  <!-- Reply Form -->
  <h2>Write a Reply</h2>

  <form method="POST">
    <textarea name="content" rows="4" required></textarea>
    <button type="submit">Post Reply</button>
  </form>

</div>

</body>
</html>
