<?php
$pageTitle = "Book Events - Cryptoshow Society";
include_once '..//includes/header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    h3 {
        color: transparent;
        /* Hide the original text color */
        margin-bottom: 20px;
        /* Add space below heading */
        align-items: center;
        font-family: "Poppins", sans-serif;
        font-weight: bolder;
        font-style: normal;
        font-size: 32px;
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        /* Gradient background for text */
        -webkit-background-clip: text;
        /* Apply the gradient to the text */
        background-clip: text;
        /* Apply the gradient to the text */
    }

    .event-details-box {
        max-width: 600px;
        margin-left: 30px;
        background-color: black;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(255, 255, 255, 0.5);
    }

    .event-details {
        text-align: center;
    }

    .event-details img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        margin-bottom: 10px;
    }
</style>
<div class="container">
    <div class="booking-form">
        <form action="..//includes/booknow_process.php" method="POST">
            <!-- Hidden field to store selected event ID -->
            <input type="hidden" id="eventid" name="eventid" value="<?php echo $_GET['event_id']; ?>">
            <!-- Remove duplicate input field for event title -->
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>" readonly required><br><br>
            <label for="fullName">Full Name:</label>
            <input type="text" id="fullName" name="fullName" value="<?php echo $_SESSION['fullname']; ?>" readonly required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>" readonly required><br><br>
            <!-- Add id attribute to the event title input field -->
            <label for="event">Event Title:</label>
            <!-- Event title field will be filled automatically based on user selection -->
            <input type="text" id="eventTitle" name="title" readonly required><br><br>
            <label for="items">Items:</label>
            <input type="text" id="items" name="items" rows="4" cols="50" placeholder="List the items you will bring with you"><br><br>
            <input type="submit" value="Book Now">
        </form>
    </div>
    <br>
    <div class="event-details-box">
        <?php
        include_once 'cryptoshow_db.php';
        // Check if the event ID is provided in the URL
        if (isset($_GET['event_id'])) {
            // Retrieve the event ID from the URL
            $event_id = $_GET['event_id'];

            // Fetch event details based on the event ID
            $sql = "SELECT * FROM events WHERE eventid = $event_id";
            $result = mysqli_query($conn, $sql);

            // Check if the event exists
            if (mysqli_num_rows($result) > 0) {
                // Fetch event details
                $row = mysqli_fetch_assoc($result);
                $event_title = $row['title'];
                $event_date = $row['date'];
                $event_venue = $row['venue'];
                $event_capacity = $row['capacity'];
                $event_image = $row['eventimage'];

                // Display event details
                echo '<div class="event-details">';
                echo '<img src="' . $event_image . '" alt="Event Image">';
                echo '<h3>' . $event_title . '</h3>';
                echo '<p><strong>Venue:</strong> ' . $event_venue . '</p>';
                echo '<p><strong>Capacity:</strong> ' . $event_capacity . '</p>';
                echo '</div>';

                // JavaScript to populate event title in the input field
                echo "<script>
                        document.getElementById('eventTitle').value = '$event_title';
                      </script>";
            } else {
                // Redirect to events.php if the event does not exist
                header("Location: events.php");
                exit();
            }
        }
        ?>
    </div>
</div>

<?php include_once '../includes/footer.php'; ?>

</body>
</html>