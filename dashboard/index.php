<?php require('config.php'); ?>
<?php require('includes/functions.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'dashboard'; ?>
<?php getProcessor('applications'); ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">Dashboard</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->

  <div class="d-flex gap-2 flex-row flex-nowrap p-2">
    <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center rounded shadow bg-success bg-opacity-75 bg-gradient border-success" style="height: 100px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi-people-fill" style="font-size: 50px; line-height: normal;"></i>
        <small class="text-uppercase">Employees</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees where is_active=true"); ?></h1>
    </div>
    <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center rounded shadow bg-danger bg-opacity-75 bg-gradient border-danger" style="height: 100px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi-person-fill-exclamation" style="font-size: 50px; line-height: normal;"></i>
        <small class="text-uppercase">Inactive</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees where is_active=false"); ?></h1>
    </div>
    <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center rounded shadow bg-warning bg-opacity-75 bg-gradient border-warning" style="height: 100px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi bi-envelope-at-fill" style="font-size: 50px; line-height: normal;"></i>
        <small class="text-uppercase">Messages</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from messages where is_read=false"); ?></h1>
    </div>  
  </div>

</div><!-- card -->

<?php getComponent('footer'); ?>