<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form input data to variables
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Admin's email address (change to your email)
    $admin_email = "stimran4405@gmail.com";
    
    // Subject for both emails
    $subject_admin = "New Contact Form Submission";
    $subject_user = "Thank You for Contacting Us";

    // Admin email content
    $admin_message = "
    You have received a new message from the contact form on your website.\n\n
    Name: $name\n
    Email: $email\n
    Message: \n$message
    ";

    // User email content
    $user_message = "
    Dear $name,\n\n
    Thank you for contacting us. We have received your message and will get back to you shortly.\n\n
    Your Message: \n$message\n\n
    Best regards,\n
    Your Website Team
    ";

    // Send email to admin
    $headers_admin = "From: no-reply@yourwebsite.com" . "\r\n" .
                     "Reply-To: $email" . "\r\n" .
                     "X-Mailer: PHP/" . phpversion();
    if (mail($admin_email, $subject_admin, $admin_message, $headers_admin)) {
        echo "Message sent to admin successfully.<br>";
    } else {
        echo "Failed to send message to admin.<br>";
    }

    // Send email to user
    $headers_user = "From: no-reply@yourwebsite.com" . "\r\n" .
                    "Reply-To: $admin_email" . "\r\n" .
                    "X-Mailer: PHP/" . phpversion();
    if (mail($email, $subject_user, $user_message, $headers_user)) {
        echo "Confirmation sent to user successfully.";
    } else {
        echo "Failed to send confirmation to user.";
    }
}
?>
