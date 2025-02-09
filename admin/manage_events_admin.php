<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Only start session if it's not already started
}

$pageTitle = "Manage Event - Parth Video";
include_once 'admin_header.php'; // Make sure no output occurs before this line

// Check if eventid is provided
if (!isset($_GET['eventid'])) {
    header("Location: viewevents.php");
    exit();
}

$eventid = $_GET['eventid'];

// Fetch event details based on eventid
include_once 'connection.php';
$sql = "SELECT * FROM events WHERE eventid = ?";
$stmt = mysqli_stmt_init($conn);
if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $eventid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $event = mysqli_fetch_assoc($result);
    if (!$event) {
        // Event not found, redirect to viewevents.php
        header("Location: viewevents.php");
        exit();
    }
} else {
    // Error in preparing statement
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<div class="admin-container">
    <h2>Manage Event</h2>
    <form action="../includes/update_event_details.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="eventid" value="<?php echo htmlspecialchars($eventid); ?>">

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required>
        <br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($event['date']); ?>" required>
        <br><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" value="<?php echo htmlspecialchars($event['venue']); ?>" required>
        <br><br>

        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity" value="<?php echo htmlspecialchars($event['capacity']); ?>" required>
        <br><br>

        <label for="eventimage">Event Image:</label>
        <input type="file" name="eventimage" id="eventimage">
        <br><br>

        <input type="submit" value="Update Event">
    </form>
</div>
