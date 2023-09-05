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
                $res = $db->filtered_query("clinics", "clinic_name, address, phone_number, wssp_phone", "cod_clinic='{$_SESSION['codClinic']}'");
                if (count($res[0]) <= 0 || !isset($_GET['id']) || !isset($_GET['p'])){
                    header("Location: http://localhost/clinic/pages/appointments.php"); 
                }
                echo "<h3  style='color:#0a07ba !important; font-family: 'Bernard MT Condensed' !important;'>
                            DEYCAR<span class='font-weight-light'>DENT</span>
                            <br/>
                            
                        </h3>
                        <h3><small class='text-muted'  style='color:#0a07ba !important;'>Estamos ubicados en {$res[0]['address']}</small></h3>
                        <h6 style='color:#0a07ba !important;'>Nuestro n&uacute;mero de tel&eacute;fono: &nbsp;<em class='fas fa-phone'></em> {$res[0]['phone_number']}&nbsp; o si lo prefieres b&uacute;scanos en WhatsApp: &nbsp;<em class='fa-brands fa-whatsapp' style='color: #04bd04 !important;'></em> {$res[0]['wssp_phone']}</h6>";
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
                    echo "<h4><span class='font-weight-bold' style='color:#0a07ba !important;'>Paciente:&nbsp;</span>{$res[0]['name']}</h4>";
                ?>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-secondary act-rad float-right" onClick="imprimir();"><em class="fa fa-print"></em></button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2 text-muted" style="color: #0a07ba !important">
                <h4>Nuestros servicios:</h4>
                <?php
                    
                    $res = $db->filteredOquery('treatments', "name treatment", "pr_order<=10", 'pr_order asc');
                    if (count($res[0]) <= 0){
                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                    }
                    echo '<ul>';
                    foreach($res as $r){
                        echo "<li style='font-size: 1.25rem;'>{$r['treatment']}</li>";
                    }
                ?>
                <li style='font-size: 1.25rem;'>Entre otros...</li>
                </ul>
            </div>
            <div class="col-md-10">
                <?php
                    $res = $db->filteredOquery('invoices i', "cod_invoice, treatment, amount, created_at, paid_at, ((select sum(p.amount) from payments p where p.cod_invoice = i.cod_invoice)-amount) paid", "i.cod_invoice=".$_GET['id'], 'created_at asc');
                    if (count($res[0]) <= 0){
                        header("Location: http://localhost/clinic/pages/appointments.php"); 
                    }
                    foreach($res as $r){
                        echo "<span class='font-weight-bold'>Tratamiento aplicado: <span class='font-weight-normal'>{$r['treatment']}</span> </br>Monto Total por el Tratamiento: <span class='font-weight-normal'>". sprintf('$%01.2f', $r['amount']) ."</span></span>";

                        $payments = $db->filteredOquery('payments p', "cod_payment, cod_invoice, amount, date_format(paid_at, '%d/%m/%Y') paid_at", "p.cod_invoice=".$r['cod_invoice'], 'paid_at asc');
                        if (count($res[0]) <= 0){
                            header("Location: http://localhost/clinic/pages/appointments.php"); 
                        }
                        echo "<h6>Historial de Pagos:</h6>";
                        foreach($payments as $p){
                            echo "<p>&nbsp;&nbsp;&nbsp;Monto: ". sprintf('$%01.2f', $p['amount']) ." - Pago realizado en: {$p['paid_at']}</p>";
                        }
                        if (count($payments) == 0) {
                            echo "<p>*** NO HAY PAGOS A LA FECHA. ***</p>";
                        }
                        echo "<h6>Saldo restante: <span class='font-weight-normal'>".sprintf('$%01.2f', $r['paid'])."</span></h6>";
                    }
                ?>
                
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