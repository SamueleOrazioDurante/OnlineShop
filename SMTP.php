<?php

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

    function sendEmail($dest,$subject,$body){
        $mail = new PHPMailer(true);
        try {

        $mail->isSMTP();
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth   = true;
        $mail->Host       = 'smtp.gmail.com';
        $mail->Username   = 'noreply.noirell@gmail.com';
        $mail->Password   = 'ktad tmne vehn ysuk';
        $mail->Port       = 465;

        // test connection (secure disabled)
        $connected = $mail->smtpConnect();

        // write email from inbox1 to inbox2
        $mail->setFrom('noreply.noirell@gmail.com');
        $mail->addAddress($dest);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // send the email
        $sent = $mail->send();  

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            throw new Exception($mail->ErrorInfo);
        }
    }
