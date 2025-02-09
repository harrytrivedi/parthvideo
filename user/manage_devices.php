<?php
$pageTitle = "Manage Devices - Cryptoshow Society";
include_once '..//includes/header.php';

if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = 'login.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    /* Form styles */
    .form-container {
        width: 80%;
        padding: 30px;
        border-radius: 10px;
        margin: auto;
    }

    .form-container form {
        display: flex;
        flex-direction: column;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-container label {
        font-size: 18px;
    }

    .form-container input[type="text"],
    .form-container textarea {
        width: 100%;
        padding: 8px;
        font-size: 16px;
    }

    .form-container input[type="submit"] {
        background-color: #0af8ff;
        color: #ffffff;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .form-container input[type="submit"]:hover {
        background-color: #0acfff;
    }
</style>

<div class="form-container">
    <h2>Add New Device</h2>
    <form action="../includes/handle_device.php" method="POST" enctype="multipart/form-data">
        <!-- Add Device Name -->
        <label for="devicename">Device Name:</label>
        <input type="text" id="devicename" name="devicename" required>

        <!-- Add Device Description -->
        <label for="devicedesc">Device Description:</label>
        <textarea id="devicedesc" name="devicedesc" rows="4" required></textarea>

        <!-- Add Device Image -->
        <label for="deviceimage">Device Image:</label>
        <input type="file" id="deviceimage" name="deviceimage" accept="image/*" required>

        <!-- Add a hidden field for user ID -->
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">

        <!-- Hidden Field for Fullname -->
        <input type="hidden" id="fullname" name="fullname" value="<?php echo $_SESSION['fullname']; ?>">

        <!-- Submit Button -->
        <input type="submit" value="Add Device">
    </form>
</div>
