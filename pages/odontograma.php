<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Odontograma</title>
    <link rel="stylesheet" href="../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../dist/css/odontograma.css">
    
</head>
<body>

    <div class="container-fluid">
        <div class="row row1" style="min-height: 510px;">
            
            
            <div class="col-md-8">
                <div class="row info-pt">
                    <div class="col-md-12">
                        <div class="row">
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
                                if (count($res[0]) <= 0 || !isset($_GET['id'])){
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
                        <div class="row mt-md-5">
                            <div class="col-md-8">
                                <?php
                                    $res = $db->filtered_query("patients p", "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", "p.cod_patient='{$_GET['id']}'");
                                    if (count($res[0]) <= 0){
                                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                                    }
                                    echo "<span class='font-weight-bold'>Nombre del paciente: </span><span class='Font-weight-normal'>{$res[0]['name']}</span>"
                                ?>
                            </div>
                            <div class="col-md-4">
                                <span class="font-weight-bold">Fecha: </span><span class="font-weight-light" id="fechaOd"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="canvasesdiv" style="position:relative; top:20px;">
                            <canvas id="myCanvas" width="810" height="510" style="z-index: 1; position:absolute; left:0px; top:0px;"></canvas>
                            <canvas id="myCanvas2" width="810" height="510" style="z-index: 2; position:absolute; left:0px; top:0px;"></canvas>
                            <canvas id="myCanvas3" width="810" height="510" style="z-index: 3; position:absolute; left:0px; top:0px;"></canvas>
                            <canvas id="myCanvas4" width="810" height="510" style="z-index: 4; position:absolute; left:0px; top:0px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <div id="radio" class="btn-group btn-group-toggle mb-md-3 act-rad" data-toggle="buttons">
                            <label for="radio1" class="btn btn-secondary"><input type="radio" id="radio1" name="accion" value="fractura"  />Fractura</label>
                            <label for="radio2" class="btn btn-secondary"><input type="radio" id="radio2" name="accion" value="restauracion" />Restauracion</label>
                            <label for="radio4" class="btn btn-secondary"><input type="radio" id="radio4" name="accion" value="extraccion" />Extraccion</label>
                            <label for="radio5" class="btn btn-secondary"><input type="radio" id="radio5" name="accion" value="csecundaria"checked />Caries Secundaria</label>
                            <label for="radio3" class="btn btn-secondary"><input type="radio" id="radio3" name="accion" value="borrar" />Borrar</label>
                            <!--<label for="radio5" class="btn btn-secondary"><input type="radio" id="radio5" name="accion" value="puente" />Puente</label>-->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div id="radio_seccion" class="btn-group btn-group-toggle act-rad" data-toggle="buttons" style='display:none !important;'>
                                    <label for="radio_1" class="btn btn-secondary"><input type="radio" id="radio_1" name="seccion" value="seccion" checked />Seccion</label>
                                    <label for="radio_2" class="btn btn-secondary"><input type="radio" id="radio_2" name="seccion" value="diente" />Diente</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary act-rad" onClick="imprimir();"><em class="fa fa-print"></em></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
        <div class="row">
            <div class="col-md-2">
                <table class="table table-bordered">
                    <thead>
                        <th>Opci&oacute;n</th>
                        <th>Color</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Fractura</td>
                            <td><div style="background-color: red !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Restauraci&oacute;n</td>
                            <td><div style="background-color: blue !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Extracci&oacute;n</td>
                            <td style="font-size:1.5rem;">&times;</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-8"></div>
        </div>
    </div>
    

    <script src="../plugins/jquery/jquery.min.js"></script>
    <script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../plugins/moment/moment.min.js"></script>
    <script src="../plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="../plugins/toastr/toastr.min.js"></script>
    <script src="../dist/js/numbers.js"></script>
    <script src="../dist/js/odontograma.js"></script>
</body>