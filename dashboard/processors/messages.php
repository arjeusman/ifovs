<?php

global $con;

if(isset($_GET['read'])):
  $id = $_GET['read'];
  $read = mysqli_query($con, "update messages set is_read=true where id=$id");
  if($read):
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Marked!',
      'message' => 'The message was marked as read.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  else:
    $_SESSION['message'] = array(
      'type' => 'error',
      'title' => 'Warning!',
      'message' => 'Failed to mark message, please try again.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
  endif;
  header("location: ?ref=".uniqid());
endif;

?>