<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class EmailManager {
    public function __construct($host, $user, $password, $encryption, $port, $fromAddress, $fromAddressName) {
        $this->smtpHost = $host;
        $this->smtpUsername = $user;
        $this->smtpPassword = $password;
        $this->smtpEncryption = $encryption;
        $this->smtpPort = $port;
        $this->fromAddress = $fromAddress;
        $this->fromAddressName = $fromAddressName;
    }

    public function send($to, $subject, $content) {
        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->smtpHost;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $this->smtpUsername;                 // SMTP username
            $mail->Password = $this->smtpPassword;                           // SMTP password
            $mail->SMTPSecure = $this->smtpEncryption;                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->smtpPort;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom($this->fromAddress, $this->fromAddressName);
            $mail->addAddress($to);     // Add a recipient

            //Content
            $mail->isHTML(false);                                  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = $content;
            //$mail->AltBody = $content;

            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent.';
        }
    }
}