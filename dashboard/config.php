<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Asia/Manila');

session_start();

define('appName', 'iFovs');
$active = 'dashboard';

$host = 'localhost';
$user = 'u689646505_ifovs';
$pass = 'Ifovsipil2019!';
$db = 'u689646505_ifovs';

$con = mysqli_connect($host, $user, $pass, $db) or die(mysqli_connect_error());

include('includes/functions.php');
