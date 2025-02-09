<?php
$pageTitle = "Admin Settings - Cryptoshow";
include_once 'admin_header.php'

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
<div class="my-account-container"> <!-- Updated class name -->
    <div class="form-container">
        <h2>My Account</h2>
        <!-- Display the user's avatar image -->
        <?php
        // Define the path to the user's avatar image
        $avatarPath = '../user/images/uploads/' . $_SESSION['avatar'];
        ?>
        <div class="avatar-container">
            <img class="avatar-image" src="<?php echo $avatarPath; ?>" alt="Avatar">
        </div>

        <form action="../includes/update-profile-admin.php" method="post" onsubmit="return confirmUpdate()">
            <label for="userid">User ID:</label>
            <input type="text" id="userid" name="userid" value="<?php echo $_SESSION['userid']; ?>" readonly>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo $_SESSION['username']; ?>">

            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $_SESSION['fullname']; ?>">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $_SESSION['email']; ?>">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password">

            <input type="submit" value="Update">
        </form>
        <form action="../includes/update-avatar-admin.php" method="post" enctype="multipart/form-data"
            onsubmit="return confirmAvatarUpdate()">
            <label for="avatar">Change Avatar:</label>
            <input type="file" id="avatar" name="avatar" accept="image/*"><br><br>
            <input type="submit" value="Change Avatar">
        </form>
        <p>Welcome back,
            <?php echo $_SESSION['fullname']; ?>!
        </p>
        <form action="../includes/delete-profile-admin.php" method="post" onsubmit="return confirmDeletion()">
            <input type="submit" class="delete-button" name="delete" value="Delete Profile">
        </form>


    </div>
</div>
<script>
    // Function to confirm profile deletion
    function confirmDeletion() {
        // Display confirmation message box
        var confirmed = confirm("Are you sure you want to delete your profile?");
        // Return true if confirmed, false otherwise
        return confirmed;
    }

    // Function to confirm profile update
    function confirmUpdate() {
        // Display confirmation message box
        var confirmed = confirm("Are you sure you want to update your profile?");
        // Return true if confirmed, false otherwise
        return confirmed;
    }
</script>
</body>

</html>