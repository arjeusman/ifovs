<?php global $active; ?>

<?php include('includes/functions.php'); ?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>iFovs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"crossorigin="anonymous"/>
  <link rel="icon" href="assets/favicon.ico">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.theme.css" />
  <link rel="stylesheet" type="text/css" href="assets/style.css" />
  <?php include('includes/popMessage.php'); ?>
</head>

<body <?php if(isset($_SESSION['message'])): print 'onload="showMessage()"'; endif; ?>>

<div class="wrapper"><!-- wrapper -->
  
  <div class="sidebar sticky-top"><!-- sidebar -->
    <div class="bg-info bg-opacity-10 d-flex justify-content-center py-5">
      <img style="max-width: 100px" src="assets/logo.png"/>
    </div>
    <div class="sidebar-content">
      <ul class="nav nav-pills d-flex flex-column gap-2 p-2">
        <li class="nav-item">
          <a class="nav-link rounded-2 <?php print ($active == 'dashboard')?'active':''; ?>" href="index.php">
            <i class="bi bi-house me-2"></i>
            <span>Home</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-2 <?php print ($active == 'messages')?'active':''; ?>" href="messages.php">
            <i class="bi bi-envelope-at-fill me-2"></i>
            <span>Messages</span>
            <span class="badge bg-danger"><?php print (getNewMessagesCount()>0)?getNewMessagesCount():''; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-2 <?php print ($active == 'management')?'active':''; ?>" href="management.php">
            <i class="bi bi-people-fill me-2"></i>
            <span>Management</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-2 <?php print ($active == 'applications')?'active':''; ?>" href="applications.php">
            <i class="bi bi-person-badge me-2"></i>
            <span>Applications</span>
            <span class="badge bg-danger"><?php print (getNewApplicationCount()>0)?getNewApplicationCount():''; ?></span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-2 <?php print ($active == 'attendance')?'active':''; ?>" href="attendance.php">
            <i class="bi bi-calendar-check-fill me-2"></i>
            <span>Attendance</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link rounded-2" href="signout.php">
            <i class="bi bi-box-arrow-right me-2"></i>
            <span>Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </div><!-- sidebar -->

  <div class="main"><!-- main -->
    <main class="content"><!-- content -->
      <div class="container-fluid"><!-- container -->