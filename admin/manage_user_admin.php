<?php
$pageTitle = "Manage User - Parth Video";
include_once 'admin_header.php';

// Check if userid is set in the URL
if (!isset($_GET['userid'])) {
    echo "<script> window.location.href = 'manageusers.php';</script>";
    exit(); // Stop further execution of the script
}

// Include database connection file
include_once '../user/cryptoshow_db.php';

// Fetch user data based on the provided userid
$userid = $_GET['userid'];
$sql = "SELECT * FROM users WHERE userid = '$userid'";
$result = mysqli_query($conn, $sql);

// Check if user exists
if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
} else {
    // Redirect to manage users page if user not found
    echo "<script> window.location.href = 'manageusers.php';</script>";
    exit(); // Stop further execution of the script
}
?>

<style>
    .avatar-container {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        overflow: hidden;
        margin: auto;
    }

    .avatar-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>
<script src="../test/js/script.js"></script>
<div class="my-account-container">
    <div class="form-container">
        <h2>Manage User</h2>
        <!-- Display the user's avatar image -->
        <?php
        // Define the path to the user's avatar image
        $avatarPath = '../user/images/uploads/' . $user['avatar'];
        ?>
        <div class="avatar-container">
            <img class="avatar-image" src="<?php echo $avatarPath; ?>" alt="Avatar">
        </div>

        <form action="../includes/update-profile-admin.php" method="post" onsubmit="return confirmUpdate()">
            <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>">

            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $user['fullname']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <input type="submit" value="Update">
        </form>

        <form action="../includes/update-avatar-admin.php" method="post" enctype="multipart/form-data"
            onsubmit="return confirmAvatarUpdate()">
            <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">
            <label for="avatar">Change Avatar:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"><br><br>
            <input type="submit" value="Change Avatar">
        </form>

        <p>Welcome back,
            <?php echo $user['fullname']; ?>!
        </p>
        <form action="../includes/delete_profile_admin.php" method="post" onsubmit="return confirmDeletion()">
            <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">
            <input type="submit" class="delete-button" name="delete" value="Delete Profile">
        </form>

    </div>
</div>
<script>
    // Function to confirm profile deletion
    function confirmDeletion() {
        // Display confirmation message box
        var confirmed = confirm("Are you sure you want to delete this user's profile?");
        // Return true if confirmed, false otherwise
        return confirmed;
    }

    // Function to confirm profile update
    function confirmUpdate() {
        // Display confirmation message box
        var confirmed = confirm("Are you sure you want to update this user's profile?");
        // Return true if confirmed, false otherwise
        return confirmed;
    }
</script>
</body>

</html>