<?php
require 'includes/db.php';
require 'includes/functions.php';
include 'includes/header.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];

    $stmt = $conn->prepare("INSERT INTO recipes (user_id, title, ingredients, instructions) VALUES (:user_id, :title, :ingredients, :instructions)");
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':ingredients', $ingredients);
    $stmt->bindParam(':instructions', $instructions);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: Could not add recipe.";
    }
}
?>

<h2>Add Recipe</h2>
<form method="POST" action="">
    <label for="title">Title:</label>
    <input type="text" name="title" required>
    <label for="ingredients">Ingredients:</label>
    <textarea name="ingredients" required></textarea>
    <label for="instructions">Instructions:</label>
    <textarea name="instructions" required></textarea>
    <button type="submit">Add Recipe</button>
</form>

<?php include 'includes/footer.php'; ?>
