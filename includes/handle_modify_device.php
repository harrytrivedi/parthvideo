<?php
// Start session if not already started
session_start();

// Check if user is logged in
if (!isset($_SESSION['userid'])) {
    echo "<script> window.location.href = '../user/login.php';</script>";
    exit(); // Stop further execution of the script
}

// Include database connection file
include_once '../user/cryptoshow_db.php';

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Get form data
    $deviceId = $_POST['deviceid'];
    $deviceName = $_POST['devicename'];
    $deviceDesc = $_POST['devicedesc'];
    // Add other form fields as needed

    // Check if a new image file is uploaded
    if ($_FILES['deviceimage']['size'] > 0) {
        // Handle image upload
        $newImage = $_FILES['deviceimage']['name'];
        $tempImage = $_FILES['deviceimage']['tmp_name'];
        $imagePath = '../user/images/devices/' . $newImage;

        // Move uploaded image to the destination folder
        if (move_uploaded_file($tempImage, $imagePath)) {
            // Update device details in the database including the new image path
            $sql = "UPDATE devices SET devicename = ?, devicedesc = ?, deviceimage = ? WHERE deviceid = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssi", $deviceName, $deviceDesc, $newImage, $deviceId);
            if (mysqli_stmt_execute($stmt)) {
                // Device details updated successfully
                // Redirect to a success page or back to the mydevices.php page
                header("Location: ../user/mydevices.php?success=1");
                exit();
            } else {
                // Error occurred while updating device details
                // Redirect to an error page or back to the mydevices.php page with an error message
                header("Location: ../user/mydevices.php?error=1");
                exit();
            }
        } else {
            // Failed to move uploaded image to destination folder
            // Redirect to an error page or back to the mydevices.php page with an error message
            header("Location: ../user/mydevices.php?error=image_upload_failed");
            exit();
        }
    } else {
        // Update device details in the database excluding the image
        $sql = "UPDATE devices SET devicename = ?, devicedesc = ? WHERE deviceid = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $deviceName, $deviceDesc, $deviceId);
        if (mysqli_stmt_execute($stmt)) {
            // Device details updated successfully
            // Redirect to a success page or back to the mydevices.php page
            header("Location: ../user/mydevices.php?success=1");
            exit();
        } else {
            // Error occurred while updating device details
            // Redirect to an error page or back to the mydevices.php page with an error message
            header("Location: ../user/mydevices.php?error=1");
            exit();
        }
    }
} else {
    // Redirect to mydevices.php if form is not submitted
    header("Location: ../user/mydevices.php");
    exit();
}
?>
