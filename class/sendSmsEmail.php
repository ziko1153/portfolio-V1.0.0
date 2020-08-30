<?php
include 'PHPMailer/src/Exception.php';
include 'PHPMailer/src/PHPMailer.php';
include 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class sendSmsEmail {
    public $message;
    public $name;
    public $subject;
    public $reply_email;
    private $email = 'ziko.nwu@gmail.com';
    private $host;
    private $username;
    private $password;
    private $port;
    private $from_email;
    private $from_name;
    private $reply_name;
    private $smtpSecure;

    public function __construct() {

        $this->host = '';
        $this->username = '';
        $this->password = '';
        $this->port = 465;
        $this->smtpSecure = 'ssl';
        $this->from_email = '';
        $this->from_name = 'Tahmid Ziko';
        $this->reply_name = 'Tahmid Ziko';
    }

    public function sendEmail() {

        $mail = new PHPMailer(true); // Passing `true` enables exceptions
        try {
            //Server settings
            $mail->SMTPDebug = 0; // Enable verbose debug output
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = $this->host; // Specify main and backup SMTP servers
            $mail->SMTPAuth = true; // Enable SMTP authentication
            $mail->Username = $this->username; // SMTP username
            $mail->Password = $this->password; // SMTP password
            $mail->SMTPSecure = $this->smtpSecure; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = $this->port; // TCP port to connect to

            //Recipients
            $mail->setFrom($this->from_email, $this->from_name);

            $mail->addAddress($this->email, $this->from_name);
            $mail->addReplyTo($this->reply_email, $this->name);
            // if (!empty($cc)) {
            //     // print_r($cc);
            //     for ($i = 0; $i < count($cc); $i++) {
            //         $mail->addCC($cc[$i]);
            //     }
            // }
            // if (!empty($bcc)) {
            //     for ($i = 0; $i < count($bcc); $i++) {
            //         $mail->addBCC($bcc[$i]);
            //     }
            // }
            //$mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

            //Content
            $mail->isHTML(true);
            //$mail->AddEmbeddedImage('ziko.jpg', 'zikoimg', 'ziko.jpg');
            $mail->Subject = $this->subject;
            $mail->Body = $this->message;
            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if ($mail->send()) {

                return true;
            }

            return false;
        } catch (Exception $e) {
            echo 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            return false;
        }

    }
}

?>