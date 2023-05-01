<?php
    session_start();
    if(!isset($_SESSION['codClinic'])){
        header("Location: http://localhost/clinic/login.php?error=1"); 
    }
    
    require_once '../core/Connection.php';
    $db = new DatabaseConnection();
    $resUser = $db->filtered_query("users", "complete_name", "username='{$_SESSION['user']}'");
    if (count($resUser[0]) <= 0 || !isset($_GET['id']) || !isset($_GET['p'])){
        header("Location: http://localhost/clinic/pages/appointments.php"); 
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
                            <div class="col-md-12" style="text-align: center;">
                                <h6>
                                    CONSENTIMIENTO INFORMADO PARA LA PRACTICA DE TRATAMIENTOS ODONTOL&Oacute;GICOS
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        <div class="row pb-5">
            <div class="col-md-12">
                <p style="text-align: justify;"> Yo, 
                <?php
                    $res = $db->filtered_query("patients p", "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", "p.cod_patient='{$_GET['p']}'");
                    if (count($res[0]) <= 0){
                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                    }
                    echo "<span><span class='font-weight-bold'></span>{$res[0]['name']}</span>";
                ?>
                autorizo al Cirujano Dentista 
                <?php echo $resUser[0]['complete_name'] ?> 
                con registro profesional (COP ________________) a realizarme ___________________________________________________________________________.
                <br>
                El tratamiento consistira en:  
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <br>
                Los beneficios del tratamiento son:
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                y mi negación al tratamiento traer&iacute;an consecuencias tales como:
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                Existen riesgos que pueden surgir en el curso del tratamiento, tales como:
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                </p>
                <br>
                <p>Autorizo que se obtengan (marque la opci&oacute;n que desee):</p>
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-8">- Fotograf&iacute;as</div>
                            <div class="col-md-2">(Si)</div>
                            <div class="col-md-2">(No)</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">- Videos</div>
                            <div class="col-md-2">(Si)</div>
                            <div class="col-md-2">(No)</div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">- Otros registros gr&aacute;ficos</div>
                            <div class="col-md-2">(Si)</div>
                            <div class="col-md-2">(No)</div>
                        </div>
                    </div>
                    <div class="col-md-8"></div>
                </div>
                <p>en el pre - intra y post-operatorio.</p>
            </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="text-align: center;">
                    <p>_________________________________</p>
                    <p>Firma del Paciente</p>
                </div>
                <div class="col-md-6" style="text-align: center;">
                    <p>_________________________________</p>
                    <p>Dr. Diego delesús Villalpando Correa</p>
                </div>
            </div>
            <div class="row">
            <div class="col-md-2">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-secondary act-rad float-right" onClick="imprimir();"><em class="fa fa-print"></em></button>
                    <button class="btn btn-primary act-rad" onClick='window.location.href = "http://localhost/clinic/pages/appointments.php";'>Volver al sistema</button>
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
    </script>
</body>