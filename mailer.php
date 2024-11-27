<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendNotificationEmail($recipientEmail, $recipientName) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'engabdelrahmankhattab@gmail.com'; // Your Gmail address
        $mail->Password = 'cuzbsvyewpgxjaye'; // Your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('engabdelrahmankhattab@gmail.com', 'Abdelrahman Khattab'); // Sender
        $mail->addAddress($recipientEmail, $recipientName); // Recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Employee Added';
        $mail->Body = "<h3>Notification</h3><p>A new employee has been added: <strong>$recipientName</strong></p>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
