<?php
// Include database connection file
include_once '../user/cryptoshow_db.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user ID from form data
    $userid = $_POST['userid'];
    
    // Check if file was uploaded without errors
    if (isset($_FILES["avatar"]) && $_FILES["avatar"]["error"] == 0) {
        $file_name = $_FILES["avatar"]["name"];
        $temp_name = $_FILES["avatar"]["tmp_name"];
        $file_type = $_FILES["avatar"]["type"];

        // Set target directory
        $target_dir = "../user/images/uploads/";
        $target_file = $target_dir . basename($file_name);

        // Check file type
        $allowed_types = array("image/jpeg", "image/png", "image/gif");
        if (in_array($file_type, $allowed_types)) {
            // Move uploaded file to target directory
            if (move_uploaded_file($temp_name, $target_file)) {
                // Update user's avatar in the database
                $sql = "UPDATE users SET avatar='$file_name' WHERE userid='$userid'";
                if (mysqli_query($conn, $sql)) {
                    // Avatar updated successfully
                    $message = "Your avatar has been updated.";
                    // Redirect back to admin.php after a delay
                    header("refresh:2;url=../admin/admin.php");
                } else {
                    // Error updating avatar
                    $error_message = "Error updating avatar: " . mysqli_error($conn);
                }
            } else {
                // Error moving uploaded file
                $error_message = "Error uploading file.";
            }
        } else {
            // Invalid file type
            $error_message = "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        }
    } else {
        // No file uploaded or error occurred
        $error_message = "No file uploaded or an error occurred.";
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
    <title>Avatar Update</title>
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
