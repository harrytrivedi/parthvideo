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
// Start the session before any output
session_start();

// Include the PostgreSQL database connection file
include_once 'cryptoshow_db.php';

// Initialize error variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username and password from the form, using PostgreSQL escaping
    $username = pg_escape_string($conn, $_POST['username']);
    $password = pg_escape_string($conn, $_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Query for admin users
        $sql_admin = "SELECT * FROM users WHERE username = $1 AND level = 1";
        // Prepare and execute the query
        $result_admin = pg_prepare($conn, "admin_query", $sql_admin);
        $result_admin = pg_execute($conn, "admin_query", array($username));
        $row_admin = pg_fetch_assoc($result_admin);

        // If admin found and password is correct
        if ($row_admin && password_verify($password, $row_admin['password'])) {
            $_SESSION['userid']   = $row_admin['userid'];
            $_SESSION['username'] = $row_admin['username'];
            $_SESSION['fullname'] = $row_admin['fullname'];
            $_SESSION['email']    = $row_admin['email'];
            $_SESSION['avatar']   = $row_admin['avatar'];
            header("Location: ../admin/admin.php");
            exit();
        }

        // Query for regular users
        $sql_user = "SELECT * FROM users WHERE username = $1 AND level = 0";
        $result_user = pg_prepare($conn, "user_query", $sql_user);
        $result_user = pg_execute($conn, "user_query", array($username));
        $row_user = pg_fetch_assoc($result_user);

        // If user found and password is correct
        if ($row_user && password_verify($password, $row_user['password'])) {
            $_SESSION['userid']   = $row_user['userid'];
            $_SESSION['username'] = $row_user['username'];
            $_SESSION['fullname'] = $row_user['fullname'];
            $_SESSION['email']    = $row_user['email'];
            $_SESSION['avatar']   = $row_user['avatar'];
            header("Location: index.php");
            exit();
        }

        // If no match found
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
            <h3></h3>
        </div>
    </div>
    <script src="../js/script.js"></script>
</body>

</html>