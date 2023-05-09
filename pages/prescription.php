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
        <div class="row" style="">
            <div class="col-md-2">
                <img src="../dist/img/logo_color_trs.png" alt="Logo" class="rounded">
            </div>
            <div class="col-md-10 pl-md-5">
                <?php
                session_start();
                if(!isset($_SESSION['codClinic'])){
                    header("Location: http://localhost/clinic/login.php?error=1"); 
                }
                
                require_once '../core/Connection.php';
                $db = new DatabaseConnection();
                $res = $db->filtered_query("clinics", "clinic_name, address, phone_number", "cod_clinic='{$_SESSION['codClinic']}'");
                if (count($res[0]) <= 0 || !isset($_GET['id']) || !isset($_GET['p'])){
                    header("Location: http://localhost/clinic/pages/appointments.php"); 
                }
                echo "<h3>
                            {$res[0]['clinic_name']}
                            <br/>
                            <small class='text-muted'>Estamos ubicados en {$res[0]['address']}</small>
                        </h3>
                        <h6>Tel&eacute;fono: {$res[0]['phone_number']}</h6>";
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <hr>
            </div>
        </div>
        <div class="row pb-5">
            <div class="col-md-10">
                <?php
                    $res = $db->filtered_query("patients p", "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", "p.cod_patient='{$_GET['p']}'");
                    if (count($res[0]) <= 0){
                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                    }
                    echo "<span><span class='font-weight-bold'>Paciente:&nbsp;</span>{$res[0]['name']}</span>";
                ?>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-secondary act-rad float-right" onClick="imprimir();"><em class="fa fa-print"></em></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-muted">
                <p>Nuestros servicios:</p>
                <?php
                    
                    $res = $db->filteredOquery('treatments', "name treatment", "pr_order<=10", 'pr_order asc');
                    if (count($res[0]) <= 0){
                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                    }
                    foreach($res as $r){
                        echo "<p>- {$r['treatment']}</p>";
                    }
                ?>
                <p>- Entre otros...</p>
            </div>
            <div class="col-md-10">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th style="width: 1em;">Cantidad</th>
                            <th style="width: 20em;">Medicina</th>
                            <th>Indicaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $res = $db->filteredOquery('mpp m', "m.cod_mpp, (select a.description from medicines a where a.cod_medicine = m.cod_medicine) medicine, m.amount, m.indication, row_number() over (order by cod_mpp) id_mpp", "m.cod_prescription=".$_GET['id'], 'cod_mpp');
                            if (count($res[0]) <= 0){
                                header("Location: http://localhost/clinic/pages/appointments.php"); 
                            }
                            foreach($res as $r){
                                echo "<tr>
                                        <td>{$r['medicine']}</td>
                                        <td>{$r['indication']}</td>
                                    </tr>";
                            }
                        ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                
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