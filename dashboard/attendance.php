<?php require('config.php'); ?>
<?php protectedContent(); ?>
<?php $active = 'attendance'; ?>
<?php getProcessor('attendance'); ?>
<?php getComponent('header'); ?>

<div class="header"><!-- header -->
  <h1 class="header-title">Attendance</h1>
  <nav aria-label="breadcrumb">
  <ol class="breadcrumb text-white">
    <li class="breadcrumb-item">iFOVS</li>
    <li class="breadcrumb-item">System</li>
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Attendance</li>
    <li class="breadcrumb-item"><?php print date('F d, Y'); ?></li>
  </ol>
  </nav>
</div><!-- header -->

<div class="card"><!-- card -->
  <?php $active = getActiveEmployees(); ?>
  <!-- <?php print_r($active); ?> -->
  <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Position</th>
          <th>Time Checked</th>
          <th style="width: 200px">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($active as $key => $item): ?>
          <tr>
            <td><?php print $item['id']; ?></td>
            <td><?php print $item['first_name'].' '.$item['last_name']; ?></td>
            <td><?php print 'Position'; ?></td>
            <td></td>
            <td>
              <?php
              $date = date('m-d-Y');
              $attendance = mysqli_query($con, "select * from attendance where employee_id=$item[id] and date='$date'");
              $attendance = mysqli_fetch_assoc($attendance);
              ?>
              <button class="btn <?php print ($attendance['is_present'])?'btn-success':'btn-secondary'; ?>" onclick="Attendance('present', <?php print str_replace('"', "'", json_encode($item)); ?>)"><i class="bi-check-lg"></i> Present</button>
              <button class="btn <?php print ($attendance['is_absent'])?'btn-danger':'btn-secondary'; ?>" onclick="Attendance('absent', <?php print str_replace('"', "'", json_encode($item)); ?>)"><i class="bi-x-lg"></i> Absent</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div><!-- card -->

<script type="text/javascript">
  function Attendance(status, data){
    Process()
    window.setTimeout((e)=> {
      window.location.href = '?status='+status+'&id='+data.id
    }, 1000)
  }
</script>

<?php getComponent('footer'); ?>