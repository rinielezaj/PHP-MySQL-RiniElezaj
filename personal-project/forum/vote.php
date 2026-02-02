<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

$user_id = $_SESSION["user_id"];

$thread_id = $_GET["thread_id"] ?? null;
$vote = $_GET["vote"] ?? null;

if (!$thread_id || !in_array($vote, [1, -1])) {
    die("Invalid vote.");
}

/* Insert or update vote */
$stmt = $pdo->prepare("
    INSERT INTO votes (user_id, thread_id, vote)
    VALUES (?, ?, ?)
    ON DUPLICATE KEY UPDATE vote = VALUES(vote)
");
$stmt->execute([$user_id, $thread_id, $vote]);

/* Redirect back */
header("Location: thread.php?thread_id=$thread_id");
exit;
