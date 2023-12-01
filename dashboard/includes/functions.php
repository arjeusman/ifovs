<?php

global $con;

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