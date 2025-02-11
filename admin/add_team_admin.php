<?php
$pageTitle = "Add Team Member - Parth Video";
include_once 'admin_header.php';
?>

<body>

<div class="admin-container">
    <h2>Add New Team Member</h2>
    <form action="../admin/add_team_handler.php" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <label for="role">Role:</label>
        <input type="text" id="role" name="role" required>
        <br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        <br><br>

        <label for="photo">Profile Photo:</label>
        <input type="file" name="photo" id="photo" required>
        <br><br>

        <input type="submit" value="Add Team Member">
    </form>
</div>

</body>
</html>
