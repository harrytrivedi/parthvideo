<?php
include_once '../includes/user_session.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Devices - Cryptoshow</title>
    <link rel="stylesheet" href="../css/admin_stylesheet.css">
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
</head>

<body class="admin-body">

    <nav class="navbar">
        <div class="logo">
            <img src="../user/images/Cryptologo.png" alt="Cryptoshow Logo">
        </div>
        <div class="auth-buttons">
            <?php
            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                // If logged in, display the profile username with a Font Awesome icon and dropdown menu
                echo '<div class="dropdown">';
                echo '<a href="myaccount.php" class="dropdown-toggle"><span class="profile-icon"><i class="fas fa-user-circle"></i></span>' . $_SESSION['username'] . '</a>';
                echo '<div class="dropdown-content">';
                echo '<a href="../user/logout.php">Log Out</a>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </nav>

    <section class="admin-options">
        <div class="admin-option">
            <a href="mydevices.php">
                <div class="icon">
                <img src="../user/images/manage_devices.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>

        <div class="admin-option">
            <a href="manage_devices.php">
                <div class="icon">
                <img src="../user/images/add_devices.png" alt="Create Event Icon" >
                </div>
            </a>
        </div>
    </section>
    <script src="script.js"></script>
</body>

</html>
