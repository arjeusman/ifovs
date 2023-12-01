<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function sendEmail($subject, $recipient, $template, $data){
	$mail = new PHPMailer(true);
	try {
	    //Server settings
	    $mail->SMTPDebug = false;
	    $mail->isSMTP();
	    $mail->Host       = 'smtp.hostinger.com';
	    $mail->SMTPAuth   = true;
	    $mail->Username   = 'hr@ifovs.net';
	    $mail->Password   = 'Ifovshr2023!';
	    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
	    $mail->Port       = 465;

	    //Recipients
	    $mail->setFrom('hr@ifovs.net', 'iFOVS BSS HR Department');
	    $mail->addAddress($recipient);

	    //get template
	    $temp = 'components/email-templates/'.$template.'.php';
	    if(file_exists($temp)):
	    	$body = file_get_contents($temp);
	    	$body = str_replace('@firstname', $data['first_name'], $body);
	    	$body = str_replace('@lastname', $data['last_name'], $body);
	    	$body = str_replace('@email', $data['email_address'], $body);
	    	$body = str_replace('@username', $data['account_username'], $body);
	    	$body = str_replace('@password', $data['account_password'], $body);
	    else:
	    	$body = file_get_contents('components/email-templates/trouble.php');
	    endif;

	    //Content
	    $mail->isHTML(true);
	    $mail->Subject = (!empty($subject))?$subject:'No subject';
	    $mail->Body    = $body;
	    $mail->send();
	} catch(Exception $e){
	    $_SESSION['message'] = array(
	      'type' => 'warning',
	      'title' => 'Something went wrong!',
	      'message' => 'Something went wrong on the server, please try again.',
	      'page' => basename($_SERVER['REQUEST_URI'])
	    );
	}
}