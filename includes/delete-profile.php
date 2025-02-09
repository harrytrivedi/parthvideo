<?php
session_start(); // Start the session

// Include the database connection file
include_once '../user/cryptoshow_db.php';

$userid = $_SESSION['userid'];

// Delete user's profile from the database
$sql = "DELETE FROM users WHERE userid='$userid'";

if (mysqli_query($conn, $sql)) {
    // Logout the user and redirect to the homepage after successful deletion
    session_unset();
    session_destroy();
    header("location: ../user/login.php");
    exit();
} else {
    // Handle error if deletion fails
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
