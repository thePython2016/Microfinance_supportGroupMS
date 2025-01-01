<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $recipientEmail = $_POST['email'];
    $emailSubject = $_POST['subject'];
    $emailBody = $_POST['message'];

    // Initialize PHPMailer
    $mail = new PHPMailer(true);  

    try {
        // Server settings
        $mail->isSMTP();  // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;  // Enable SMTP authentication
        $mail->Username   = 'infonet20th@gmail.com';  // Your Gmail address
        $mail->Password   = 'fmqv yead zvee bcaa';  // Your Gmail password (or App Password if using 2FA)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Enable TLS encryption
        $mail->Port       = 465;  // TCP port to connect to

        // Recipients
        $mail->setFrom('infonet20th@gmail.com', 'Omari');  // Your email and name
        $mail->addAddress($recipientEmail);  // Recipient's email

        // Content
        $mail->isHTML(true);  // Set email format to HTML
        $mail->Subject = $emailSubject;  // Subject
        $mail->Body    = $emailBody;  // HTML message body
        $mail->AltBody = strip_tags($emailBody);  // Plain text version

        // Send the email
        $mail->send();
        echo 'Message has been sent successfully!';
    } 
    catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Email</title>
</head>
<body>
    <h2>Send an Email</h2>
    <form action="" method="post">
        <label for="email">Recipient Email:</label>
        <input type="email" name="email" id="email" required><br><br>

        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="subject" required><br><br>

        <label for="message">Message:</label><br>
        <textarea name="message" id="message" rows="5" cols="30" required></textarea><br><br>

        <button type="submit">Send Email</button>
    </form>
</body>
</html>
