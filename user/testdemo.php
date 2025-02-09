<!-- registration.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Cryptoshow Society</title>
    <link rel="stylesheet" href="testdemoscript.css"> <!-- Link to your CSS file for styling -->
</head>
<body>

    <h2>Register</h2>

    <?php
    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $nickname = $_POST['nickname'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Note: Remember to hash passwords for security
        
        // Validate and sanitize input (you can add more validation as needed)
        // Here, we're assuming basic validation for demonstration purposes
        if (!empty($nickname) && !empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($password)) {
            // Add your database insert code here to insert user data into the 'registered_user' table
            
            // Redirect user to login page after successful registration
            header("Location: login.php");
            exit();
        } else {
            // Handle invalid input (e.g., display error message)
            echo "<p style='color: red;'>Invalid input. Please fill all fields correctly.</p>";
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <label for="nickname">Nickname:</label>
        <input type="text" id="nickname" name="nickname" required><br><br>

        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>

</body>
</html>
