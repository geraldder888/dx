<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Verify reCAPTCHA
    $recaptchaSecret = '6LctjicqAAAAAMT7dmSEttxcCOdZ4SK2saC4upHs';  // Replace with your secret key
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$recaptchaSecret&response=$recaptchaResponse");
    $responseKeys = json_decode($response, true);

    if (intval($responseKeys["success"]) !== 1) {
        echo "CAPTCHA verification failed. Please try again.";
    } else {
        // Process the form (e.g., send email)
        // mail(...);

        echo "お問い合わせが正常に送信されました。";
    }
}
?>
