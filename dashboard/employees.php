<?php require('config.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'employees'; ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">My Employees</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">My Employees</li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->

</div><!-- card -->


<?php getComponent('footer'); ?>