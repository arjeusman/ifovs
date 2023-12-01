<?php require('config.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'management'; ?>
<?php getProcessor('management'); ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">Management</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Management</li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->

<div class="d-flex gap-2 flex-row flex-nowrap p-2">
    
  <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 border-success flex-fill d-flex gap-2 align-items-center rounded shadow bg-success bg-opacity-75 bg-gradient" style="height: 80px;">
    <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
      <i class="bi bi-person" style="font-size: 35px; line-height: normal;"></i>
      <small style="font-size: 10px" class="text-uppercase">Active</small>
    </div>
    <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees where is_active=true"); ?></h1>
  </div>
  <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 border-warning flex-fill d-flex gap-2 align-items-center rounded shadow bg-warning bg-opacity-75 bg-gradient" style="height: 80px;">
    <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
      <i class="bi bi-person-exclamation" style="font-size: 35px; line-height: normal;"></i>
      <small style="font-size: 10px" class="text-uppercase">Inactive</small>
    </div>
    <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees where is_inactive=true"); ?></h1>
  </div>
  <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 border-secondary flex-fill d-flex gap-2 align-items-center rounded shadow bg-secondary bg-opacity-75 bg-gradient" style="height: 80px;">
    <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
      <i class="bi bi-people" style="font-size: 35px; line-height: normal;"></i>
      <small style="font-size: 10px" class="text-uppercase">Total</small>
    </div>
    <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees"); ?></h1>
  </div>
  <div class="text-dark text-decoration-none overflow-hidden border-bottom border-5 flex-fill d-flex gap-2 align-items-center rounded shadow bg-danger bg-opacity-75 bg-gradient border-danger" style="height: 80px;">
    <div class="col-5 d-flex flex-column align-items-center justify-content-center bg-white bg-opacity-10 px-3 h-100">
      <i class="bi bi-person-x" style="font-size: 35px; line-height: normal;"></i>
      <small style="font-size: 10px" class="text-uppercase">Deleted</small>
    </div>
    <h1 class="fs-1 m-0 text-center flex-fill"><?php print countData("select * from employees where is_deleted=true"); ?></h1>
  </div>
</div>

<div class="d-flex align-items-center justify-content-end gap-2 px-2 py-2">
  <!-- Button trigger modal -->
  <button type="button" class="btn btn-primary bg-gradient" data-bs-toggle="modal" data-bs-target="#add"><i class="bi bi-person-plus-fill me-2"></i> Employee</button>
  <form class="d-flex align-items-center justify-content-center gap-1">
    <input name="search" class="form-control m-auto" placeholder="Search employee" autocomplete="off">
    <button class="btn btn-success bg-gradient"><i class="bi bi-search"></i></button>
    <?php if(isset($_GET['search'])): ?>
      <a title="Close search result." href="management.php" class="btn btn-danger bg-gradient"><i class="bi bi-x-lg"></i></a>
    <?php endif; ?>
  </form>
</div>

<div class="table-responsive"><!-- table -->
<?php
  if(isset($_GET['search'])):
    $key = $_GET['search'];
    $employees = mysqli_query($con, "select * from employees where first_name like '%$key%' or middle_name like '%$key%' or last_name like '%$key%' or phone_number like '%$key%' or email_address like '%$key%' order by id desc");
  else:
    $employees = mysqli_query($con, "select * from employees where is_deleted=false order by id desc");
  endif;
?>
<table class="table table-sm">
  <?php if(mysqli_num_rows($employees)>0): ?>
  <thead>
    <tr class="table-secondary text-uppercase">
      <td></td>
      <td>ID</td>
      <td>Name</td>
      <td>Email</td>
      <td>Phone</td>
      <td>Address</td>
      <td></td>
    </tr>
  </thead>
  <?php endif; ?>
  <tbody>
    <?php if(mysqli_num_rows($employees)==0): ?>
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
    <?php while($e = mysqli_fetch_assoc($employees)): ?>
    <tr class="align-middle">
      <td>
        <?php
          if($e['is_active']):
            print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-success" title="Active record."></small>';
          elseif($e['is_inactive']):
            print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-warning" title="Inactive record."></small>';
          else:
            print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-danger" title="Deleted record."></small>';
          endif;
        ?>
      </td>
      <td><?php print $e['id']; ?></td>
      <td><?php print $e['first_name'].' '.$e['last_name']; ?></td>
      <td><?php print $e['email_address']; ?></td>
      <td><?php print $e['phone_number']; ?></td>
      <td><?php print $e['address_barangay'].', '.$e['address_municipality'].', '.$e['address_province']; ?></td>
      <td class="text-end">
        <?php if($e['is_active']): ?>
        <a href="<?php print 'view.php?id='.$e['id']; ?>" title="View employee." class="btn btn-sm btn-success bg-gradient"><i class="bi bi-person-fill"></i></a>
        <button title="Send login credentials." onclick="SendEmail(<?php print str_replace('"', "'", json_encode($e)); ?>)" class="btn btn-sm btn-success bg-gradient"><i class="bi bi-envelope-fill"></i></button>
        <?php endif; ?>
        <button onclick="Edit(<?php print str_replace('"', "'", json_encode($e)); ?>)" class="btn btn-sm btn-primary bg-gradient"><i class="bi bi-pencil"></i></button>
        <?php if(!$e['is_active']): ?>
          <button title="Set active record." onclick="SetActive(<?php print str_replace('"', "'", json_encode($e)); ?>)" class="btn btn-sm btn-success bg-gradient"><i class="bi bi-person-fill"></i></button>
          <button title="Remove record." onclick="Remove(<?php print str_replace('"', "'", json_encode($e)); ?>)" class="btn btn-sm btn-danger bg-gradient"><i class="bi bi-trash3"></i></button>
        <?php endif; ?>
        <?php if(!$e['is_inactive']): ?>
          <button title="Set inactive record." onclick="SetInActive(<?php print str_replace('"', "'", json_encode($e)); ?>)" class="btn btn-sm btn-warning bg-gradient"><i class="bi bi-person-fill-exclamation"></i></button>
        <?php endif; ?>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
</div><!-- table -->

</div><!-- card -->

<?php getModal('add-employee'); ?>
<?php getModal('edit-employee'); ?>

<script type="text/javascript">
  function Edit(data){
    new bootstrap.Modal(document.querySelector("#edit")).show();
    for(var d in data){
      let input = document.querySelector('#edit *[name="'+d+'"]')
      if(input.tagName.toLowerCase()=='select'){
        for(var op = 0; op <= (input.options.length - 1); op++){
         if(input.options.item(op).value==data[d]){
          input.selectedIndex = op
         }
        }
      } else {
        input.value = data[d]
      }
    }
  }
  function SetActive(data){
    Swal.fire({
      icon: 'warning',
      title: 'Set Active?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to set this record into active?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg "></i> Confirm',
      cancelButtonText: 'Nope.',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg btn-success bg-gradient me-2',
        cancelButton: 'btn btn-lg btn-danger bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?active='+data.id)
      }
    });
  }
  function SetInActive(data){
    Swal.fire({
      icon: 'warning',
      title: 'Set Inactive?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to set this record into inactive?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg "></i> Confirm',
      cancelButtonText: 'Nope.',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg btn-warning bg-gradient me-2',
        cancelButton: 'btn btn-lg btn-danger bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?inactive='+data.id)
      }
    });
  }
  function SendEmail(data){
    Swal.fire({
      icon: 'warning',
      title: 'Send Email?',
      iconHtml: '<i class="bi bi-envelope"></i>',
      html: 'Are you sure you want to send the login credentials for this email?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg "></i> Confirm',
      cancelButtonText: 'Nope.',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg btn-warning bg-gradient me-2',
        cancelButton: 'btn btn-lg btn-danger bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?send='+data.id)
      }
    });
  }
  function Delete(data){
    Swal.fire({
      icon: 'warning',
      title: 'Delete?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to delete <b>'+data.first_name+' '+data.last_name+'</b> in your record?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg "></i> Confirm',
      cancelButtonText: 'Nope.',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg btn-danger bg-gradient me-2',
        cancelButton: 'btn btn-lg btn-danger bg-gradient',
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
      title: 'Remove?',
      iconHtml: '<i class="bi bi-trash3"></i>',
      html: 'Are you sure you want to remove <b>'+data.first_name+' '+data.last_name+'</b> in your record?',
      showCancelButton: false,
      confirmButtonText: '<i class="bi bi-check-lg "></i> Confirm',
      cancelButtonText: 'Nope.',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-lg btn-danger bg-gradient me-2',
        cancelButton: 'btn btn-lg btn-danger bg-gradient',
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