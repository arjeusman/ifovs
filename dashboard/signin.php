<?php

require('config.php');


if(isset($_POST['login'])):
  $username = $_POST['username'];
  $password = $_POST['password'];
  $check = mysqli_query($con, "select * from users where username='$username' and password='$password' or email='$username' and password='$password'");
  if(mysqli_num_rows($check) > 0):
    $login = mysqli_fetch_assoc($check);
    $_SESSION['id'] = $login['id'];
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Welcome',
      'message' => 'Welcome back '.$login['firstname'].' '.$login['lastname'],
      'page' => basename($_SERVER['REQUEST_URI'])
    );
    header("location: index.php?ref=".uniqid());
  else:
    $_SESSION['message'] = array(
      'type' => 'warning',
      'title' => 'Warning!',
      'message' => 'Wrong username or password.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
    header("location: ?ref=".uniqid());
  endif;
endif;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>iFovs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"crossorigin="anonymous"/>
  <link rel="icon" href="assets/favicon.ico">
  <link rel="stylesheet" type="text/css" href="assets/bootstrap.theme.css" />
  <link rel="stylesheet" type="text/css" href="assets/style.css"/>
  <?php include('includes/popMessage.php'); ?>
</head>
<body <?php if(isset($_SESSION['message'])): print 'onload="showMessage()"'; endif; ?>>
  <div class="login-wrapper d-flex flex-column align-items-center justify-content-center">
    <form method="post" action="" class="card text-bg-white shadow-lg border-0 rounded-3 overflow-hidden needs-validation" novalidate>
      <div style="height: 100px;" class="card-header bg-info bg-gradient py-4 border-0 rounded-0 d-flex align-items-center justify-content-center">
        <img style="width: 80px;" src="assets/logo.png">
      </div>
      <div class="card-body">
        <label for="username" class="form-label"><i class="bi bi-person-fill"></i> Username</label>
        <input id="username" name="username" type="username" class="form-control form-control-lg mb-2" autocomplete="off" required>
        <label for="password" class="form-label"><i class="bi bi-person-fill-lock"></i> Password</label>
        <input id="password" name="password" type="password" class="form-control form-control-lg mb-2" autocomplete="off" required>
        <div class="d-flex justify-content-end">
          <button type="submit" name="login" class="btn btn-lg btn-info bg-gradient flex-fill">Sign in <i class="bi bi-arrow-right"></i></button>
        </div>
      </div>
      <div class="card-footer bg-light bg-opacity-25 text-center">
        <small class="text-uppercase text-muted" style="font-size: 10px">version 1.0</small>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script type="text/javascript" src="script/script.js"></script>
</body>
</html>

<?php

if(isset($_SESSION['message'])):
  if($_SESSION['message']['page']!=basename($_SERVER['REQUEST_URI'])):
    unset($_SESSION['message']);
  endif;
endif;

?>