<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function jsonEncodeSuccess($data){
    $array = array(
            "message" => "success",
            "code" => "200",
            "data" => $data
        );
    $object = (object)$array;
    print json_encode($object);
    exit();
}

$fname = $_POST['fname'];
$recipient = $_POST['email'];
$bodymsg = $_POST['bodymsg'];
$subject = $_POST['subject'];
$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    // $mail->SMTPDebug = true;
    $mail->SMTPDebug = 0;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.hostinger.com ';                  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'adminbola@bolaswerte.com';             // SMTP username
    $mail->Password = 's@mfreAk21';                           // SMTP password
    $mail->SMTPSecure = 'ssl';                            // Enable SSL encryption, TLS also accepted with port 465
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('adminbola@bolaswerte.com', 'Bola Swerte Admin');          //This is the email your form sends From
    $mail->addAddress($recipient, $fname); // Add a recipient address
    // $mail->addAddress('melvincayanan7@gmail.com', 'sam test'); 
    //$mail->addAddress('contact@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');
    
    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $bodymsg;

    // $mail->Subject = "test email";
    // $mail->Body    = "Testing this email, messages distributed by electronic means from one computer user to one or more recipients via a network.";
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    jsonEncodeSuccess('success');
} catch (Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
?>