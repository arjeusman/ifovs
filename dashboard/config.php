<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

session_start();

define('appName', 'iFovs');
$active = 'dashboard';

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'ifovs';

$con = mysqli_connect($host, $user, $pass, $db) or die(mysqli_connect_error($con));

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