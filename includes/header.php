<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Recipes</title>
    <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <?php if (is_logged_in()): ?>
                <li><a href="logout.php">Logout</a></li>
            <?php else: ?>
                <li><a href="login.php">Login</a></li>
                <li><a href="register.php">Register</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
