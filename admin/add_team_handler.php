<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


include_once '../admin/connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle file upload
    $target_dir = "../user/images/uploads/";
    $target_file = $target_dir . basename($_FILES["photo"]["name"]);
    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);

    $photo = basename($_FILES["photo"]["name"]);

    // Insert into database
    $sql = "INSERT INTO team (name, role, photo, description) VALUES ('$name', '$role', '$photo', '$description')";

    if (mysqli_query($conn, $sql)) {
        echo "New team member added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
