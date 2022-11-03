<?php
    $base = '../';
    require_once $base.'core/Connection.php';
?>
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Work Log | States</title>
  
  <!-- Stylesheets -->
  <?php include_once $base.'fragments/Stylesheets.php' ?>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <?php
    include_once '../fragments/navbar.php';
  ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php
    include_once '../fragments/sidebar.php';
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-1">
          <div class="col-sm-12">
            <h1 class="m-0">States</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-bordered table-striped" id="stateDt">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>State</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2022 <a href="https://github.com/DMGarcia17">DMGarcia17</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->
<!-- Modal -->
<?php include_once 'modals/statesModals.php' ?>
<!-- REQUIRED SCRIPTS -->
<?php include_once $base.'fragments/scripts.php' ?>

<!-- Constants JS -->
<?php //include_once $base.'fragments/constants.php' ?>

<!-- Data table files -->
<script src=<?php echo $base."dist/js/states.js" ?>></script>
</body>
</html>