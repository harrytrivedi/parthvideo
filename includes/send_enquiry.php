<?php
// includes/send_enquiry.php

// Set the recipient email address
$to = "trivedi.harshbhavesh@gmail.com";

// Get POST data
$name = isset($_POST['name']) ? $_POST['name'] : "";
$email = isset($_POST['email']) ? $_POST['email'] : "";
$phone = isset($_POST['phone']) ? $_POST['phone'] : "";
$enquiryFor = isset($_POST['enquiryFor']) ? $_POST['enquiryFor'] : "";
$message = isset($_POST['message']) ? $_POST['message'] : "";

// Basic validation
if(empty($name) || empty($email) || empty($phone) || empty($enquiryFor) || empty($message)){
    echo "All fields are required.";
    exit;
}

// Prepare email subject and body
$subject = "New Booking Enquiry from $name";
$body = "You have received a new booking enquiry.\n\n";
$body .= "Name: $name\n";
$body .= "Email: $email\n";
$body .= "Phone: $phone\n";
$body .= "Enquiry For: $enquiryFor\n";
$body .= "Message: $message\n";

// Additional headers
$headers = "From: no-reply@parthvideo.in\r\n";
$headers .= "Reply-To: $email\r\n";

// Send the email
if(mail($to, $subject, $body, $headers)){
    echo "Thank you for your enquiry. We will get back to you shortly.";
} else {
    echo "There was an error sending your enquiry. Please try again later.";
}
?>
