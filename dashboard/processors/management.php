<?php

global $con;

require('includes/mailer.php');

if(isset($_POST['add'])):
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $email_address = $_POST['email_address'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];
  $civil_status = $_POST['civil_status'];
  $phone_number = $_POST['phone_number'];
  $address_purok = $_POST['address_purok'];
  $address_barangay = $_POST['address_barangay'];
  $address_municipality = $_POST['address_municipality'];
  $address_province = $_POST['address_province'];
  $address_zip = $_POST['address_zip'];
  $add = mysqli_query($con, "insert into employees(first_name, middle_name, last_name, gender, age, civil_status, email_address, phone_number, address_purok, address_barangay, address_municipality, address_province, address_zip, is_inactive) values ('$first_name', '$middle_name', '$last_name', '$gender', $age, '$civil_status', '$email_address', '$phone_number', '$address_purok', '$address_barangay', '$address_municipality', '$address_province', $address_zip, true)");
  if($add):
    sendEmail('Your account was created.', $email_address, 'account-created', $_POST);
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Added!',
      'message' => 'New record was added successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'warning',
      'title' => 'Warning!',
      'message' => 'Please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_POST['edit'])):
  $id = $_POST['id'];
  $first_name = $_POST['first_name'];
  $middle_name = $_POST['middle_name'];
  $last_name = $_POST['last_name'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];
  $civil_status = $_POST['civil_status'];
  $email_address = $_POST['email_address'];
  $phone_number = $_POST['phone_number'];
  $address_purok = $_POST['address_purok'];
  $address_barangay = $_POST['address_barangay'];
  $address_municipality = $_POST['address_municipality'];
  $address_province = $_POST['address_province'];
  $address_zip = $_POST['address_zip'];
  $edit = mysqli_query($con, "update employees set first_name='$first_name', middle_name='$middle_name', last_name='$last_name', gender='$gender', age=$age, civil_status='$civil_status', email_address='$email_address', phone_number='$phone_number', address_purok='$address_purok', address_barangay='$address_barangay', address_municipality='$address_municipality', address_province='$address_province', address_zip=$address_zip where id=$id");
  if($edit):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Updated!',
      'message' => 'The record was updated successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'warning',
      'title' => 'Warning!',
      'message' => 'Failed to updated record, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['active'])):
  $id = $_GET['active'];
  $active = mysqli_query($con, "update employees set is_active=true, is_inactive=false where id=$id");
  if($active):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Activated!',
      'message' => 'The record was activated successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to activate record, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['inactive'])):
  $id = $_GET['inactive'];
  $inactive = mysqli_query($con, "update employees set is_active=false, is_inactive=true where id=$id");
  if($inactive):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Deactivated!',
      'message' => 'The record was deactivated successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to deactivate record, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['send'])):
  $id = $_GET['send'];
  $app = getEmployee($id);
  if($app):
    sendEmail('Your account login credentials.', $app['email_address'], 'account-login', $app);
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Sent!',
      'message' => 'The email was sent successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to send, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['delete'])):
  $id = $_GET['delete'];
  $delete = mysqli_query($con, "update employees set is_deleted=true where id=$id");
  if($delete):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Deleted!',
      'message' => 'The record was deleted successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to delete record, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

if(isset($_GET['remove'])):
  $id = $_GET['remove'];
  $remove = mysqli_query($con, "delete from employees where id=$id");
  if($remove):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Removed!',
      'message' => 'The record was removed successfully.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to remove record, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

?>