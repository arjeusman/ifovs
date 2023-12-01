<?php require('config.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'applications'; ?>
<?php getProcessor('applications'); ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">Applications</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Applications</li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->

  <div class="d-flex gap-2 flex-row flex-nowrap p-2">
    <a href="?view=new" class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center shadow rounded-2 <?php print ($_SESSION['view']=='new')?'bg-info bg-opacity-75 bg-gradient border-info':'bg-secondary bg-opacity-50 border-secondary'; ?>" style="height: 80px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi bi-journal-bookmark" style="font-size: 35px; line-height: normal;"></i>
        <small style="font-size: 10px" class="text-uppercase">Approval</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from applications where is_approved=false and is_discarded=false and is_deleted=false"); ?></h1>
    </a>
    <a href="?view=approved" class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center shadow rounded-2 <?php print ($_SESSION['view']=='approved')?'bg-success bg-opacity-75 bg-gradient border-success':'bg-secondary bg-opacity-50 border-secondary'; ?>" style="height: 80px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi bi-journal-text" style="font-size: 35px; line-height: normal;"></i>
        <small style="font-size: 10px" class="text-uppercase">Interview</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from applications where is_approved=true"); ?></h1>
    </a>
    <a href="?view=discarded" class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center shadow rounded-2 <?php print ($_SESSION['view']=='discarded')?'bg-warning bg-opacity-75 bg-gradient border-warning':'bg-secondary bg-opacity-50 border-secondary'; ?>" style="height: 80px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi bi-recycle" style="font-size: 35px; line-height: normal;"></i>
        <small style="font-size: 10px" class="text-uppercase">Discarded</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from applications where is_discarded=true"); ?></h1>
    </a>
    <a href="?view=deleted" class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center shadow rounded-2 <?php print ($_SESSION['view']=='deleted')?'bg-danger bg-opacity-75 bg-gradient border-danger':'bg-secondary bg-opacity-50 border-secondary'; ?>" style="height: 80px;">
      <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
        <i class="bi bi-trash3" style="font-size: 35px; line-height: normal;"></i>
        <small style="font-size: 10px" class="text-uppercase">Deleted</small>
      </div>
      <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from applications where is_deleted=true"); ?></h1>
    </a>
  </div>

  <div class="d-flex justify-content-end gap-2 px-2 py-2">
    <form class="d-flex align-items-center justify-content-center gap-1">
      <input name="search" class="form-control m-auto" placeholder="Search application" autocomplete="off">
      <button class="btn btn-success bg-gradient"><i class="bi bi-search"></i></button>
      <?php if(isset($_GET['search'])): ?>
        <a title="Close search result." href="applications.php" class="btn btn-danger bg-gradient"><i class="bi bi-x-lg"></i></a>
      <?php endif; ?>
    </form>
  </div>

  <div class="table-responsive"><!-- table -->
    <?php
      if(isset($_GET['search'])):
        $key = $_GET['search'];
        $applications = mysqli_query($con, "select * from applications where first_name like '%$key%' or middle_name like '%$key%' or last_name like '%$key%' or phone_number like '%$key%' or email_address like '%$key%' or home_address like '%$key%' order by id desc");
      else:
        if($_SESSION['view']=='approved'):
          $applications = mysqli_query($con, "select * from applications where is_approved=true order by id desc");
        elseif($_SESSION['view']=='discarded'):
          $applications = mysqli_query($con, "select * from applications where is_discarded=true order by id desc");
        elseif($_SESSION['view']=='deleted'):
          $applications = mysqli_query($con, "select * from applications where is_deleted=true order by id desc");
        else:
        $applications = mysqli_query($con, "select * from applications where is_approved=false and is_discarded=false and is_deleted=false order by id desc");
        endif;
      endif;
    ?>
  <table class="table table-sm">
    <?php if(mysqli_num_rows($applications) > 0): ?>
    <thead>
      <tr class="table-secondary text-uppercase">
        <th></th>
        <th>Name</th>
        <th>Gender</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th></th>
      </tr>
    </thead>
    <?php endif; ?>
    <tbody>
      <?php if(mysqli_num_rows($applications)==0): ?>
        <tr class="align-middle text-center">
          <td colspan="100%" class="py-5 border-0 text-muted fs-6">
            <?php if(isset($_GET['search'])): ?>
              <i class="bi bi-search me-2"></i> No search result for <?php print ($_GET['search'])?$_GET['search']:'none'; ?>.
            <?php else: ?>
              <i class="bi bi-folder-x me-2"></i> No records to show.
            <?php endif; ?>
          </td>
        </tr>
      <?php else: ?>
        <?php if(isset($_GET['search'])): ?>
          <tr class="table-success">
            <td colspan="100%" class="p-2">
              <i class="bi bi-search me-2"></i> Showing search results for <?php print ($_GET['search'])?$_GET['search']:'none'; ?>.
            </td>
          </tr>
        <?php endif; ?>
      <?php endif; ?>
      <?php while($app = mysqli_fetch_assoc($applications)): ?>
      <tr class="align-middle">
        <td class="text-center align-middle">
          <?php
            if($app['is_approved']):
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-success" title="Marked as approved."></small>';
            elseif($app['is_discarded']):
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-warning" title="Discarded application."></small>';
            elseif($app['is_deleted']):
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-danger" title="Deleted application."></small>';
            else:
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-info" title="New application."></small>';
            endif;
          ?>
        </td>
        <td><?php print $app['first_name'].' '.$app['last_name']; ?></td>
        <td class="text-capitalize"><?php print $app['gender']; ?></td>
        <td>
          <?php print $app['email_address']; ?>
          <?php if(countData("select * from employees where email_address='$app[email_address]'") > 0): ?>
            <i title="Email address exist in employee's record." class="bi bi-check-circle ms-1 text-success"></i>
          <?php endif; ?>
        </td>
        <td><?php print $app['phone_number']; ?></td>
        <td><?php print $app['address_barangay'].', '.$app['address_municipality'].', '.$app['address_province']; ?></td>
        <td class="text-end">
          <div class="d-flex justify-content-end gap-1">
          <?php if($app['is_approved']): ?>
            <?php if(countData("select * from employees where email_address='$app[email_address]'") == 0): ?>
            <button onclick="Hire(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-success bg-gradient" title="Hire applicant."><i class="bi-person-check-fill"></i></button>
          <?php else: ?>
            <button onclick="Discard(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-warning bg-gradient text-dark" title="Discard application."><i class="bi-x-lg"></i></button>
            <?php endif; ?>
          <?php endif; ?>
          <?php if(!$app['is_deleted']): ?>
          <button onclick="Read(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-info bg-gradient text-dark" title="View application."><i class="bi-bookmark"></i></button>
          <?php endif; ?>
          <?php if(!$app['is_approved'] && !$app['is_discarded'] && !$app['is_deleted']): ?>
            <button onclick="Approve(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-success bg-gradient text-dark" title="Approve application."><i class="bi-check-lg"></i></button>
          <?php endif; ?>
          <?php if(!$app['is_approved'] && !$app['is_discarded'] && !$app['is_deleted']): ?>
            <button onclick="Discard(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-warning bg-gradient text-dark" title="Discard application."><i class="bi-x-lg"></i></button>
          <?php endif; ?>
          <?php if(!$app['is_approved'] && $app['is_discarded'] && !$app['is_deleted']): ?>
            <button onclick="Delete(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-danger bg-gradient text-dark" title="Delete application."><i class="bi-x-lg"></i></button>
          <?php endif; ?>
          <?php if($app['is_deleted']): ?>
            <button onclick="Recycle(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-warning bg-gradient text-dark" title="Recycle application."><i class="bi-recycle"></i></button>
            <button onclick="Remove(<?php print str_replace('"', "'", json_encode($app)); ?>)" class="btn btn-sm btn-danger bg-gradient text-dark" title="Delete application."><i class="bi-x-lg"></i></button>
          <?php endif; ?>
          </div>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  </div><!-- table -->

</div><!-- card -->

<?php getModal('view-application'); ?>

<script type="text/javascript">
  function Read(data){
    new bootstrap.Modal(document.querySelector("#read")).show();
    document.getElementById('id').innerHTML = 'ifovs-applicant-' + data.id
    document.getElementById('fullname').innerHTML = (data.middle_name!='')?data.first_name + ' ' + data.middle_name + ' ' + data.last_name:data.first_name + ' ' + data.last_name
    document.getElementById('gender').innerHTML = data.gender
    document.getElementById('age_status').innerHTML = data.age + '/' + data.civil_status
    document.getElementById('email').innerHTML = data.email_address
    document.getElementById('phone').innerHTML = data.phone_number
    document.getElementById('address').innerHTML = data.home_address
    document.getElementById('resume').href = data.resume
  }
  function Approve(data){
    let pronoun = (data.gender=='male')?'his':'her'
    Swal.fire({
      icon: 'warning',
      title: 'Approve?',
      iconHtml: '<i class="bi bi-person-fill-check"></i>',
      html: 'Are you sure you want to approve <b>'+data.first_name+'</b>\'s application? This applicant will receive a notice about '+pronoun+' application via email.',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Approve',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-danger bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?approve='+data.id)
      }
    });
  }
  function Hire(data){
    let pronoun = (data.gender=='male')?'his':'her'
    Swal.fire({
      icon: 'warning',
      title: 'Hire?',
      iconHtml: '<i class="bi bi-person-fill-check"></i>',
      html: 'Are you sure you want to hire <b>'+data.first_name+'</b>? This applicant will receive a notice about '+pronoun+' application via email.',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Hire Applicant',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-danger bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?hire='+data.id)
      }
    });
  }
  function Discard(data){
    Swal.fire({
      icon: 'warning',
      title: 'Discard?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to discard <b>'+data.first_name+'</b>\'s application from the record?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Confirm',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-warning bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?discard='+data.id)
      }
    });
  }
  function Recycle(data){
    Swal.fire({
      icon: 'warning',
      title: 'Recycle?',
      iconHtml: '<i class="bi bi-recycle"></i>',
      html: 'Are you sure you want to put <b>'+data.first_name+'</b>\'s application in the discarded applications?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Confirm',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-warning bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?discard='+data.id)
      }
    });
  }
  function Delete(data){
    Swal.fire({
      icon: 'warning',
      title: 'Delete?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to delete <b>'+data.first_name+'</b>\'s application from the record?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Confirm',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-danger bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?delete='+data.id)
      }
    });
  }
  function Remove(data){
    Swal.fire({
      icon: 'warning',
      iconColor: '#facea8',
      title: 'Remove?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to remove <b>'+data.first_name+'</b>\'s application. This can\'t be undone?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg"></i> Confirm',
      cancelButtonText: 'Nope',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg rounded-pill px-4 btn-danger bg-gradient me-2',
        cancelButton: 'btn btn-lg rounded-pill px-4 btn-success bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?remove='+data.id)
      }
    });
  }
</script>

<?php getComponent('footer'); ?>