
<?php
$pageTitle = "Add Event - Parth Video";
include_once 'admin_header.php';

?>
<body>

<div class="admin-container">
    <h2>Add New Event</h2>
    <form action="../admin/add_events.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>
        <br><br>

        <label for="date">Date:</label>
        <input type="date" id="date" name="date" required>
        <br><br>

        <label for="venue">Venue:</label>
        <input type="text" id="venue" name="venue" required>
        <br><br>

        <label for="capacity">Capacity:</label>
        <input type="number" id="capacity" name="capacity" required>
        <br><br>
        <!-- Add this input field to your form for uploading an image -->
<label for="eventimage">Event Image:</label>
<input type="file" name="eventimage" id="eventimage">


        <input type="submit" value="Add Event">
    </form>
</div>

</body>
</html>
