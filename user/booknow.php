<?php
$pageTitle = "Book Now - Parth Video";
include_once '../includes/header.php';
?>

<div class="container">
    <h1>Book Now</h1>
    <form action="../includes/send_enquiry.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Your Name" required>
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Your Email" required>
        <br><br>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" placeholder="Your Phone Number" required>
        <br><br>

        <label for="enquiryFor">Enquiry For:</label>
        <input type="text" id="enquiryFor" name="enquiryFor" placeholder="Service or Event" required>
        <br><br>

        <label for="message">Message:</label>
        <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>
        <br><br>

        <input type="submit" value="Send Enquiry">
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>
