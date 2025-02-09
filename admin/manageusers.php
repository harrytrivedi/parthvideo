<?php
$pageTitle = "Manage Users - Parth Video";
include_once 'admin_header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    /* Table styles */
    .manage-users-container {
        margin-top: 50px;
        width: 80%;
        padding: 60px;
        border-radius: 10px;
    }

    .manage-users-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .manage-users-table th,
    .manage-users-table td {
        border: 1px solid #ffffff;
        padding: 8px;
        text-align: left;
        font-family: "Poppins", sans-serif;
        font-weight: normal;
        font-size: 18px; /* Reduced font size for better readability on smaller screens */
    }

    .manage-users-table th {
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        font-family: "Poppins", sans-serif;
        font-weight: bold;
        color: #ffffff;
        font-size: 22px; /* Increased font size for table headers */
    }


    /* Avatar styles */
    .avatar-container {
        width: 100px;
        height: 100px;
        overflow: hidden;
    }

    .avatar-image {
        width: 100%;
        height: auto;
        border-radius: 50%;
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .manage-users-container {
            width: 95%;
        }

        .manage-users-table th,
        .manage-users-table td {
            font-size: 14px; /* Adjusted font size for smaller screens */
            padding: 6px; /* Reduced padding for better spacing on smaller screens */
        }
    }

    @media screen and (max-width: 480px) {
        .manage-users-table th,
        .manage-users-table td {
            font-size: 12px; /* Further reduced font size for smaller screens */
            padding: 4px; /* Further reduced padding for better spacing on smaller screens */
        }
    }
</style>

<div class="manage-users-container">
    <h2>Manage Users</h2>
    <table class="manage-users-table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Admin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection file
            include_once '../user/cryptoshow_db.php';

            // Fetch all users
            $sql = "SELECT userid, username, email, avatar, level FROM users";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // Display the circular avatar
                    echo "<td><div class='avatar-container'><img class='avatar-image' src='../user/images/uploads/" . $row['avatar'] . "' alt='Avatar'></div></td>";
                    echo "<td>" . $row['userid'] . "</td>";
                    echo "<td>" . $row['username'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    // Display Admin button if user is not admin
                    echo "<td>";
                    if ($row['level'] == 0) {
                        echo "<a href='../includes/makeadmin.php?userid=" . $row['userid'] . "'>Make Admin</a>";
                    } else {
                        echo "<a href='../includes/removeadmin.php?userid=" . $row['userid'] . "'>Remove Admin</a>";
                    }
                    echo "</td>";
                    // Display Manage button
                    echo "<td><a href='manage_user_admin.php?userid=" . $row['userid'] . "'>Manage</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
