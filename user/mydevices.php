<?php
$pageTitle = "My Devices - Cryptoshow Society";
include_once '..//includes/header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    /* Table styles */
    .devices-container {
        width: 80%;
        padding: 30px;
        border-radius: 10px;
        margin-top: 60px;
    }

    .devices-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
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

    .update-button {
        background-color: white;
        /* Red background color for delete button */
        color: blue;
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

    .update-button:hover {
        background-color: #ff6666;
        color: white;
        /* Light red background color on hover */
    }

    .devices-table th,
    .devices-table td {
        border: 1px solid #ffffff;
        padding: 8px;
        text-align: left;
        font-family: "Poppins", sans-serif;
        font-weight: normal;
        font-size: 18px;
    }

    .devices-table th {
        background: linear-gradient(to right, #c400ff, #5ecfff, #0af8ff);
        font-family: "Poppins", sans-serif;
        font-weight: bolder;
        color: #ffffff;
        font-size: 22px;
    }

    .devices-table tr:hover {
        background-color: white;
        color: black;
    }

    /* Responsive styles */
    @media screen and (max-width: 768px) {
        .devices-container {
            width: 95%;
        }

        .devices-table th,
        .devices-table td {
            font-size: 16px;
        }
    }

    @media screen and (max-width: 480px) {

        .devices-table th,
        .devices-table td {
            font-size: 14px;
        }
    }
</style>
<div class="devices-container">
    <h2>My Devices</h2>
    <table class="devices-table">
        <thead>
            <tr>
                <th>Device Image</th>
                <th>Device Name</th>
                <th>Description</th>
                <th>Owner</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include database connection file
            include_once '..//user/cryptoshow_db.php';

            // Fetch devices of the logged-in user
            $userid = $_SESSION['userid'];
            $sql = "SELECT deviceid, devicename, devicedesc, deviceimage, fullname FROM devices WHERE userid = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "i", $userid);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // Display device image
                    echo "<td><img src='../user/images/devices/" . $row['deviceimage'] . "' alt='Device Image' style='width:100px;height:auto;'></td>";
                    echo "<td>" . $row['devicename'] . "</td>";
                    echo "<td>" . $row['devicedesc'] . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    // Add update button with link to modify_devices.php
                    echo "<td><a href='modify_devices.php?deviceid=" . $row['deviceid'] . "' class='update-button'>Update</a></td>";
                    // Add delete button
                    echo "<td><button class='delete-button' onclick='confirmDelete(" . $row['deviceid'] . ")'>Delete</button></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No devices found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
    // Function to show confirmation dialog for device deletion
    function confirmDelete(deviceId) {
        var confirmation = confirm("Are you sure you want to delete this device?");
        if (confirmation) {
            // Redirect to delete_device.php with the deviceid parameter
            window.location.href = "../includes/delete_device.php?deviceid=" + deviceId;
        }
    }
</script>
