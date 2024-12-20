<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form input data to variables
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(trim($_POST['message']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirect back with an error message
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=error&message=invalid_email');
        exit;
    }

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
                     "Reply-To: $email" . "\r\n" . // Reply to user's email
                     "X-Mailer: PHP/" . phpversion();
    if (mail($admin_email, $subject_admin, $admin_message, $headers_admin)) {
        // Send email to user
        $headers_user = "From: no-reply@yourwebsite.com" . "\r\n" .
                        "Reply-To: $email" . "\r\n" . // Reply to user's email
                        "X-Mailer: PHP/" . phpversion();
        if (mail($email, $subject_user, $user_message, $headers_user)) {
            // Success
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=success&message=emails_sent');
            exit;
        } else {
            // Failed to send user email
            header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=error&message=user_email_failed');
            exit;
        }
    } else {
        // Failed to send admin email
        header('Location: ' . $_SERVER['HTTP_REFERER'] . '?status=error&message=admin_email_failed');
        exit;
    }
}
?>
