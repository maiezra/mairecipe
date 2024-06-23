<?php
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <h2>Search Recipes</h2>
    <form id="searchForm" method="GET">
        <div class="form-group">
            <label for="search">Search for a recipe:</label>
            <input type="text" id="search" name="search" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <div id="results" class="mt-4"></div>
</div>

<!-- Include JavaScript for API call -->
<script src="assets/js/search.js"></script>

<?php
include __DIR__ . '/includes/footer.php';
?>
