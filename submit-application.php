<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_STRING);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Verify reCAPTCHA
    $recaptchaSecret = '6LctjicqAAAAAMT7dmSEttxcCOdZ4SK2saC4upHs'; // Replace with your secret key
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        die("CAPTCHA verification failed. Please try again.");
    }

    // Define the recipient and subject
    $to = "infomation@dx-win.com"; // Replace with your email address
    $subject = "New Application from $name";

    // Compose the email message
    $email_message = "Name: $name\n";
    $email_message .= "Email: $email\n";
    $email_message .= "Position: $position\n";
    $email_message .= "Message:\n$message\n";

    // Set email headers
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Send the email
    if (mail($to, $subject, $email_message, $headers)) {
        echo "ご応募ありがとうございました。弊社担当者より連絡させていただきます。";
    } else {
        echo "There was a problem sending your application.";
    }
} else {
    echo "Invalid request.";
}
?>
