<?php
require "../config/db.php";
require "../core/auth.php";

require_login();

$category_id = $_GET["category_id"] ?? null;
if (!$category_id) die("No category selected.");

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);
    $user_id = $_SESSION["user_id"];

    if ($title && $content) {

        $stmt = $pdo->prepare("
            INSERT INTO threads (category_id, user_id, title, content)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$category_id, $user_id, $title, $content]);

        header("Location: threads.php?category_id=$category_id");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Create Thread</title>
  <link rel="stylesheet" href="../public/style.css">
</head>

<body>

<div class="navbar">
  <a href="threads.php?category_id=<?= $category_id ?>">← Back</a>
</div>

<div class="container">

  <h1>Create New Thread</h1>

  <form method="POST">

    <label>Title</label>
    <input type="text" name="title" required>

    <label>Content</label>
    <textarea name="content" rows="6" required></textarea>

    <button type="submit">Post Thread</button>

  </form>

</div>

</body>
</html>
