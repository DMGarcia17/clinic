<?php
    $base = '../';
    
    session_start();
    if(!isset($_SESSION['user']) || $_SESSION['user'] == ''){
      header("Location: http://localhost/clinic/login.php?error=1"); 
    }
    if(isset($_GET['ID']) and $_GET['ID'] != ""){
        echo "<input type='hidden' name='patientId' id='patientId' value='{$_GET['ID']}'>";
    }
    
    require_once '../core/Connection.php';
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
  <title>Citas M&eacute;dicas</title>
  
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
            <h1 class="m-0">Citas M&eacute;dicas</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-striped" id="appointments" area-label="A table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Fecha</th>
                            <th>Motivo Resumido</th>
                            <th>Diagnostico</th>
                            <th>Acciones</th>
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
<?php include_once 'modals/appointmentsModals.php' ?>
<!-- REQUIRED SCRIPTS -->
<?php include_once $base.'fragments/scripts.php' ?>
<!-- Data table files -->
<script src=<?php echo $base."dist/js/appointments.js" ?>></script>
</body>
</html>