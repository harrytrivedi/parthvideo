<?php
$pageTitle = "Book Now - Parth Video";
include_once '../includes/header.php';
?>

<div class="book-now-container">
    <h1>Book Now</h1>
    <!-- Inline response message area -->
    <div id="formResponse"></div>

    <form id="booknowForm">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" placeholder="Your Name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Your Email" required>

        <label for="phone">Phone:</label>
        <input type="tel" id="phone" name="phone" placeholder="Your Phone Number" required>

        <label for="enquiryFor">Enquiry For:</label>
        <input type="text" id="enquiryFor" name="enquiryFor" placeholder="Service or Event" required>

        <label for="message">Message:</label>
        <textarea id="message" name="message" placeholder="Your Message" rows="5" required></textarea>

        <input type="submit" value="Send Enquiry">
    </form>
</div>

<?php include_once '../includes/footer.php'; ?>

<script>
document.getElementById('booknowForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Prevent normal form submission

    const formData = new FormData(this);
    fetch('../includes/send_enquiry.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(text => {
        document.getElementById('formResponse').innerText = text;
        // Optionally reset form
        this.reset();
    })
    .catch(error => {
        document.getElementById('formResponse').innerText = "Error sending enquiry. Please try again.";
        console.error(error);
    });
});
</script>
