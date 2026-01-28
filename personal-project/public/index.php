<?php
require "../config/db.php";
require "../core/auth.php";

require_login();
?>

<h1>Welcome, <?= htmlspecialchars($_SESSION['username']) ?></h1>
<a href="../auth/logout.php">Logout</a>
<a href="../forum/categories.php">Go to Forum</a>
