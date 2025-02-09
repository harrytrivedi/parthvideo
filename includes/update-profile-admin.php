<?php
// Include database connection file
include_once '../user/cryptoshow_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from form data
    $userid = $_POST['userid'];
    
    // Validate user input
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update user's profile information
    $sql = "UPDATE users SET username='$username', fullname='$fullname', email='$email'";
    // Check if password is provided and update it if necessary
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql .= ", password='$hashed_password'";
    }
    $sql .= " WHERE userid='$userid'";

    if (mysqli_query($conn, $sql)) {
        // Profile updated successfully
        $message = "Your profile has been updated.";
        // Redirect back to admin.php after a delay
        header("refresh:2;url=../admin/admin.php");
    } else {
        // Error updating profile
        $error_message = "Error updating profile: " . mysqli_error($conn);
    }
} else {
    // Redirect to manage users page if form is not submitted
    header("Location: ../manageusers.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile Update</title>
    <!-- Add your CSS styles here -->
</head>
<body>
    <?php if (isset($message)): ?>
        <div class="success-message">
            <?php echo $message; ?>
            <a href="../admin/admin.php">Okay</a>
        </div>
    <?php elseif (isset($error_message)): ?>
        <div class="error-message">
            <?php echo $error_message; ?>
            <a href="../manageusers.php">Okay</a>
        </div>
    <?php endif; ?>
</body>
</html>
