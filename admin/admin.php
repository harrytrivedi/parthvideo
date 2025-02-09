<?php
include_once 'admin_header.php'
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parth Video - Admin Dashboard</title>
    <link rel="stylesheet" href="../css/admin_stylesheet.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
</head>

<body class="admin-body">

    <section class="admin-options">
        <div class="admin-option">
            <a href="admin_settings.php">
                <div class="icon">
                <img src="../user/images/admin_set.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>

        <div class="admin-option">
            <a href="create_event.php">
                <div class="icon">
                <img src="../user/images/add_event.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>

        <div class="admin-option">
            <a href="manageusers.php">
                <div class="icon">
                <img src="../user/images/manage_usr.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>

        <div class="admin-option">
            <a href="manageevents.php">
                <div class="icon">
                <img src="../user/images/manage_events.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>
