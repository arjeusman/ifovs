<?php

require('config.php');
require('includes/mailer.php');

if(isset($_POST['send'])):
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
  $resume = $_FILES['resume']['tmp_name'];
  $date = date('Y-m-d');
  $file = 'files/resume/'.uniqid().'-'.$_FILES['resume']['name'];
  $count = countData("select * from applications where first_name like '%$first_name%' and is_deleted=false or last_name like '%$last_name%' and is_deleted=false");
  if($count <= 3):
    $send = mysqli_query($con, "insert into applications(first_name, middle_name, last_name, gender, age, civil_status, email_address, phone_number, address_purok, address_barangay, address_municipality, address_province, address_zip, resume, date) values ('$first_name','$middle_name','$last_name','$gender',$age,'$civil_status','$email_address','$phone_number','$address_purok','$address_barangay','$address_municipality','$address_province',$address_zip,'$file', '$date')");
    if($send && move_uploaded_file($resume, $file)):
      sendEmail('We\'ve received your application.', $email_address, 'application-received', $_POST);
    endif;
    $_SESSION['message'] = array(
      'type' => 'success',
      'title' => 'Application sent!',
      'message' => 'Hey '.$_POST['first_name'].' '.$_POST['last_name'].', your application was sent successfully. Thank you for reaching us.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
    header("location: application-form.php?ref=".uniqid());
  else:
    $_SESSION['message'] = array(
      'type' => 'warning',
      'title' => 'Too many applications!',
      'message' => 'To many applications matched for '.$_POST['first_name'].' '.$_POST['last_name'].', please try again after we review the previous applications.',
      'page' => basename($_SERVER['REQUEST_URI'])
    );
    header("location: application-form.php?ref=".uniqid());
  endif;
endif;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Application Form - iFovs</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"crossorigin="anonymous"/>
  <link rel="icon" href="assets/favicon.ico">
  <link rel="stylesheet" type="text/css" href="assets/dark.css"/>
  <link rel="stylesheet" type="text/css" href="assets/style.css"/>
  <?php include('includes/popMessage.php'); ?>
</head>
<body class="container bg-white" <?php if(isset($_SESSION['message'])): print 'onload="showMessage()"'; endif; ?>>

<div class="row">
  <div class="d-flex justify-content-center">
    <form style="max-width: 600px;" method="post" action="" enctype="multipart/form-data" class="p-2 p-sm-3 my-sm-2 needs-validation" novalidate>
        <a href="../">
          <img style="width: 80px;" src="assets/logo.png">
        </a>
      <div class="d-flex gap-2 align-items-center rounded-2 bg-info bg-opacity-25 border-bottom border-info border-3 border-opacity-50 my-4 px-2 px-sm-4" style="min-height: 80px;">
        <div class="d-flex align-items-center justify-content-center px-2">
          <i class="bi-info-circle" style="font-size: 35px; line-height: normal;"></i>
        </div>
        <div class="p-2">
          <h1 class="fs-4 dm-display">Instruction</h1>
          <p style="font-size: 14px">Please fill up the form below. All fields are required and don't foget to attach your resume in <mark class="px-2 border rounded-2" style="font-size: 11px">.pdf</mark> format.</p>
        </div>
      </div>
        <h1 class="fs-3 mt-3 mb-3 dm-display">Application Form</h1>
        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your First Name.</div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" id="middle_name" name="middle_name" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your Middle Name.</div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your Last Name.</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="gender" class="form-control" required>
              <option value="">Select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
            <div class="d-none invalid-feedback">Select your gender.</div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="age" class="form-label">Age</label>
            <input type="number" id="age" name="age" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your age.</div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="civil_status" class="form-label">Civil Status</label>
            <select id="civil_status" name="civil_status" class="form-control" required>
              <option value="">Select</option>
              <option value="single">Single</option>
              <option value="married">Married</option>
              <option value="divorced">Divorced</option>
              <option value="widowed">Widowed</option>
            </select>
            <div class="d-none invalid-feedback">Select your status.</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 col-md-8 col-lg-8 has-validation mb-2">
            <label for="email_address" class="form-label">Email Address</label>
            <input type="text" id="email_address" name="email_address" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your Email Address.</div>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 has-validation mb-2">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="text" id="phone_number" name="phone_number" class="form-control" autocomplete="off" required>
            <div class="d-none invalid-feedback">Enter your Phone Number.</div>
          </div>
        </div>
        <h1 class="fs-4 mb-2">Address</h1>
        <div class="row mb-2">
          <div class="col mb-2">
            <label for="address_purok" class="form-label">Purok or Street</label>
            <input type="text" id="address_purok" name="address_purok" class="form-control" autocomplete="off" required>
          </div>
          <div class="col mb-2">
            <label for="address_barangay" class="form-label">Barangay</label>
            <input type="text" id="address_barangay" name="address_barangay" class="form-control" autocomplete="off" required>
          </div>
          <div class="col-sm-12 col-md-4 col-lg-4 mb-2">
            <label for="address_municipality" class="form-label">Municipality</label>
            <input type="text" id="address_municipality" name="address_municipality" class="form-control" autocomplete="off" required>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col">
            <label for="address_province" class="form-label">Province</label>
            <input type="text" id="address_province" name="address_province" class="form-control" autocomplete="off" required>
          </div>
          <div class="col-4">
            <label for="address_zip" class="form-label">ZIP Code</label>
            <input type="text" id="address_zip" name="address_zip" class="form-control" autocomplete="off" required>
          </div>
        </div>
        <h1 class="fs-4 mb-2">Attachment</h1>
        <div class="has-validation mb-2">
          <label for="resume" class="drop-container" id="dropcontainer">
            <span class="drop-title">Attach Resume</span>
            <small>Drag or select a <mark class="px-2 border rounded-2" style="font-size: 11px">.pdf</mark> format.</small>
            <input type="file" id="resume" name="resume" accept="application/pdf" required>
          </label>
        </div>
        <div class="d-flex justify-content-start py-2">
          <button type="submit" name="send" class="btn btn-sm btn-success bg-gradient px-3 py-2"><i class="bi bi-envelope-paper-fill"></i> Send Application</button>
        </div>
    </form>
  </div>
</div>

  <script>
  document.addEventListener('dragover', (e) => {
    e.preventDefault()
  });
  document.addEventListener('drop', (e) => {
    let resume = document.getElementById('resume')
    if(e.dataTransfer.files[0].type!=='application/pdf'){
      Swal.fire({
        icon: 'warning',
        title: 'Invalid Document',
        text: 'Please select a valid .pdf document format.',
        showConfirmButton: false,
        timer: 2000,
        width: 400
      });
    } else {
      resume.files = e.dataTransfer.files;
    }
    e.preventDefault()
  });
  </script>

  <style type="text/css">
    input[type=file]::file-selector-button {
      margin-right: 20px;
      border: none;
      background: #084cdf;
      padding: 10px 20px;
      border-radius: 5px;
      color: #fff;
      cursor: pointer;
      transition: background .2s ease-in-out;
    }

    input[type=file]::file-selector-button:hover {
      background: #0d45a5;
    }
    .drop-container {
      position: relative;
      display: flex;
      gap: 10px;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      min-height: 150px;
      padding: 0px;
      border-radius: 5px;
      border: 1px dashed #999;
      color: #444;
      cursor: pointer;
      user-select: none;
      transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
      background: #fafafa;
      border-color: #111;
    }

    .drop-container:hover .drop-title {
      color: #222;
    }

    .drop-title {
      color: #444;
      font-size: 20px;
      text-align: center;
      transition: color .2s ease-in-out;
      font-family: 'DM Serif Display', serif;
    }
  </style>

  <script type="text/javascript" src="script/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>

<?php

if(isset($_SESSION['message'])):
  if($_SESSION['message']['page']!=basename($_SERVER['REQUEST_URI'])):
    unset($_SESSION['message']);
  endif;
endif;

?>