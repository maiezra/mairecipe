<?php
require 'includes/db.php';
require 'includes/functions.php';
include 'includes/header.php';

session_start();

$stmt = $conn->prepare("SELECT r.title, r.ingredients, r.instructions, u.username FROM recipes r JOIN users u ON r.user_id = u.id");
$stmt->execute();
$recipes = $stmt->fetchAll();
?>

<h2>Recipes</h2>
<a href="recipe_add.php">Add Recipe</a>
<ul>
    <?php foreach ($recipes as $recipe): ?>
        <li>
            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
            <p>By: <?php echo htmlspecialchars($recipe['username']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>
            <p><?php echo nl2br(htmlspecialchars($recipe['instructions'])); ?></p>
        </li>
    <?php endforeach; ?>
</ul>

<?php include 'includes/footer.php'; ?>
