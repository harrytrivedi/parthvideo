<?php
$pageTitle = "Modify Devices - Cryptoshow Society";
include_once '..//includes/header.php';

// Check if the deviceid parameter is set in the URL
if (!isset($_GET['deviceid'])) {
    // Redirect to the mydevices.php if deviceid parameter is not set
    header("Location: mydevices.php");
    exit();
}

// Include database connection file
include_once '..//user/cryptoshow_db.php';

// Get the deviceid from the URL parameter
$deviceid = $_GET['deviceid'];

// Fetch the details of the selected device
$sql = "SELECT devicename, devicedesc, deviceimage, fullname FROM devices WHERE deviceid = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $deviceid);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    // Redirect to the mydevices.php if device not found
    header("Location: mydevices.php");
    exit();
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
    <h2>Modify Device</h2>
    <form action="../includes/handle_modify_device.php" method="POST" enctype="multipart/form-data">
        <!-- Hidden input field to store deviceid -->
        <input type="hidden" name="deviceid" value="<?php echo $deviceid; ?>">

        <label for="devicename">Device Name:</label>
        <input type="text" id="devicename" name="devicename" value="<?php echo $row['devicename']; ?>" required><br><br>

        <label for="devicedesc">Description:</label>
        <textarea id="devicedesc" name="devicedesc" required><?php echo $row['devicedesc']; ?></textarea><br><br>

        <label for="deviceimage">Device Image:</label>
        <input type="file" id="deviceimage" name="deviceimage" accept="image/*"><br><br>

        <!-- Display the current device image -->
        <label>Current Device Image:</label><br>
        <img src="../user/images/devices/<?php echo $row['deviceimage']; ?>" alt="Current Device Image" style="width:100px;height:auto;"><br><br>

        <input type="submit" value="Update" name="submit">
    </form>
</div>

