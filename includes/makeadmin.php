<?php
// Include database connection file
include_once '../user/cryptoshow_db.php';

// Check if the userid parameter is set in the URL
if (isset($_GET['userid'])) {
    // Retrieve the userid from the URL parameter
    $userid = $_GET['userid'];

    // SQL query to update the user's level to 1 (admin)
    $sql = "UPDATE users SET level = 1 WHERE userid = ?";

    // Prepare the SQL statement
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        // Bind parameters and execute the statement
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);

        // Redirect back to the manageusers.php page after making the user an admin
        header("Location: ../admin/manageusers.php");
        exit();
    } else {
        // Error handling if the SQL statement fails
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect to the manageusers.php page if the userid parameter is not set
    header("Location: ../admin/manageusers.php");
    exit();
}
?>
