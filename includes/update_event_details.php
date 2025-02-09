<?php
include_once '../admin/connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventid = $_POST['eventid'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $venue = $_POST['venue'];
    $capacity = $_POST['capacity'];

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["eventimage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["eventimage"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["eventimage"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["eventimage"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["eventimage"]["name"])). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    // Update event details in the database
    $sql = "UPDATE events SET title=?, date=?, venue=?, capacity=?, eventimage=? WHERE eventid=?";
    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $title, $date, $venue, $capacity, $target_file, $eventid);
        mysqli_stmt_execute($stmt);
        echo "<script>window.location.href='../admin/viewevents.php';</script>"; // Redirect using JavaScript
        exit();
    } else {
        // Error in preparing statement
        echo "Error: " . mysqli_error($conn);
        exit();
    }
}
?>
