<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Parth Video</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
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
</head>

<body>
    <?php
    session_start(); // Start the session
    
    // Include the database connection file
    include_once 'cryptoshow_db.php';

    // Initialize error variable
    $error = "";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get username and password from the form
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if username or password is empty
        if (empty($username) || empty($password)) {
            $error = "Please enter both username and password";
        } else {
            // Query to check if the username and password match for admin
            $sql_admin = "SELECT * FROM users WHERE username=? AND level=1";
            $stmt_admin = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_admin, $sql_admin)) {
                mysqli_stmt_bind_param($stmt_admin, "s", $username);
                mysqli_stmt_execute($stmt_admin);
                $result_admin = mysqli_stmt_get_result($stmt_admin);
                $row_admin = mysqli_fetch_assoc($result_admin);

                // If result matched $username and $password for admin, table row must be 1 row
                if ($row_admin && password_verify($password, $row_admin['password'])) {
                    // Set session variables for admin
                    $_SESSION['userid'] = $row_admin['userid'];
                    $_SESSION['username'] = $row_admin['username'];
                    $_SESSION['fullname'] = $row_admin['fullname']; // Corrected variable name
                    $_SESSION['email'] = $row_admin['email']; // Corrected variable name
                    $_SESSION['avatar'] = $row_admin['avatar']; // Corrected variable name
                    // Redirect to admin page
                    header("location: ../admin/admin.php");
                    exit(); // Make sure to exit after redirection
                }
            }

            // Query to check if the username and password match for regular users
            $sql_user = "SELECT * FROM users WHERE username=? AND level=0";
            $stmt_user = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($stmt_user, $sql_user)) {
                mysqli_stmt_bind_param($stmt_user, "s", $username);
                mysqli_stmt_execute($stmt_user);
                $result_user = mysqli_stmt_get_result($stmt_user);
                $row_user = mysqli_fetch_assoc($result_user);

                // If result matched $username and $password for regular users, table row must be 1 row
                if ($row_user && password_verify($password, $row_user['password'])) {
                    // Set session variables for regular users
                    $_SESSION['userid'] = $row_user['userid'];
                    $_SESSION['username'] = $row_user['username'];
                    $_SESSION['fullname'] = $row_user['fullname'];
                    $_SESSION['email'] = $row_user['email'];
                    $_SESSION['avatar'] = $row_user['avatar'];

                    // Redirect to home page
                    header("location: index.php");
                    exit(); // Make sure to exit after redirection
                }

            }

            // If username or password is incorrect, display error message
            $error = "Invalid username or password";
        }
    }
    ?>

    <div class="container">
        <button id="modeToggle" class="night-mode-button"><i class="fa-solid fa-sun"></i> Light Mode </button>
        <div class="form-container">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="nickname">Username:</label>
                <input type="text" id="username" name="username" required>
                <br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <!-- Add the "Show Password" checkbox -->
                <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
                <label for="showPasswordCheckbox">Show Password</label>
                <br><br>

                <input type="submit" value="Login">
                <?php if (!empty($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>

            </form>
            <p>Don't have an account? <a href="registration.php">Register here</a>.</p>
        </div>
        <div class="welcome-container">
            <img class="logo_reglo" src="../user/images/logo-dark.png" alt="Parth Video Logo">
            <h3>Welcome to Parth Video!</h3>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>