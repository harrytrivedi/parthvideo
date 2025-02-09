<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include_once '../user/cryptoshow_db.php';

    // Get device information from the form
    $devicename = mysqli_real_escape_string($conn, $_POST['devicename']);
    $devicedesc = mysqli_real_escape_string($conn, $_POST['devicedesc']);
    $userid = $_SESSION['userid']; // Assuming you store user ID in session
    $fullname = $_SESSION['fullname']; // Retrieve fullname from session
    
    // Handle file upload for device image
    $deviceImage = $_FILES["deviceimage"]["name"];
    $deviceImageTempName = $_FILES["deviceimage"]["tmp_name"];
    $deviceImagePath = '../user/images/devices/' . $deviceImage;
    
    // Move uploaded device image to the devices directory
    if (move_uploaded_file($deviceImageTempName, $deviceImagePath)) {
        // Store device image filename in session
        $_SESSION['device_image'] = $deviceImage;
        
        // Insert device information into the database
        $sql = "INSERT INTO devices (devicename, devicedesc, deviceimage, fullname, userid) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssssi", $devicename, $devicedesc, $deviceImage, $fullname, $userid);
        
        if (mysqli_stmt_execute($stmt)) {
            // Device added successfully
            header("Location: ../user/manage_devices.php?success=true");
            exit();
        } else {
            // Error handling if insertion fails
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        // Error handling if file upload fails
        echo "Failed to upload device image.";
    }
} else {
    // Redirect to the registration page if accessed directly without form submission
    header("Location: registration.php");
    exit();
}
?>
