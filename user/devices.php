<?php
$pageTitle = "Devices - Cryptoshow Society";
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
    <h2>Devices</h2>
    <table class="devices-table">
        <thead>
            <tr>
                <th>Device Image</th>
                <th>Device Name</th>
                <th>Description</th>
                <th>Owner</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Include database connection file
            include_once '..//user/cryptoshow_db.php';

            // Fetch all devices
            $sql = "SELECT devicename, devicedesc, deviceimage, fullname FROM devices";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    // Display device image
                    echo "<td><img src='../user/images/devices/" . $row['deviceimage'] . "' alt='Device Image' style='width:100px;height:auto;'></td>";
                    echo "<td>" . $row['devicename'] . "</td>";
                    echo "<td>" . $row['devicedesc'] . "</td>";
                    echo "<td>" . $row['fullname'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No devices found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div style="text-align: center; margin-top: 20px;">
        <a href="manage_devices_panel.php" class="button">Manage Devices</a>
    </div>
</div>
<?php include_once '../includes/footer.php'; ?>