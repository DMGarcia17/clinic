<?php
    $base = '../';
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
  <title>Calendario de Actividades</title>
  
  <!-- Stylesheets -->
  <?php include_once $base.'fragments/Stylesheets.php' ?>
  <!-- Toastr -->
  <link rel="stylesheet" href=<?php echo $base."plugins/fullcalendar/main.css"?>>
  

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
          <div class="col-sm-7">
            <h1 class="m-0">Calendario de Actividades</h1>
          </div><!-- /.col -->
          <div class="col-sm-5">
            <div class="btn-group float-right" role="group">
              <button class="btn btn-primary" id="btnAddVisit">Agendar Visita</button>
              <button class="btn btn-primary" id="btnAddEvent">Agendar Evento</button>
            </div>
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                  <div class="card-body p-0">
                    <div id="calendar"></div>
                  </div>
                </div>
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
<?php include_once 'modals/calendarModals.php' ?>
<!-- REQUIRED SCRIPTS -->
<?php include_once $base.'fragments/scripts.php' ?>
<!-- FullCalendar 2.2.5 -->
<script src=<?php echo $base."plugins/fullcalendar/main.js"?>></script>
<script src=<?php echo $base."plugins/fullcalendar/locales/es.js"?>></script>
<!-- Data table files -->
<script src=<?php echo $base."dist/js/agenda.js" ?>></script>
</body>
</html>