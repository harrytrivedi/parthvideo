<?php
// Assuming you have already established a database connection
include_once '..//user/cryptoshow_db.php';

// Assuming you have retrieved the necessary data from the form submission
$event_id = $_POST['eventid'];
$event_title = $_POST['title'];
$fullname = $_POST['fullName'];
$username = $_POST['username'];
$items = $_POST['items'];
$status = 'pending'; // Assuming the status should be pending by default

// Fetch event details based on the event ID
$sql = "SELECT * FROM events WHERE eventid = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $event_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Check if the event details are fetched successfully
if ($row = mysqli_fetch_assoc($result)) {
    // Fetch additional event details
    $event_venue = $row['venue'];
    $event_image = $row['eventimage'];

    // Prepare the SQL query to insert into the bookings table
    $sql_insert = "INSERT INTO bookings (eventid, eventimage, fullname, username, venue, items, status, title) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = mysqli_prepare($conn, $sql_insert);
    mysqli_stmt_bind_param($stmt_insert, "isssssss", $event_id, $event_image, $fullname, $username, $event_venue, $items, $status, $event_title);

    // Execute the insertion query
    mysqli_stmt_execute($stmt_insert);

    // Check if the insertion was successful
    if (mysqli_stmt_affected_rows($stmt_insert) > 0) {
        // Insertion successful
        echo "Booking successful. Your booking ID is: " . mysqli_insert_id($conn);
    } else {
        // Insertion failed
        echo "Error: Unable to book event.";
    }

    // Close the statement
    mysqli_stmt_close($stmt_insert);
} else {
    // Event details not found
    echo "Error: Event details not found.";
}

// Close the connection
mysqli_close($conn);
?>
