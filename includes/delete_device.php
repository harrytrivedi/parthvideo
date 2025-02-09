<?php
// Check if the deviceid parameter is set in the URL
if (isset($_GET['deviceid'])) {
    // Include database connection file
    include_once '../user/cryptoshow_db.php';

    // Get the deviceid from the URL parameter
    $deviceid = $_GET['deviceid'];

    // Prepare a delete statement
    $sql = "DELETE FROM devices WHERE deviceid = ?";

    // Attempt to execute the prepared statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $deviceid);

    if (mysqli_stmt_execute($stmt)) {
        // Device deleted successfully
        header("Location: ../user/mydevices.php");
        exit();
    } else {
        // Error while deleting device
        echo "Error deleting device: " . mysqli_error($conn);
    }

    // Close statement
    mysqli_stmt_close($stmt);

    // Close connection
    mysqli_close($conn);
} else {
    // Redirect to the devices page if deviceid parameter is not set
    header("Location: ../user/mydevices.php");
    exit();
}
?>
