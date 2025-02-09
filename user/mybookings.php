<?php
$pageTitle = "Bookings - Cryptoshow Society";
include_once '..//includes/header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    /* Table styles */
    .mybookings_container {
        width: 80%;
        padding: 30px;
        border-radius: 10px;
        /* box-shadow: 0 0 20px rgba(255, 255, 255, 0.466); Drop shadow effect */
        margin: auto;
        /* Center horizontally */
        justify-content: center;
        align-items: center;
        transition: opacity 0.5s ease;
        /* Add transition for opacity */
        opacity: 1;
        /* Ensure the default opacity is 1 */
    }

    .booking-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .booking-table th,
    .booking-table td {
        border: 1px solid #ffffff;
        /* White border */
        padding: 8px;
        text-align: left;
        font-family: "Poppins", sans-serif;
        /* Adjusted font family */
        font-weight: normal;
    }

    .booking-table th {
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        font-family: "Poppins", sans-serif;
        font-weight: bolder;
        font-style: normal;
        color: #ffffff;
        font-size: 22px;
        /* White text color */
    }

    .booking-table tr:hover {
        background-color: white;
        /* Dark gray background color on hover */
        color: black;
    }

    .delete-button {
        background-color: #ff0000;
        /* Red background color for delete button */
        color: #ffffff;
        /* White text color */
        border: none;
        padding: 8px 12px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        font-family: "Poppins", sans-serif;
        /* Adjusted font family */
        font-weight: bold;
    }

    .delete-button:hover {
        background-color: #ff6666;
        /* Light red background color on hover */
    }
</style>

<div class="mybookings_container">
    <h2>My Bookings</h2>
    <table class="booking-table">
        <thead>
            <tr>
                <th>Event Image</th>
                <th>Event Title</th>
                <th>Venue</th>
                <th>Status</th>
                <th>Action</th> <!-- New column for delete button -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection file
            include_once '..//user/cryptoshow_db.php';

            // Fetch bookings for the logged-in user
            $username = $_SESSION['username'];
            $sql = "SELECT * FROM bookings WHERE username = '$username'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td><img src='" . $row['eventimage'] . "' alt='Event Image' style='width:100px;height:auto;'></td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['venue'] . "</td>";
                    echo "<td>" . $row['status'] . "</td>";
                    echo "<td><button class='delete-button' onclick='deleteBooking(" . $row['bookingid'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    function deleteBooking(bookingId) {
        var confirmation = confirm("Are you sure you want to delete this booking?");
        if (confirmation) {
            // Redirect to delete_booking.php with the correct parameter name
            window.location.href = "..//includes/delete_booking.php?bookingid=" + bookingId;
        }
    }
</script>