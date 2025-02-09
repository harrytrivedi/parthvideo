<?php
// Include the database connection file
include_once 'connection.php';
include_once 'admin_header.php';

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);

    // Handle file upload
    $targetDirectory = "..//user/images/uploads";
    $targetFile = $targetDirectory . basename($_FILES["eventimage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["eventimage"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        header("location: ..//admin/create_event.php?error=File is not an image.");
        exit();
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        header("location: ..//admin/create_event.php?error=Sorry, file already exists.");
        exit();
    }

    // Check file size
    if ($_FILES["eventimage"]["size"] > 500000) {
        header("location: ..//admin/create_event.php?error=Sorry, your file is too large.");
        exit();
    }

    // Allow only certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        header("location: ..//admin/create_event.php?error=Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
        exit();
    }

    // Try to upload file
    if (move_uploaded_file($_FILES["eventimage"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;

        // Insert event into database
        $sql = "INSERT INTO events (title, date, venue, capacity, eventimage) VALUES ('$title', '$date', '$venue', '$capacity', '$imagePath')";
        if (mysqli_query($conn, $sql)) {
            // Redirect back to admin panel with success message
            header("location: ..//admin/admin.php?success=Event added successfully");
            exit();
        } else {
            // Redirect back to admin panel with error message
            header("location: ..//admin/admin.php?error=Error adding event: " . mysqli_error($conn));
            exit();
        }
    } else {
        header("location: admin.php?error=Sorry, there was an error uploading your file.");
        exit();
    }
} else {
    // If form is not submitted, redirect to admin panel
    header("location: ..//admin/admin.php");
    exit();
}
?>
