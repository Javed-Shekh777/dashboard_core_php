<?php

// Adjust the path to the autoload.php file based on your OS
require 'C:/Users/Javed/AppData/Roaming/Composer/vendor/autoload.php'; // For Windows

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


function sendtOTP($email, $verification_code = "", $token)
{
    try {
        $mail = new PHPMailer(true);


     

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = '$AUTH_EMAIL'; // Your email
        $mail->Password = '$AUTH_KEY'; // Your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('$AUTH_EMAIL', 'Javed Shekh');
        $mail->addAddress($email); // Add a recipient

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $verification_link = "http://localhost/ekana/dashboard/backend/process.php?token=$token&verifyEmail=$email";
        $message = "<p>OTP Is : " . $token . " </p> <br><p>Click the link below to verify your email:</p>";
        $mail->Body    = $message."<br> <a href='" . $verification_link . "'>Verify Email</a>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return null;
    }
}
