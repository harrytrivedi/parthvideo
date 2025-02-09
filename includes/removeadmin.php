<?php
session_start();

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = '../login.php';</script>";
    exit(); // Stop further execution of the script
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['userid'])) {
    // Include database connection file
    include_once '../user/cryptoshow_db.php';

    // Sanitize user ID
    $userid = mysqli_real_escape_string($conn, $_GET['userid']);

    // Check if the user exists and is currently an admin
    $sql = "SELECT * FROM users WHERE userid = ? AND level = 1";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $userid);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            // Update user's level to 0 (remove admin privileges)
            $update_sql = "UPDATE users SET level = 0 WHERE userid = ?";
            $update_stmt = mysqli_stmt_init($conn);
            if (mysqli_stmt_prepare($update_stmt, $update_sql)) {
                mysqli_stmt_bind_param($update_stmt, "i", $userid);
                mysqli_stmt_execute($update_stmt);
                mysqli_stmt_close($update_stmt);
            }
        }
    }
    mysqli_stmt_close($stmt);
}

// Redirect back to the manage users page
header("Location: ../admin/manageusers.php");
exit();
?>
