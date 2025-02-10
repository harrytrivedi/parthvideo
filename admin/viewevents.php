<?php
$pageTitle = "View Events - Parth Video";
include_once 'admin_header.php'; 

?>

<style>
    /* Table styles */
    .events-container {
        margin-top: 50px;
        width: 80%;
        padding: 60px;
        border-radius: 10px;
    }

    .events-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .events-table th,
    .events-table td {
        border: 1px solid #ffffff;
        padding: 8px;
        text-align: left;
        font-family: "Poppins", sans-serif;
        font-weight: normal;
        font-size: 18px; /* Reduced font size for better readability on smaller screens */
    }

    .events-table th {
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        font-family: "Poppins", sans-serif;
        font-weight: bold;
        color: #ffffff;
        font-size: 22px; /* Increased font size for table headers */
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .events-container {
            width: 95%;
        }

        .events-table th,
        .events-table td {
            font-size: 14px; /* Adjusted font size for smaller screens */
            padding: 6px; /* Reduced padding for better spacing on smaller screens */
        }
    }

    @media screen and (max-width: 480px) {
        .events-table th,
        .events-table td {
            font-size: 12px; /* Further reduced font size for smaller screens */
            padding: 4px; /* Further reduced padding for better spacing on smaller screens */
        }
    }
</style>

<div class="events-container">
    <h2>View Events</h2>
    <table class="events-table">
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Event Title</th>
                <th>Venue</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection file
            include_once 'connection.php';

            // Fetch all events
            $sql = "SELECT * FROM events";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['eventid'] . "</td>";
                    echo "<td>" . $row['title'] . "</td>";
                    echo "<td>" . $row['venue'] . "</td>";
                    echo "<td>" . $row['capacity'] . "</td>";
                    echo "<td><a href='manage_events_admin.php?eventid=" . $row['eventid'] . "'>Manage</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No events found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

