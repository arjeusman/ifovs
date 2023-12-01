<?php require('config.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'management'; ?>
<?php getProcessor('management'); ?>
<?php getComponent('header'); ?>

<?php if(isset($_GET['id'])): ?>

  <?php $employee = getEmployee($_GET['id']); ?>

<div class="header"><!-- header -->
  <h1 class="header-title"><?php print $employee['first_name'].' '.$employee['last_name']; ?></h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Management</li>
    <li class="breadcrumb-item"><?php print $employee['first_name'].' '.$employee['last_name']; ?></li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->
  <div class="container">
    <div class="row">
      <div class="col">
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th colspan="100%">Employee's Profile</th>
              </tr>
              <tr class="tba">
                <th style="width: 150px;">Keys</th>
                <th>Values</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>First Name</td>
                <td><?php print $employee['first_name']; ?></td>
              </tr>
              <tr>
                <td>Middle Name</td>
                <td><?php print $employee['middle_name']; ?></td>
              </tr>
              <tr>
                <td>Last Name</td>
                <td><?php print $employee['last_name']; ?></td>
              </tr>
              <tr>
                <td>Gender</td>
                <td class="text-capitalize"><?php print $employee['gender']; ?></td>
              </tr>
              <tr>
                <td>Age</td>
                <td><?php print $employee['age']; ?></td>
              </tr>
              <tr>
                <td>Civil Status</td>
                <td><?php print $employee['civil_status']; ?></td>
              </tr>
              <tr>
                <td>Email Address</td>
                <td><?php print $employee['email_address']; ?></td>
              </tr>
              <tr>
                <td>Phone Number</td>
                <td><?php print $employee['phone_number']; ?></td>
              </tr>
              <tr>
                <td>Address</td>
                <td>
                  <p class="m-0"><?php print $employee['address_purok'].', '.$employee['address_barangay']; ?></p>
                  <p class="m-0"><?php print $employee['address_municipality']; ?>, <?php print $employee['address_province'].', '.$employee['address_zip']; ?></p>
                </td>
              </tr>
              <tr>
                <td>Account Credentials</td>
                <td>
                  <p class="m-0">Username: <b><?php print $employee['account_username']; ?></b></p>
                  <p class="m-0">Password: <b><?php print $employee['account_password']; ?></b></p>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div><!-- card -->

<?php endif; ?>

<?php getComponent('footer'); ?>