<?php
session_start();

// Include the PostgreSQL database connection file
require_once "cryptoshow_db.php";

// Initialize error array
$errors = array();

if (isset($_POST["submit"])) {
    // Trim inputs to remove accidental spaces
    $username = trim($_POST["username"]);
    $fullName = trim($_POST["fullname"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validate fields
    if (empty($username) || empty($fullName) || empty($email) || empty($password)) {
        $errors[] = "All fields are required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long";
    }

    // Check if email already exists using PostgreSQL
    $sql = "SELECT * FROM users WHERE email = $1";
    $result = pg_prepare($conn, "check_email", $sql);
    $result = pg_execute($conn, "check_email", array($email));
    $rowCount = pg_num_rows($result);
    if ($rowCount > 0) {
        $errors[] = "Email already exists!";
    }

    if (count($errors) == 0) {
        // Process file upload for avatar, if provided
        $avatar = "";
        if (isset($_FILES["avatar"]) && $_FILES["avatar"]["name"] != "") {
            $avatar = $_FILES["avatar"]["name"];
            $avatarTempName = $_FILES["avatar"]["tmp_name"];
            $avatarPath = '../user/images/uploads/' . $avatar;

            if (!move_uploaded_file($avatarTempName, $avatarPath)) {
                $errors[] = "Failed to upload avatar.";
            }
        }

        // Only proceed if there are still no errors
        if (count($errors) == 0) {
            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user into the database using PostgreSQL prepared statement
            $sql = "INSERT INTO users (username, fullname, email, password, avatar) VALUES ($1, $2, $3, $4, $5)";
            $result = pg_prepare($conn, "insert_user", $sql);
            $result = pg_execute($conn, "insert_user", array($username, $fullName, $email, $hashedPassword, $avatar));

            if ($result) {
                echo "<p>You are registered successfully.</p>";
            } else {
                $errors[] = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Parth Video</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
</head>

<script>
    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }
</script>

<body>
    <div class="container">
        <button id="modeToggle" class="night-mode-button"><i class="fa-solid fa-sun"></i> Light Mode </button>
        <div class="form-container">
            <h2>Register</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
                <label for="nickname">Username:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="name">Full Name:</label>
                <input type="text" id="name" name="fullname" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <label for="avatar">Avatar:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*"><br><br>

                <input type="submit" value="Register" name="submit">
            </form>

            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
        <div class="welcome-container">
            <!-- Add your logo and welcome text here -->
            <img class="logo_reglo" src="../user/images/logo-dark.png" alt="Parth Video Logo">
            <h3></h3>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>
