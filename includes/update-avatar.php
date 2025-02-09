<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['userid'])) {
    // Redirect the user to the login page
    header("Location: ../login.php");
    exit(); // Stop further execution of the script
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if an avatar file is selected
    if (!empty($_FILES["avatar"]["name"])) {
        // Define the target directory for avatar uploads
        $targetDir = '../user/images/uploads/';
        
        // Get the file name and temporary file location
        $avatarName = basename($_FILES["avatar"]["name"]);
        $avatarTmpName = $_FILES["avatar"]["tmp_name"];

        // Define the target file path
        $targetFilePath = $targetDir . $avatarName;

        // Check if the file is a valid image
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowedTypes)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($avatarTmpName, $targetFilePath)) {
                // Update the user's avatar in the database
                require_once '..//user/cryptoshow_db.php';
                $userId = $_SESSION['userid'];
                $sql = "UPDATE users SET avatar = ? WHERE userid = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "si", $avatarName, $userId);
                mysqli_stmt_execute($stmt);
                
                // Update the avatar session variable
                $_SESSION['avatar'] = $avatarName;
                
                // Redirect the user back to the account page with a success message
                header("Location: ../user/myaccount.php?success=1");
                exit();
            } else {
                // Error uploading the file
                header("Location: ../user/myaccount.php?error=upload");
                exit();
            }
        } else {
            // Invalid file type
            header("Location: ../user/myaccount.php?error=invalidtype");
            exit();
        }
    } else {
        // No file selected
        header("Location: ../user/myaccount.php?error=nofile");
        exit();
    }
} else {
    // Redirect to the myaccount.php page if accessed directly
    header("Location: ../user/myaccount.php");
    exit();
}
?>
