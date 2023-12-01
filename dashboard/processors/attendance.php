<?php

global $con;

require('includes/mailer.php');

if(isset($_GET['id'])):
	$id = $_GET['id'];
	$date = date('m-d-Y');
	$status = $_GET['status'];
	$check = mysqli_query($con, "select * from attendance where employee_id=$id and date='$date'");
	if(mysqli_num_rows($check)==0):
		if($status=='present'):
			$add = mysqli_query($con, "insert into attendance(employee_id, date, is_present) values ($id, '$date', true)");
		else:
			$add = mysqli_query($con, "insert into attendance(employee_id, date, is_absent) values ($id, '$date', true)");
		endif;
		if($add):
			$_SESSION['message'] = array(
		      'type' => 'success',
		      'title' => 'Saved!',
		      'message' => 'Attendance was saved.',
		      'page' => basename($_SERVER['REQUEST_URI'])
		    );
		else:
			$_SESSION['message'] = array(
		      'type' => 'error',
		      'title' => 'Warning!',
		      'message' => 'Something went wrong, please try again.',
		      'page' => basename($_SERVER['REQUEST_URI'])
		    );
		endif;
	else:
		if($status=='present'):
			$update = mysqli_query($con, "update attendance set is_present=true, is_absent=false where employee_id=$id and date='$date'");
		else:
			$update = mysqli_query($con, "update attendance set is_present=false, is_absent=true where employee_id=$id and date='$date'");
		endif;
		if($update):
			$_SESSION['message'] = array(
		      'type' => 'success',
		      'title' => 'Saved!',
		      'message' => 'Attendance was saved.',
		      'page' => basename($_SERVER['REQUEST_URI'])
		    );
		else:
			$_SESSION['message'] = array(
		      'type' => 'error',
		      'title' => 'Warning!',
		      'message' => 'Something went wrong, please try again.',
		      'page' => basename($_SERVER['REQUEST_URI'])
		    );
		  endif;
	endif;
	header("location: attendance.php");
endif;