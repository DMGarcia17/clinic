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
                                    CONSENTIMIENTO INFORMADO PARA LA PRACTICA DE TRATAMIENTOS ODONTOLOGICOS, E INTERVENCIONES QUIRÚRGICAS Y/O PROCEDIMIENTOS ESPECIALES
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
                    echo "<span class='font-weight-bold'><span ></span>{$res[0]['name']}</span>";
                ?>
                identificado (a) como aparece al pie de mi firma, por medio del presente documento, en nombre propio o en mi calidad de representante legal del paciente en pleno y normal uso de mis facultades mentales otorgo en forma libre mi consentimiento al odontólogo (a)
                <span class='font-weight-bold'><?php echo $resUser[0]['complete_name'] ?> </span>
                , asi como de los auxiliares y técnicos en ejercicio legal de su profesión, practiquen el siguiente tratamiento odontológico y/o intervención quirúrgica a través de los siguientes procedimientos: 
                </p>
                <p class='font-weight-bold'><?php echo $_POST['procedures'] ?></p>
                <p style="text-align: justify;">
                    <?php 
                        switch($_POST['prognosis']){
                            case 'B':
                                echo "El pronóstico del tratamiento a realizar es: Bueno: __<span class='font-weight-bold'>X</span>__, Regular:_____, Malo:_____ .";
                                break;
                            case 'R':
                                echo "El pronóstico del tratamiento a realizar es: Bueno: _____, Regular:__<span class='font-weight-bold'>X</span>__, Malo:_____ .";
                                break;
                            case 'M':
                                echo "El pronóstico del tratamiento a realizar es: Bueno: _____, Regular:_____, Malo:__<span class='font-weight-bold'>X</span>__ .";
                                break;
                            default:
                                echo "El pronóstico del tratamiento a realizar es: Bueno: _____, Regular:_____, Malo:_____ .";
                                break;
                        }
                    ?>    
                    
                </p>
                <p>Asi mismo quedan autorizados para llevar a cabo o solicitar la práctica de conductas o procedimientos odontológicos adicionales a los ya autorizados en el punto anterior, cuando el resultado del tratamiento asi lo requiera. </p>
                <p>Se informa de la existencia de riesgos asi: </p>
                <p>Generales:</p>
                <?php 
                    if (isset($_POST['generalRisk'])){
                        echo "<p class='font-weight-bold'>{$_POST['generalRisk']}</p>";
                    }else{
                        echo '<hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">';
                    }
                ?>
                
                <p>Especificos: </p>
                <?php 
                    if (isset($_POST['specificRisk'])){
                        echo "<p class='font-weight-bold'>{$_POST['specificRisk']}</p>";
                    }else{
                        echo '<hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">
                        <hr style="border: none; height: 1px; color: #333; background-color: #333;">';
                    }
                ?>
                <p>O de aquellos imprevisibles que por su misma caracteristica no se pueden advertir razonablemente </p>
                <p>Como paciente o representante legal, declaro que conozco y comprendo en su totalidad la explicación antes dada y la posibilidad de que estos eventos se presenten en el desarrollo del curso del tratamiento y/o del postoperatorio y acepto todos los riesgos que conlleva los tratamientos a realizar. Acepto que la Odontologia no es una ciencia exacta y que con la intervención autorizada se busca la utilización de los medios idóneos para el caso y los resultados no dependen exclusivamente del odontólogo </p>
                <p>Certifico que el presente documento ha sido leido y aceptado por mi en su integridad. </p>
            </div>
            </div>
            <div class="row">
                <div class="col-md-6" style="text-align: center;">
                    <span>_________________________________</span>
                    <p>Firma del Paciente</p>
                </div>
                <div class="col-md-6" style="text-align: center;">
                    <span>_________________________________</span>
                    <p>Dr. Diego de Jesús Villalpando Correa</p>
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