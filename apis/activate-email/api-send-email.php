<?php

$sActivationKey = $_GET['key'];
$sUid = $_GET['id'];

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'src/PHPMailer.php';
require 'src/Exception.php';
require 'src/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = 3;                                       // Enable verbose debug output
    $mail->isSMTP();                                            // Set mailer to use SMTP
    $mail->Host       = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'dan.kea.emailtest@gmail.com';                     // SMTP username
    $mail->Password   = 'Testpassword123+';                               // SMTP password
    $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('dan.kea.emailtest@gmail.com', 'Verify account - ACE Homes');
    $mail->addAddress('dan.kea.emailtest@gmail.com', 'User name/email');     // Add a recipient
    // $mail->addAddress('ellen@example.com');               // Name is optional
    // $mail->addReplyTo('dummy@gmail.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);
                                      // Set email format to HTML
    $sPath = "http://daesco.dk/ace/apis/activate-email/api-activate-account.php?id=$sUid&key=$sActivationKey";
    $mail->Subject = 'ACE Homes - Activate your account';
    $mail->Body    = 'Welcome to ACE Homes, please procede to the following link to verify and activate your account:
    <a href="'.$sPath.'">
      click here to verify your account
    </a>
    ';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send(); // Send the email
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}