<?php
// includes/send_enquiry.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust path if necessary

// Retrieve POST data
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

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = getenv('SMTP_HOST');         // e.g., smtp.gmail.com
    $mail->SMTPAuth   = true;                          // Enable SMTP authentication
    $mail->Username   = getenv('SMTP_USER');           // SMTP username (e.g., your email address)
    $mail->Password   = getenv('SMTP_PASS');           // SMTP password or app-specific password
    $mail->SMTPSecure = getenv('SMTP_ENCRYPTION');     // e.g., tls
    $mail->Port       = getenv('SMTP_PORT');           // e.g., 587

    // Recipients
    $mail->setFrom(getenv('SMTP_USER'), 'Parth Video');    // Replace with your sender email
    $mail->addAddress('trivedi.harshbhavesh@gmail.com');     // Your email to receive enquiries

    // Content
    $mail->isHTML(false); // Send as plain text
    $mail->Subject = "New Booking Enquiry from $name";
    $mail->Body    = "You have received a new booking enquiry.\n\n"
                   . "Name: $name\n"
                   . "Email: $email\n"
                   . "Phone: $phone\n"
                   . "Enquiry For: $enquiryFor\n"
                   . "Message: $message\n";

    $mail->send();
    echo "Thank you for your enquiry. We will get back to you shortly.";
} catch (Exception $e) {
    echo "There was an error sending your enquiry. Mailer Error: {$mail->ErrorInfo}";
}
?>
