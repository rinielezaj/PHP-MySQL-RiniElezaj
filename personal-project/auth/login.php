<?php
session_start();
require_once "../config/db.php";

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: ../public/index.php');
    exit;
}

$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username === '' || $password === '') {
        $error = "Enter both username and password.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header('Location: ../public/index.php');
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - My Forum</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #dae0e6;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}
.login-box {
    background: #fff;
    padding: 40px 30px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    width: 350px;
    text-align: center;
}
.login-box h2 { color: #ff4500; margin-bottom: 30px; }
.login-box input[type="text"], 
.login-box input[type="password"] {
    width: 100%;
    padding: 12px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
    font-size: 16px;
}
.login-box input[type="submit"] {
    width: 100%;
    padding: 12px;
    background: #ff4500;
    border: none;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
}
.login-box input[type="submit"]:hover { background: #e03d00; }
.error { color: #cc0000; margin-bottom: 15px; font-weight: bold; }
.login-footer { margin-top: 15px; font-size: 14px; }
.login-footer a { color: #0079d3; text-decoration: none; }
.login-footer a:hover { text-decoration: underline; }
</style>
</head>
<body>

<div class="login-box">
    <h2>Welcome Back</h2>

    <?php if (!empty($error)): ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Log In">
    </form>

    <div class="login-footer">
        Don't have an account? <a href="register.php">Sign Up</a>
    </div>
</div>

</body>
</html>
