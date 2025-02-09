<!-- admin_nav.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Parth Video"; ?></title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
    <script src="../js/script.js"> </script>
</head>

<body>

<nav class="navbar">
    <div class="logo">
        <img src="../user/images/headerLogo.png" alt="Parth Video Logo">
    </div>

    <div class="burger-icon">
        <i class="fa-solid fa-bars"></i>
    </div>

    <ul class="nav-links">
        <li><a href="admin.php">Home</a></li>
        <li><a href="admin_settings.php">Admin</a></li>
        <li><a href="create_event.php">Add Event</a></li>
        <li><a href="manageusers.php">Users</a></li>
        <li><a href="manageevents.php">Events</a></li>
    </ul>

    <div class="auth-buttons">
        <?php
        if (isLoggedIn()) {
            if (isAdmin()) {
                echo '<div class="dropdown">';
                echo '<a href="admin_settings.php" class="dropdown-toggle"><span class="profile-icon"><i class="fas fa-user-cog"></i></span>Admin</a>';
                echo '<div class="dropdown-content">';
                echo '<a href="admin_settings.php">Admin Settings</a>';
                echo '<a href="../includes/logout.php">Log Out</a>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="dropdown">';
                echo '<a href="myaccount.php" class="dropdown-toggle"><span class="profile-icon"><i class="fas fa-user-circle"></i></span>' . $_SESSION['username'] . '</a>';
                echo '<div class="dropdown-content">';
                echo '<a href="../user/myaccount.php">My Account</a>';
                echo '<a href="../includes/logout.php">Log Out</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<a href="../user/login.php">Login</a>';
            echo '<a href="../user/register.php">Register</a>';
        }
        ?>
    </div>
</nav>
</body>
</html>
