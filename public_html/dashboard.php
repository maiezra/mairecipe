<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

session_start();

if (!is_logged_in()) {
    header("Location: login.php");
    exit();
}

// You can add content specific to logged-in users here
?>

<h2>Welcome to your dashboard, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>

<?php include __DIR__ . '/includes/footer.php'; ?>
