<?php

global $con;

require('includes/mailer.php');

if(!isset($_SESSION['view'])):
  $_SESSION['view'] = 'new';
endif;

if(isset($_GET['view'])):
  $_SESSION['view'] = $_GET['view'];
  header('location: applications.php');
endif;

if(isset($_GET['approve'])):
  $id = $_GET['approve'];
  $app = getApplication($id);
  $approve = mysqli_query($con, "update applications set is_approved=true, is_discarded=false, is_deleted=false where id=$id");
  if($approve):
    sendEmail('Your application was approved.', $app['email_address'], 'application-approved', $app);
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Approved!',
      'message' => 'Application was approved successfully.',
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
  header("location: applications.php");
endif;

if(isset($_GET['hire'])):
  $id = $_GET['hire'];
  $app = getApplication($id);
  $first_name = $app['first_name'];
  $middle_name = $app['middle_name'];
  $last_name = $app['last_name'];
  $email_address = $app['email_address'];
  $gender = $app['gender'];
  $age = $app['age'];
  $civil_status = $app['civil_status'];
  $phone_number = $app['phone_number'];
  $address_purok = $app['address_purok'];
  $address_barangay = $app['address_barangay'];
  $address_municipality = $app['address_municipality'];
  $address_province = $app['address_province'];
  $address_zip = $app['address_zip'];
  $account_username = uniqid('ifovs-');
  $account_password = uniqid('#');
  $hire = mysqli_query($con, "insert into employees(first_name, middle_name, last_name, gender, age, civil_status, email_address, phone_number, address_purok, address_barangay, address_municipality, address_province, address_zip, account_username, account_password, is_inactive) values ('$first_name', '$middle_name', '$last_name', '$gender', $age, '$civil_status', '$email_address', '$phone_number', '$address_purok', '$address_barangay', '$address_municipality', '$address_province', $address_zip, '$account_username', '$account_password', true)");
  if($hire):
    sendEmail('Your are hired!', $app['email_address'], 'applicant-hired', $app);
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Hired!',
      'message' => 'Applicant was hired successfully.',
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
  header("location: management.php");
endif;

if(isset($_GET['discard'])):
  $id = $_GET['discard'];
  $discard = mysqli_query($con, "update applications set is_approved=false, is_discarded=true, is_deleted=false where id=$id");
  if($discard):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Discarded!',
      'message' => 'Application was discarded successfully.',
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
  header("location: applications.php");
endif;

if(isset($_GET['delete'])):
  $id = $_GET['delete'];
  $delete = mysqli_query($con, "update applications set is_approved=false, is_discarded=false, is_deleted=true where id=$id");
  if($delete):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Deleted!',
      'message' => 'Application was deleted successfully.',
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
  header("location: applications.php");
endif;

if(isset($_GET['remove'])):
  $id = $_GET['remove'];
  $app = getApplication($id);
  unlink($app['resume']);
  $remove = mysqli_query($con, "delete from applications where id=$id");
  if($remove):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Removed!',
      'message' => 'Application was removed successfully.',
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
  header("location: applications.php");
endif;

?>