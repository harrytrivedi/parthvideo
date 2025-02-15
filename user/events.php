<!-- Events Page -->

<body class="events-body">
    <?php
    include_once '..//includes/header.php';
    ?>
    <section class="event-cards">
        <?php
        // Include the database connection file
        include_once 'cryptoshow_db.php';

        // Fetch events from the database
        $sql = "SELECT * FROM events";
        $result = mysqli_query($conn, $sql);

        // Check if there are any events
        if (mysqli_num_rows($result) > 0) {
            // Loop through each event and display it as a card
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="event-card">
                    <img src="<?php echo $row['eventimage']; ?>" alt="Event Image">
                    <div class="event-details">
                        <h2>
                            <?php echo $row['title']; ?>
                        </h2>
                        <p><strong>Date:</strong>
                            <?php echo $row['date']; ?>
                        </p>
                        <p><strong>Venue:</strong>
                            <?php echo $row['venue']; ?>
                        </p>
                        <p><strong>Capacity:</strong>
                            <?php echo $row['capacity']; ?>
                        </p>
                        <button><a href="booknow.php?event_id=<?php echo $row['eventid']; ?>">Book Now</a></button>

                    </div>
                </div>

                <?php
            }
        } else {
            echo "<p>No events found.</p>";
        }

        // Close the database connection
        mysqli_close($conn);
        ?>
    </section>
    <!-- Styling for hiding profile tab -->
    <style>
        /* Add custom styles for the dropdown */
        .auth-buttons a {
            display: flex;
            justify-content: center;
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
            /* font-size: inherit;
            font-weight: inherit; */
            transition: all 0.3s ease;
        }

        .auth-buttons .profile-icon {
            display: flex;
            margin-right: 5px;
        }

        /* Dropdown content styles */

        .dropdown-content a:first-child {
            margin-bottom: 5px;
            /* Add margin below "My Account" */
        }

        .dropdown-content {
            position: absolute;
            /*can make relative to look cooler */
            background-color: rgba(0, 0, 0, 0.8);
            /* Set background color */
            border-radius: 5px;
            padding: 5px 0;
            z-index: 1;
            display: none;
        }

        .dropdown-content a {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #ffffff;
            /* Set text color */
            transition: background-color 0.3s ease;
        }

        .dropdown-content a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            /* Change background color on hover */
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
    <?php include_once '../includes/footer.php'; ?>
    <script src="..//js/script.js"></script>
</body>


</html>