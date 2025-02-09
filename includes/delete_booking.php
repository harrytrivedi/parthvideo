<?php
// Include database connection file
include_once '..//user/cryptoshow_db.php';

// Check if the booking ID is provided in the URL
if (isset($_GET['bookingid'])) {
    // Sanitize the input to prevent SQL injection
    $bookingId = mysqli_real_escape_string($conn, $_GET['bookingid']);

    // SQL query to delete the booking with the provided ID
    $sql = "DELETE FROM bookings WHERE bookingid = '$bookingId'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // If the deletion is successful, redirect back to the bookings page with a success message
        header("Location: ..//user/mybookings.php?message=success");
        exit();
    } else {
        // If there's an error with the deletion, redirect back to the bookings page with an error message
        header("Location: ..//user/mybookings.php?message=error");
        exit();
    }
} else {
    // If no booking ID is provided in the URL, redirect back to the bookings page
    header("Location: ..//user/mybookings.php");
    exit();
}
?>
