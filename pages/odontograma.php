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
                        <div id="radio" class="mb-md-3 act-rad" data-toggle="buttons">
                            <fieldset>
                            <!--<input type="radio" id="radio1" name="accion" value="fractura"  /><label for="radio1" >Caries</label>
                            <input type="radio" id="radio2" name="accion" value="restauracion" /><label for="radio2" >Amalgama</label>
                            <input type="radio" id="radio5" name="accion" value="fract" /><label for="radio5" >Fractura</label>
                            <input type="radio" id="radio5" name="accion" value="csecundaria" /><label for="radio5" >Caries Secundaria</label>
                            <input type="radio" id="radio5" name="accion" value="rradiculares" /><label for="radio5" >Restos Radiculares</label>
                            <input type="radio" id="radio5" name="accion" value="tcaries" /><label for="radio5" >Tratamiento de Caries</label>
                            <input type="radio" id="radio5" name="accion" value="endodoncia" /><label for="radio5" >Endodoncia</label>
                            <input type="radio" id="radio5" name="accion" value="iendo" /><label for="radio5" >Indicación por endodoncia</label>
                            <input type="radio" id="radio5" name="accion" value="pieza" /><label for="radio5" >Ausencia de pieza</label>
                            <input type="radio" id="radio4" name="accion" value="extraccion" /><label for="radio4" >Indicada para extraccion</label>
                            <input type="radio" id="radio3" name="accion" value="borrar" /><label for="radio3" >Borrar</label>-->
                            <select name="accion" id="" class="form-control">
                                <option value="fractura">Caries</option>
                                <option value="restauracion">Amalgama</option>
                                <option value="fract">Fractura</option>
                                <option value="csecundaria">Caries Secundaria</option>
                                <option value="rradiculares">Restos Radiculares</option>
                                <option value="tcaries">Tratamiento de Caries</option>
                                <option value="endodoncia">Endodoncia</option>
                                <option value="iendo">Indicación por endodoncia</option>
                                <option value="pieza">Ausencia de pieza</option>
                                <option value="extraccion">Indicada para extraccion</option>
                                <option value="borrar">Borrar</option>
                            </select>
                            </fieldset><!--<label for="radio5" class="btn btn-secondary"><input type="radio" id="radio5" name="accion" value="puente" />Puente</label>-->
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
                            <td>Caries</td>
                            <td><div style="background-color: red !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Amalgama</td>
                            <td><div style="background-color: blue !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Fractura</td>
                            <td><div style="background-color: #5a3825 !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Caries Secundaria</td>
                            <td><div style="background-color: #ffea61 !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Restos radiculares</td>
                            <td><div style="background-color: #000 !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Tratamiento de Caries</td>
                            <td><div style="background-color: #dbc500 !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Endodoncia</td>
                            <td><div style="background-color: #db8000 !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Indicación por endodoncia</td>
                            <td><div style="background-color: #00db8b !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Ausencia de pieza</td>
                            <td><div style="background-color: #a400db !important; min-width: 3rem; min-height: 1rem;"></div></td>
                        </tr>
                        <tr>
                            <td>Indicada para Extracci&oacute;n</td>
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