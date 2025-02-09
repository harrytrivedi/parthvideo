<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include_once '../user/cryptoshow_db.php';

    // Get updated profile information from the form
    $userid = $_SESSION['userid'];
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Note: Password should be hashed for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password

    // Update the user's profile in the database with hashed password
    $sql = "UPDATE users SET username='$username', fullname='$fullname', email='$email', password='$hashedPassword' WHERE userid='$userid'";
    if (mysqli_query($conn, $sql)) {
        // Redirect to the profile page after successful update
        echo "change successfull";
        header("location: ../user/myaccount.php");
        exit();
    } else {
        // Handle error if update fails
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
