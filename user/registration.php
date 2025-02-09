<!-- Registration Page -->
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
            <?php
            if (isset($_POST["submit"])) {
                $username = $_POST["username"];
                $fullName = $_POST["fullname"];
                $email = $_POST["email"];
                $password = $_POST["password"];

                $errors = array();

                if (empty($username) or empty($fullName) or empty($email) or empty($password)) {
                    array_push($errors, "All fields are required");
                }
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }
                if (strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }
                require_once "cryptoshow_db.php";
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $rowCount = mysqli_num_rows($result);

                if (empty($fullName)) {
                    array_push($errors, "Full Name is required");
                }
                if ($rowCount > 0) {
                    array_push($errors, "Email already exists!");
                }

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                } else {
                    $avatar = $_FILES["avatar"]["name"];
                    $avatarTempName = $_FILES["avatar"]["tmp_name"];
                    $avatarPath = '../user/images/uploads/' . $avatar;

                    if (move_uploaded_file($avatarTempName, $avatarPath)) {
                        // Store avatar information in session
                        $_SESSION['avatar'] = $avatar;
                        
                        // Hash the password
                        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                        $sql = "INSERT INTO users (username, fullname, email, password, avatar) VALUES (?, ?, ?, ?, ?)";
                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "sssss", $username, $fullName, $email, $hashedPassword, $avatar);
                        mysqli_stmt_execute($stmt);
                        echo "<p>You are registered successfully.</p>";
                    } else {
                        echo "Failed to upload avatar.";
                    }
                    
                }
            }
            ?>
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
