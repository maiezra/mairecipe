<?php
include __DIR__ . '/includes/header.php';
?>

<h2>Search Recipes</h2>
<form id="searchForm" method="GET">
    <label for="search">Search for a recipe:</label>
    <input type="text" id="search" name="search" required>
    <button type="submit">Search</button>
</form>

<div id="results"></div>

<!-- Include JavaScript for API call -->
<script src="assets/js/search.js"></script>

<?php
include __DIR__ . '/includes/footer.php';
?>
