<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendEmailMessage($email, $subject, $message) {
  // $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
  // try {
  //     //Server settings
  //     // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
  //     $mail->isSMTP();                                      // Set mailer to use SMTP
  //     $mail->Host = 'tybank.heliohost.org';  // Specify main and backup SMTP servers
  //     $mail->SMTPAuth = true;                               // Enable SMTP authentication
  //     $mail->Username = 'noreply@tybank.heliohost.org';                        // SMTP username
  //     $mail->Password = 'secret';                           // SMTP password
  //     $mail->SMTPSecure = "ssl";
  //     $mail->Port = 465;
  //
  //     //Recipients
  //     $mail->setFrom('noreply@tybank.heliohost.org', 'TyBank');
  //     $mail->addAddress($email);     // Add a recipient
  //     $mail->addReplyTo('markytools@gmail.com', 'TyBank Customer Support');
  //
  //     //Content
  //     $mail->Subject = $subject;
  //     $mail->Body    = $message;
  //
  //     $mail->send();
  //     // echo 'Message has been sent';
  // } catch (Exception $e) {
  //     // echo 'Message could not be sent.';
  //     // echo 'Mailer Error: ' . $mail->ErrorInfo;
  // }
}


 ?>
