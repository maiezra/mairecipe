<?php
require __DIR__ . '/includes/db.php';
require __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $dietary_preferences = $_POST['dietary_preferences'];
    $allergies = $_POST['allergies'];
    $cooking_skill = $_POST['cooking_skill'];
    $cooking_frequency = $_POST['cooking_frequency'];
    $favorite_cuisine = $_POST['favorite_cuisine'];
    $dietary_restrictions = $_POST['dietary_restrictions'];
    $meal_preferences = implode(', ', $_POST['meal_preferences']);
    $newsletter = isset($_POST['newsletter']) ? 1 : 0;

    // Handle file upload
    $id_document = $_FILES['id_document'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($id_document["name"]);
    $upload_ok = 1;
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validate password confirmation
    if ($password != $confirm_password) {
        echo "Passwords do not match.";
        $upload_ok = 0;
    }

    // Check if file is an actual image or fake image
    $check = getimagesize($id_document["tmp_name"]);
    if($check !== false) {
        $upload_ok = 1;
    } else {
        echo "File is not an image.";
        $upload_ok = 0;
    }

    // Check file size
    if ($id_document["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $upload_ok = 0;
    }

    // Allow certain file formats
    if($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = 0;
    }

    // Check if $upload_ok is set to 0 by an error
    if ($upload_ok == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($id_document["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, birthdate, dietary_preferences, allergies, cooking_skill, cooking_frequency, favorite_cuisine, dietary_restrictions, meal_preferences, newsletter, id_document) VALUES (:username, :password, :email, :birthdate, :dietary_preferences, :allergies, :cooking_skill, :cooking_frequency, :favorite_cuisine, :dietary_restrictions, :meal_preferences, :newsletter, :id_document)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':birthdate', $birthdate);
            $stmt->bindParam(':dietary_preferences', $dietary_preferences);
            $stmt->bindParam(':allergies', $allergies);
            $stmt->bindParam(':cooking_skill', $cooking_skill);
            $stmt->bindParam(':cooking_frequency', $cooking_frequency);
            $stmt->bindParam(':favorite_cuisine', $favorite_cuisine);
            $stmt->bindParam(':dietary_restrictions', $dietary_restrictions);
            $stmt->bindParam(':meal_preferences', $meal_preferences);
            $stmt->bindParam(':newsletter', $newsletter);
            $stmt->bindParam(':id_document', $target_file);

            if ($stmt->execute()) {
                header("Location: login.php");
            } else {
                echo "Error: Could not register user.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>

<h2>Register</h2>
<form id="signUpForm" method="POST" action="" enctype="multipart/form-data">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required>
    <p class="comment">Must be at least 3 characters long.</p>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <p class="comment">Must be a valid email address (e.g., user@example.com).</p>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required>
    <p class="comment">Must be at least 8 characters long and include an uppercase letter, a number, and a special character.</p>

    <label for="confirm_password">Confirm Password:</label>
    <input type="password" id="confirm_password" name="confirm_password" required>
    <p class="comment">Must match the password entered above.</p>

    <label for="birthdate">Birthdate:</label>
    <input type="date" id="birthdate" name="birthdate" required>
    <p class="comment">You must be at least 13 years old to sign up.</p>

    <p class="info-text"><b>The next questions are for getting to know you to match recipes just for you:</b></p>

    <label for="dietary_preferences">Dietary Preferences:</label>
    <select id="dietary_preferences" name="dietary_preferences">
        <option value="none">None</option>
        <option value="vegetarian">Vegetarian</option>
        <option value="vegan">Vegan</option>
        <option value="gluten_free">Gluten-Free</option>
        <option value="keto">Keto</option>
        <option value="paleo">Paleo</option>
        <option value="pescatarian">Pescatarian</option>
        <option value="halal">Halal</option>
        <option value="kosher">Kosher</option>
    </select>

    <label for="allergies">Allergies:</label>
    <input type="text" id="allergies" name="allergies" placeholder="E.g., peanuts, shellfish">
    <p class="comment">Optional: List any allergies you have.</p>

    <label for="cooking_skill">Cooking Skill Level:</label>
    <select id="cooking_skill" name="cooking_skill">
        <option value="beginner">Beginner</option>
        <option value="intermediate">Intermediate</option>
        <option value="advanced">Advanced</option>
    </select>

    <label for="cooking_frequency">How often do you cook?</label>
    <select id="cooking_frequency" name="cooking_frequency">
        <option value="daily">Daily</option>
        <option value="few_times_week">A few times a week</option>
        <option value="once_week">Once a week</option>
        <option value="few_times_month">A few times a month</option>
        <option value="rarely">Rarely</option>
    </select>

    <label for="favorite_cuisine">Favorite Cuisine:</label>
    <select id="favorite_cuisine" name="favorite_cuisine">
        <option value="italian">Italian</option>
        <option value="chinese">Chinese</option>
        <option value="mexican">Mexican</option>
        <option value="indian">Indian</option>
        <option value="japanese">Japanese</option>
        <option value="mediterranean">Mediterranean</option>
        <option value="french">French</option>
        <option value="thai">Thai</option>
        <option value="american">American</option>
        <option value="other">Other</option>
    </select>

    <label for="dietary_restrictions">Do you have any dietary restrictions?</label>
    <select id="dietary_restrictions" name="dietary_restrictions">
        <option value="none">None</option>
        <option value="low_carb">Low Carb</option>
        <option value="low_fat">Low Fat</option>
        <option value="low_sodium">Low Sodium</option>
        <option value="low_sugar">Low Sugar</option>
    </select>

    <label for="meal_preferences">Preferred meal types:</label>
    <select id="meal_preferences" name="meal_preferences[]" multiple>
        <option value="breakfast">Breakfast</option>
        <option value="lunch">Lunch</option>
        <option value="dinner">Dinner</option>
        <option value="snack">Snack</option>
        <option value="dessert">Dessert</option>
        <option value="beverage">Beverage</option>
    </select>
    <p class="comment">Select your preferred meal types (hold Ctrl or Cmd to select multiple).</p>

    <label for="newsletter">Subscribe to our newsletter:</label>
    <input type="checkbox" id="newsletter" name="newsletter" value="yes">

    <label for="id_document">Upload ID Document:</label>
    <input type="file" name="id_document" required>

    <button type="submit">Sign Up</button>
</form>

<?php include __DIR__ . '/includes/footer.php'; ?>
