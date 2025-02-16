<?php
$pageTitle = "Book Now - Parth Video";
include_once '../includes/header.php';
?>

<style>

.booknow-bg {
    background: url('../user/images/formback.jpg') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh; 
    padding: 50px 0;   
}

/* Container with semi-transparent overlay */
.book-now-container {
    background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black overlay */
    width: 60%;
    max-width: 600px;
    margin: auto;       /* Center horizontally */
    padding: 30px;
    border-radius: 10px;
    color: #fff;        /* White text for contrast */
    font-family: "Poppins", sans-serif;
}

.book-now-container h1 {
    text-align: center;
    margin-bottom: 20px;
}

#formResponse {
    margin-bottom: 20px;
    font-family: "Poppins", sans-serif;
    font-size: 18px;
    color: #5ecfff;  /* Accent color for response message */
    text-align: center;
}

/* Labels */
.book-now-container label {
    display: block;
    margin-bottom: 5px;
    font-size: 18px;
    color: #ffffff; 
    font-family: "Poppins", sans-serif;
}

/* Inputs */
.book-now-container input[type="text"],
.book-now-container input[type="email"],
.book-now-container input[type="tel"],
.book-now-container textarea {
    width: 100%;
    margin-bottom: 15px;
    padding: 10px;
    font-family: "Poppins", sans-serif;
    font-size: 16px;
    color: #000;        /* Dark text inside fields */
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-sizing: border-box;
}

/* Submit Button */
.book-now-container input[type="submit"] {
    width: 100%;
    padding: 12px;
    font-size: 18px;
    font-family: "Poppins", sans-serif;
    font-weight: bold;
    color: #fff;
    background-color: #5e17eb;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    margin-top: 5px;
}

.book-now-container input[type="submit"]:hover {
    background: linear-gradient(to right, #5e17eb, #5ecfff, #5e17eb);
    color: #000;
}
</style>

<div class="booknow-bg">
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
