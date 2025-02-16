<?php
session_start(); // Start the session

// Function to check if the user is logged in
function isLoggedIn()
{
    return isset($_SESSION['userid']);
}

// Function to check if the user is an admin
function isAdmin()
{
    return (isset($_SESSION['level']) && $_SESSION['level'] == 1);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : "Parth Video"; ?></title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://kit.fontawesome.com/83ff50e3a5.js" crossorigin="anonymous"></script>
    <script src="..//js/script.js"> </script>

    <style>
        /* Hide the burger icon by default */
        .burger-icon {
            display: none;
        }

        .auth-buttons {
            display: flex;
            align-items: center;
        }

        /* Add a media query for smaller devices */
        @media only screen and (max-width: 768px) {

            .auth-buttons {
                display: none;
            }

            .auth-buttons.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 70px;
                /* Adjust as needed */
                right: 0;
                background-color: #333;
                /* Change the background color as needed */
                z-index: 99;
            }

            .burger-icon {
                display: block;
                font-size: 24px;
                /* Adjust as needed */
                margin-right: 40px;
                /* Adjust as needed */
                cursor: pointer;
            }

            .nav-links {
                display: none;
                flex-direction: column;
                align-items: center;
                width: 100%;
                position: absolute;
                top: 70px;
                /* Adjust as needed */
                left: 0;
                background-color: #333;
                /* Change the background color as needed */
                z-index: 99;
            }

            .nav-links.active {
                display: flex;
            }
        }

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
</head>

<body>

    <nav class="navbar">
        <div class="logo">
            <img src="../user/images/headerLogo.png" alt="Parth Video Logo">
        </div>

        <!-- Add the burger icon -->
        <div class="burger-icon">
            <i class="fa-solid fa-bars"></i>
        </div>

        <!-- Navigation links -->
        <ul class="nav-links">
            <li><a href="../user/index.php">Home</a></li>
            <li><a href="../user/aboutus.php">About Us</a></li>
            <li><a href="../user/events.php">Services</a></li>
            <li><a href="../user/members.php">Projects</a></li>
            <li><a href="../user/devices.php">Clients</a></li>
        </ul>

        <div class="auth-buttons">
            <?php
            if (isLoggedIn()) {
                echo '<div class="dropdown">';
                echo '<a href="myaccount.php" class="dropdown-toggle"><span class="profile-icon"><i class="fas fa-user-circle"></i></span>' . $_SESSION['username'] . '</a>';
                echo '<div class="dropdown-content">';
                echo '<a href="../user/myaccount.php">My Account</a>';
                echo '<a href="../includes/logout.php">Log Out</a>';
                echo '</div>';
                echo '</div>';
            } else {
                // echo '<a href="../user/login.php">Login</a>'; closed not required
                // echo '<a href="../user/register.php">Register</a>';
            }
            ?>
        </div>
    </nav>
    <script>
        // JavaScript to toggle the visibility of nav-links and auth-buttons
        document.addEventListener('DOMContentLoaded', function () {
            var burgerIcon = document.querySelector('.burger-icon');
            var navLinks = document.querySelector('.nav-links');
            var authButtons = document.querySelector('.auth-buttons');

            burgerIcon.addEventListener('click', function () {
                navLinks.classList.toggle('active');
                authButtons.classList.toggle('active');
            });
        });
    </script>
</body>

</html>