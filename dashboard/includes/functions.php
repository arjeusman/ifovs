<?php

global $con;

// check session
function protectedContent(){
	if(basename($_SERVER['REQUEST_URI'])!='signin.php' && !isset($_SESSION['id'])):
		session_destroy();
		header("location: signin.php");
	endif;
}

function getComponent($a){
	$component = 'components/'.$a.'.php';
	if(file_exists($component)):
		include $component;
	else:
		die('Component not found.');
	endif;
}

function getModal($a){
	$model = 'modals/'.$a.'.php';
	if(file_exists($model)):
		include $model;
	else:
		die('Model not found.');
	endif;
}

function getProcessor($a){
	$processor = 'processors/'.$a.'.php';
	if(file_exists($processor)):
		include $processor;
	else:
		die('Processor not found.');
	endif;
}

function countData($q){
	global $con;
	$query = mysqli_query($con, $q);
	return mysqli_num_rows($query);
}

function getApplication($id){
	global $con;
	$query = mysqli_query($con, "select * from applications where id='$id' or email_address='$id'");
	$query = mysqli_fetch_assoc($query);
	return $query;
}

function getEmployee($id){
	global $con;
	$query = mysqli_query($con, "select * from employees where id=$id");
	$query = mysqli_fetch_assoc($query);
	return $query;
}

function getActiveEmployees(){
	global $con;
	$data = array();
	$query = mysqli_query($con, "select * from employees where is_active=true");
	while($q = mysqli_fetch_assoc($query)){
		array_push($data, $q);
	}
	return $data;
}

function getNewMessagesCount(){
	global $con;
	$count = mysqli_query($con, "select * from messages where is_read=false");
	$count = mysqli_num_rows($count);
	return $count;
}

function getNewApplicationCount(){
	global $con;
	$count = mysqli_query($con, "select * from applications where is_approved=false and is_discarded=false and is_deleted=false");
	$count = mysqli_num_rows($count);
	return $count;
}