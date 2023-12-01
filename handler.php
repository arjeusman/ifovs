<?php

//handler

require 'dashboard/config.php';

if(isset($_POST['send_message'])):
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$message = $_POST['message'];
	$date = date('F d, Y - h:i a');
	if(!empty($name) && !empty($email) && !empty($message)):
		$send = mysqli_query($con, "insert into messages(fullname, phone, email_address, message, date) values ('$name', '$phone', '$email', '$message', '$date')");
	endif;
	header('location: thank-you.html');
endif;