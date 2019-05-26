<?php
include('PHPMailer-master/src/PHPMailer.php');
include('PHPMailer-master/src/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer;

// SMTP configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'kd.lukhi99@gmail.com';
$mail->Password = '9924910570';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('kd.lukhi99@gmail.com', 'Online Gas Book');
$mail->addReplyTo('kd.lukhi99@gmail.com', 'Online Gas Book');

/*
// Add a recipient
$mail->addAddress('mjenish8@gmail.com');

// Email subject
$mail->Subject = 'Send Email via SMTP using PHPMailer';

// Set email format to HTML
$mail->isHTML(true);

// Email body content
$mailContent = "<h1>Send HTML Email using SMTP in PHP</h1>
    <p>This is a test email has sent using SMTP mail server with PHPMailer.</p>";
$mail->Body = $mailContent;

// Send email
if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}else{
    echo 'Message has been sent';
}
*/
?>