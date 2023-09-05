<?php
    $base = './';
    if(isset($_GET['error']) and $_GET['error'] != ""){
        echo "<input type='hidden' name='error' id='error' value='{$_GET['error']}'>";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- JQuery Datatables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link rel="stylesheet" href='<?php echo $base."dist/css/validate.errors.css"?>'>
    <link rel="stylesheet" href="dist/css/login.css">
    <title>Log In</title>
</head>
<body>
    <div id="image">
        <!-- <img src="./dist/img/logo_color_trs.png" alt="..." /> -->
    </div>
    <div class="container blackout" id="card-login">
        <div class="card mx-auto pagination-centered" style="width: 23rem;">
            <div class="card-body">
                <form id="logInForm">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" name="username" id="username" autocomplete="off" class="form-control" >
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contrase&ntilde;a</label>
                        <input type="password" name="password" id="password" autocomplete="off" class="form-control">
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary mx-auto" id="logIn" type="submit">Iniciar Sesión</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js" ></script>
    <!-- SweetAlert2 -->
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- Toastr -->
    <script src="plugins/toastr/toastr.min.js"></script>
    <!-- JQuery Validate -->
    <script src='<?php echo $base."plugins/jquery-validation/jquery.validate.min.js"?>'></script>
    <script src='<?php echo $base."dist/js/validateMethods.js"?>'></script>
    <!-- Custom -->
    <script src="dist/js/login.js"></script>
</body>
</html>