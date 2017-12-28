<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\src\Exception.php';
require 'PHPMailer\src\PHPMailer.php';
require 'PHPMailer\src\SMTP.php';



$mail = new PHPMailer;
$mail->SMTPDebug = 2;                           // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;       // Enable SMTP authentication
$mail->Username = 'you9215712@gmail.com'; // SMTP username
$mail->Password = 'you850407';             // SMTP password
$mail->SMTPSecure = 'ssl';      // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                     // TCP port to connect to
$mail->setFrom('you9215712@gmail.com', 'Mailer');
$mail->addAddress('you9215712@gmail.com', 'Joe User');     // Add a recipient
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()){
echo 'Message could not be sent.';
echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
echo 'Message has been sent';
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	
</body>
</html>