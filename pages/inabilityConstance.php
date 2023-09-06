<?php
    require_once '../core/public.php';
    session_start();
    if(!isset($_SESSION['codClinic'])){
        header("Location: http://".host."/clinic/login.php?error=1"); 
    }
    
    require_once '../core/Connection.php';
    $db = new DatabaseConnection();
    $resUser = $db->filtered_query("users", "complete_name", "username='{$_SESSION['user']}'");
    if (count($resUser[0]) <= 0 || !isset($_GET['id']) || !isset($_GET['p'])){
        header("Location: http://".host."/clinic/pages/appointments.php"); 
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Receta M&eacute;dica</title>
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/prescription.css">
    
</head>
<body>

    <div class="container-fluid">
        <div class="row pt-5" style="">
            <div class="col-md-12">
                <div class="d-flex justify-content-center">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12" >
                            <div class="row info-pt">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <img src="../dist/img/logo_color_trs.png" alt="Logo" class="rounded">
                                        </div>
                                        <div class="col-md-10 pl-md-5">
                                            <?php
                                            if(!isset($_SESSION['codClinic'])){
                                                header("Location: http://".host."/clinic/login.php?error=1"); 
                                            }
                                            
                                            require_once '../core/Connection.php';
                                            $db = new DatabaseConnection();
                                            $res = $db->filtered_query("clinics", "clinic_name, address, phone_number", "cod_clinic='{$_SESSION['codClinic']}'");
                                            echo "<h3>
                                                        {$res[0]['clinic_name']}
                                                        <br/>
                                                        <small class='text-muted'>Estamos ubicados en {$res[0]['address']}</small>
                                                    </h3>
                                                    <h6>Tel&eacute;fono: {$res[0]['phone_number']}</h6>";
                                            ?>
                                        </div>
                                    </div>
                                    <div class="row mt-md-5">
                                        <div class="col-md-8">
                                        <h6>A quien corresponda:</h6>
                                        </div>
                                        <div class="col-md-4">
                                            <span class="font-weight-bold">Fecha: </span><span class="font-weight-light" id="fechaOd"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="row pb-5">
            <div class="col-md-12">
                <br><br>
                <p style="text-align: justify;"> Por medio de la presente hago constar que el paciente:  
                <?php
                    $res = $db->filtered_query("patients p", "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", "p.cod_patient='{$_GET['p']}'");
                    if (count($res[0]) <= 0){
                        header("Location: http://".host."/clinic/pages/appointments.php"); 
                    }
                    echo "<span><span class='font-weight-bold'></span>{$res[0]['name']}</span>";
                ?>
                esta incapacitado para realizar sus labores el (los) d&iacute;a(s) <?php echo $_POST['inabilityDays'] ?>.
                </p>
                <br>
                <p>El motivo es: <?php echo $_POST['cause'] ?>.</p>
                <p>Por su compresión gracias.</p>
            </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="text-align: center;">
                </div>
                <div class="col-md-6" style="text-align: center;">
                    <span>_________________________________</span><br>
                    <span><?php echo $resUser[0]['complete_name']; ?></span>
                    <p><?php echo $resUser[0]['complete_name']; ?></p>
                </div>
            </div>
            <div class="row">
            <div class="col-md-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-secondary act-rad float-right" onClick="imprimir();"><em class="fa fa-print"></em></button>
                    <button class="btn btn-primary act-rad" <?php echo 'onClick= "window.location.href = \'http://'.host.'/clinic/pages/appointments.php\'"'?> >Volver al sistema</button>
                </div>
            </div>
        </div>
        </div>
        
    </div>
    

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../plugins/moment/moment.min.js"></script>
    <script>
        let imprimir = () => {
            $('.act-rad').fadeOut(0);
            window.print();
            $('.act-rad').fadeIn(0);
        }
        
        $('#fechaOd').text(new moment().format('DD/MM/YYYY'));
    </script>
</body>