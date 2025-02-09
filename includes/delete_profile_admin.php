<?php
// Include database connection file
include_once '../user/cryptoshow_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from form data
    $userid = $_POST['userid'];

    // Delete user's profile from the database
    $sql = "DELETE FROM users WHERE userid='$userid'";

    if (mysqli_query($conn, $sql)) {
        // Profile deleted successfully
        $message = "User profile has been deleted.";
        // Redirect back to admin.php after a delay
        header("refresh:2;url=../admin/admin.php");
    } else {
        // Error deleting profile
        $error_message = "Error deleting profile: " . mysqli_error($conn);
    }
} else {
    // Redirect to manage users page if form is not submitted
    header("Location: ../admin/manageusers.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile Deletion</title>
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
