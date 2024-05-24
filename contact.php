<?php
// Define a function to send the email
function sendEmail($name, $email, $subject, $message) {
    // Configuration
    $to = 'aniketva@aniketvaidya.whf.bz'; // Replace with your email address
    $from = $email;
    $headers = 'From: '. $from. "\r\n".
               'Reply-To: '. $from. "\r\n".
               'MIME-Version: 1.0'. "\r\n".
               'Content-Type: text/html; charset=UTF-8';

    // Send the email
    $subject = 'Contact Form Submission: '. $subject;
    $body = '<p>Name: '. $name. '</p>'.
            '<p>Email: '. $email. '</p>'.
            '<p>Message: '. $message. '</p>';
    if (mail($to, $subject, $body, $headers)) {
        return true;
    } else {
        return false;
    }
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate the input data
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address.';
    } else {
        // Send the email using the function
        if (sendEmail($name, $email, $subject, $message)) {
            $success = 'Your message has been sent. Thank you!';
        } else {
            $error = 'Failed to send email. Please try again.';
        }
    }
}

// Output the result
if (isset($error)) {
    echo '<div class="error-message">'. $error. '</div>';
} elseif (isset($success)) {
    echo '<div class="sent-message">'. $success. '</div>';
}
?>