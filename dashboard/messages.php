<?php require('config.php'); ?>
<?php require('includes/functions.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'messages'; ?>
<?php getProcessor('messages'); ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">Messages</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Messages</li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->
  <div class="d-flex align-items-center justify-content-end gap-2 px-2 py-2">
    <form class="d-flex align-items-center justify-content-center gap-1">
      <input name="search" class="form-control m-auto" placeholder="Search messages" autocomplete="off">
      <button class="btn btn-success bg-gradient"><i class="bi bi-search"></i></button>
      <?php if(isset($_GET['search'])): ?>
        <a title="Close search result." href="messages.php" class="btn btn-danger bg-gradient"><i class="bi bi-x-lg"></i></a>
      <?php endif; ?>
    </form>
  </div>
  <div class="table-responsive"><!-- table -->
  <?php
    if(isset($_GET['search'])):
      $key = $_GET['search'];
      $messages = mysqli_query($con, "select * from messages where fullname like '%$key%' or email_address like '%$key%' order by id desc");
    else:
      $messages = mysqli_query($con, "select * from messages where is_read=false order by id desc");
    endif;
  ?>
  <table class="table">
    <?php if(mysqli_num_rows($messages)>0): ?>
    <thead>
      <tr class="table-secondary text-uppercase">
        <th></th>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Email</th>
        <th></th>
      </tr>
    </thead>
    <?php endif; ?>
    <tbody>
      <?php if(mysqli_num_rows($messages)==0): ?>
        <tr class="align-middle text-center">
          <td colspan="100%" class="py-5 border-0 text-muted fs-6">
            <?php if(isset($_GET['search'])): ?>
              <i class="bi bi-search me-2"></i> No search result for <span class="fw-bolder"><?php print ($_GET['search'])?$_GET['search']:'none'; ?></span>.
            <?php else: ?>
              <i class="bi bi-folder-x me-2"></i> No messages to show.
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
      <?php while($m = mysqli_fetch_assoc($messages)): ?>
      <tr class="align-middle">
        <td>
          <?php
            if($m['is_read']):
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-success" title="Marked as read."></small>';
            else:
              print '<small style="width:10px;height:10px;" class="d-inline-block rounded-circle bg-warning" title="New message."></small>';
            endif;
          ?>
        </td>
        <td><?php print $m['id']; ?></td>
        <td><?php print $m['fullname']; ?></td>
        <td><?php print $m['phone']; ?></td>
        <td><?php print $m['email_address']; ?></td>
        <td class="text-end">
          <?php if(!$m['is_read']): ?>
            <button title="Mark as read." onclick="Read(<?php print str_replace('"', "'", json_encode($m)); ?>)" class="btn btn-sm btn-success bg-gradient"><i class="bi-envelope-fill"></i></button>
          <?php else: ?>
            <button title="View message." onclick="View(<?php print str_replace('"', "'", json_encode($m)); ?>)" class="btn btn-sm btn-success bg-gradient"><i class="bi-envelope-fill"></i></button>
          <?php endif; ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
  </div><!-- table -->
</div><!-- card -->

<script type="text/javascript">
  function Read(data){
    let template = '<div class="text-start p-2" style="font-size: 12px">'
    template = template.concat('<div class="border-bottom py-2 w-50">From: <b>'+data.fullname+'</b></div>')
    template = template.concat('<div class="border-bottom py-2 w-75">Date: <b>'+data.date+'</b></div>')
    template = template.concat('<div class="border-bottom py-2 w-50">Phone: <b>'+data.phone+'</b></div>')
    template = template.concat('<div class="py-2 w-75">Email: <b>'+data.email_address+'</b></div>')
    template = template.concat('<div class="overflow-scroll mt-2 p-3 bg-secondary bg-opacity-10 rounded-3 border" style="max-height: 150px">')
    template = template.concat('<h1 class="fs-5 m-0 mb-1">Message</h1>')
    template = template.concat(data.message)
    template = template.concat('</div>')
    template = template.concat('</div>')
    Swal.fire({
      // icon: 'warning',
      // iconColor: '#1dd2a4',
      // iconHtml: '<i class="bi bi-envelope-fill"></i>',
      title: 'Message',
      html: template,
      showCancelButton: false,
      confirmButtonText: '<i class="bi-check-lg"></i> Mark as read.',
      cancelButtonText: '',
      buttonsStyling: false,
      customClass: {
        confirmButton: 'btn btn-sm rounded-pill px-4 p-2 btn-success bg-gradient me-2',
        cancelButton: 'btn btn-sm rounded-pill px-4 p-2 btn-success bg-gradient',
      },
      width: 400
    }).then((result) => {
      if(result.isConfirmed){
        Process()
        Redirect('?read='+data.id)
      }
    });
  }
  function View(data){
    let template = '<div class="text-start p-2" style="font-size: 12px">'
    template = template.concat('<div class="border-bottom py-2 w-50">From: <b>'+data.fullname+'</b></div>')
    template = template.concat('<div class="border-bottom py-2 w-75">Date: <b>'+data.date+'</b></div>')
    template = template.concat('<div class="border-bottom py-2 w-50">Phone: <b>'+data.phone+'</b></div>')
    template = template.concat('<div class="py-2 w-75">Email: <b>'+data.email_address+'</b></div>')
    template = template.concat('<div class="overflow-scroll mt-2 p-3 bg-secondary bg-opacity-10 rounded-3 border" style="max-height: 150px">')
    template = template.concat('<h1 class="fs-5 m-0 mb-1">Message</h1>')
    template = template.concat(data.message)
    template = template.concat('</div>')
    template = template.concat('</div>')
    Swal.fire({
      title: 'Message',
      html: template,
      showCancelButton: false,
      showConfirmButton: false,
      confirmButtonText: '<i class="bi-check-lg"></i> Done.',
      width: 400
    })
  }
</script>


<?php getComponent('footer'); ?>