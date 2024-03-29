<?php
require_once '../core/public.php';
session_start();
if(!isset($_SESSION['codClinic'])){
    header("Location: http://".host."/clinic/login.php?error=1"); 
}

require_once '../core/Connection.php';
$db = new DatabaseConnection();



?>

<html lang="es"><!-- Copyright 2020 Christoph A. Ramseier.
     All rights reserved. --><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Periodontal Chart online - www.perio-tools.com</title>
<link href="./common/css/_periodontalchart.css" rel="stylesheet">
<!--<script src="./ https://use.fontawesome.com/726fa51d2c.js"></script>-->
<script type="text/javascript">
    // Y-Koordinaten des Margo Gingivae festlegen
        var mg_OK_b = 585;
        var mg_OK_p = 694;
        var mg_UK_l = 1195;
        var mg_UK_b = 1310;
            
    // Checkboxen zuruecksetzen
        var Anfangsbefund = 0;
        var Reevaluation = 0;   

    function validate_mg(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0123456789-]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function validate_st(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0123456789]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }
    
    function validate_beweglichkeit(evt) {
        var theEvent = evt || window.event;
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
        var regex = /[0123]/;
        if (!regex.test(key)) {
            theEvent.returnValue = false;
            if (theEvent.preventDefault) theEvent.preventDefault();
        }
    }

    function toggle_anfangsbefund() {
        if (Anfangsbefund == 0) {
            Anfangsbefund = 1;
            Reevaluation = 0;
            document.getElementById('anfangsbefund_tab').style.display = 'block';
            document.getElementById('reevaluation_tab').style.display = 'none';
        } else {
            Anfangsbefund = 0;
            Reevaluation = 0;
            document.getElementById('anfangsbefund_tab').style.display = 'none';
            document.getElementById('reevaluation_tab').style.display = 'none';
        }
    }    

    function toggle_reevaluation() {
        if (Reevaluation == 0) {
            Reevaluation = 1;
            Anfangsbefund = 0;
            document.getElementById('anfangsbefund_tab').style.display = 'none';
            document.getElementById('reevaluation_tab').style.display = 'block';
        } else {
            Anfangsbefund = 0;
            Reevaluation = 0;
            document.getElementById('anfangsbefund_tab').style.display = 'none';
            document.getElementById('reevaluation_tab').style.display = 'none';
        }
    }    
</script>
<style>
    .info-patient{
        position: absolute;
        z-index: 90;
        width: 98.9vw;
    }

    .font{
        font-family: Arial;
    }
</style>
</head>

<body>
<div id="form_periodontal_chart">
<form autocomplete="off" oninput="calc();">

    <div id="periodontal_chart_teeth">
        <img src="./img/svg/svg_teeth.svg" height="1600" width="1200">
    </div>
    <div id="periodontal_chart_teeth">
        <img <?php echo 'src="http://'.host.'/clinic/dist/img/logo_color_trs.png"' ?> style="height: 10rem; padding: 3rem;">
    </div>
    <div class="info-patient">
        
        <?php 
        $res = $db->filtered_query("clinics", "clinic_name, address, phone_number, wssp_phone", "cod_clinic='{$_SESSION['codClinic']}'");
        if (count($res[0]) <= 0 || !isset($_GET['id'])){
            header("Location: http://".host."/clinic/pages/appointments.php"); 
        }
        echo "<h3 class='font' style='text-align: center; font-size: 2rem;
        padding-top: 5vw;'>
                    {$res[0]['clinic_name']}
                    <br/>
                    <small style='color: #6c757d !important;'>Estamos ubicados en {$res[0]['address']}</small>
                </h3>
                <h6 style='color:#0a07ba !important;text-align: center;' class='font'>Nuestro n&uacute;mero de tel&eacute;fono: &nbsp;<em class='fas fa-phone'></em> {$res[0]['phone_number']}&nbsp; o si lo prefieres b&uacute;scanos en WhatsApp: &nbsp;<em class='fa-brands fa-whatsapp' style='color: #04bd04 !important;'></em> {$res[0]['wssp_phone']}</h6>";
        
        ?>
        <h3 style="
        font-family: Arial;
        font-weight: bold;
        text-align: center;">Periodontograma</h3>
        <div class="font">
            <div style="width: 50vw; float: left;">
            <?php
                $res = $db->filtered_query("patients p", "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", "p.cod_patient='{$_GET['id']}'");
                if (count($res[0]) <= 0){
                    header("Location: http://".host."/clinic/pages/appointments.php"); 
                }
                echo "<span  style='padding-left: 15vw; font-weight: bold;'>Nombre del paciente: </span><span class='Font-weight-normal'>{$res[0]['name']}</span>"
            ?>
            
                <!--<span style="padding-left: 15vw;">Nombre del paciente: </span>-->
            </div>
            <div style="width: 30%; float: right;">
                <?php echo "<span style='font-weight: bold;'>Fecha: ".date('d') . '-' . date('m') . '-' . date('Y')."</span>"; ?>
            </div>
        </div>
    </div>
    <div class="info-patient">

    </div>
        
        <div id="periodontal_chart_grids">
            <img src="./img/svg/en-svg_grids-01.svg" height="1600" width="1200">
        </div>
<!-- 
        <div>
            <input class="input_data" id="input_date" name="date" type="text" value="" tabindex="1">
        </div>
        
        <div>
            <input class="input_data" id="input_patient_last_name" name="patient_last_name" type="text" value="" tabindex="2">
        </div>
        
        <div>
            <input class="input_data" id="input_patient_first_name" name="patient_first_name" type="text" value="" tabindex="3">
        </div>
        
        <div>
            <input class="input_data" id="input_patient_dob" name="patient_dob" type="text" value="" tabindex="4">
        </div>
        
        <div>
            <input class="input_data" id="input_reevaluation" name="input_reevaluation" type="text" value="Reevaluation">
        </div>
        
        <div>
            <input class="input_data" id="input_clinician" name="clinician" type="text" value="" tabindex="5">
        </div> -->
        
        <!-- <div class="checkbox_btn" id="initial_therapy" onclick="toggle_anfangsbefund();">
            <div class="check_tab" id="anfangsbefund_tab" style="display: none;">
                <img src="./img/svg/check.svg" width="25" alt="">
            </div>
        </div> -->
    
        <!-- <div class="checkbox_btn" id="reevaluation" onclick="toggle_reevaluation();">
            <div class="check_tab" id="reevaluation_tab" style="display: none;">
                <img src="./img/svg/check.svg" width="25" alt="">
            </div>
        </div> -->
    
        <div class="select_row_wrapper">
            
            <div class="select_row_btn" id="select_mobility_OK" onclick="select_mobility_OK();">
            </div>

                    <div class="select_row_btn" id="activate_BOP_b_OK" onclick="activate_BOP_b_OK(); calc();">
                    </div>

                    <div class="select_row_btn" id="activate_PI_b_OK" onclick="activate_PI_b_OK(); calc();">
                    </div>

            <div class="select_row_btn" id="select_mg_b_OK" onclick="select_mg_b_OK();">
            </div>

            <div class="select_row_btn" id="select_st_b_OK" onclick="select_st_b_OK();">
            </div>

            <div class="select_row_btn" id="select_mg_p_OK" onclick="select_mg_p_OK();">
            </div>

            <div class="select_row_btn" id="select_st_p_OK" onclick="select_st_p_OK();">
            </div>

                    <div class="select_row_btn" id="activate_PI_p_OK" onclick="activate_PI_p_OK(); calc();">
                    </div>

                    <div class="select_row_btn" id="activate_BOP_p_OK" onclick="activate_BOP_p_OK(); calc();">
                    </div>

                    <div class="select_row_btn" id="activate_BOP_l_UK" onclick="activate_BOP_l_UK(); calc();">
                    </div>

                    <div class="select_row_btn" id="activate_PI_l_UK" onclick="activate_PI_l_UK(); calc();">
                    </div>

            <div class="select_row_btn" id="select_mg_l_UK" onclick="select_mg_l_UK();">
            </div>

            <div class="select_row_btn" id="select_st_l_UK" onclick="select_st_l_UK();">
            </div>

            <div class="select_row_btn" id="select_mg_b_UK" onclick="select_mg_b_UK();">
            </div>

            <div class="select_row_btn" id="select_st_b_UK" onclick="select_st_b_UK();">
            </div>

                    <div class="select_row_btn" id="activate_PI_b_UK" onclick="activate_PI_b_UK(); calc();">
                    </div>

                    <div class="select_row_btn" id="activate_BOP_b_UK" onclick="activate_BOP_b_UK(); calc();">
                    </div>

            <div class="select_row_btn" id="select_mobility_UK" onclick="select_mobility_UK();">
            </div>

        </div>
    
        <div>
            <input class="output_data" id="output_mean_st" name="mean_st" type="text" readonly="" value="0">
        </div>
        
        <div>
            <input class="output_data" id="output_mean_an" name="mean_an" type="text" readonly="" value="0">
        </div>
        
        <div>
            <input class="output_data" id="output_mean_pi" name="mean_pi" type="text" readonly="" value="0">
        </div>
        
        <div>
            <input class="output_data" id="output_mean_bop" name="mean_bop" type="text" readonly="" value="0">
        </div>
                
                <div class="tooth_hover_btn" id="tooth_18_btn" onclick="if (event.shiftKey) {clear_data_18(); calc();} else {toggle_tooth_18(); calc();}">1</div>
        
        <div id="tooth_line_18_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_18_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_18_txt" name="beweglichkeit_18" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="6">
        </div>
        
        <div id="implantat_18_btn" onclick="toggle_implant_18();">
            <div id="implantat_18_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_18_b_image" style="display: none;">
            <img src="./img/implants/1/18b.png" width="60" height="137" alt="">
        </div>
        <div id="implantat_18_p_image" style="display: none;">
            <img src="./img/implants/1/18p.png" width="60" height="119" alt="">
        </div>
        
        <div class="furkation_hover_btn" id="furkation_18_b_btn" onclick="toggle_furcation_18_b();">
        
            <div id="furkation_1_18_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_18_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_18_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_18_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_18_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_18_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="BOP_hover_btn" id="BOP_18_db_btn" onclick="toggle_BOP_18_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_db(); calc();}">
            <div id="BOP_18_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_18_b_btn" onclick="toggle_BOP_18_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_b(); calc();}">
            <div id="BOP_18_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_18_mb_btn" onclick="toggle_BOP_18_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_mb(); calc();}">
            <div id="BOP_18_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_18_db_btn" onclick="toggle_PI_18_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_db(); calc();}">
            <div id="PI_18_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_18_b_btn" onclick="toggle_PI_18_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_b(); calc();}">
            <div id="PI_18_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_18_mb_btn" onclick="toggle_PI_18_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_mb(); calc();}">
            <div id="PI_18_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                    
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_18_db_txt" name="mg_18_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="22">
            <input class="input_mg" id="mg_18_b_txt" name="mg_18_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="23">
            <input class="input_mg" id="mg_18_mb_txt" name="mg_18_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="24">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_18_db_txt" name="st_18_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="70">
            <input class="input_st" id="st_18_b_txt" name="st_18_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="71">
            <input class="input_st" id="st_18_mb_txt" name="st_18_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="72">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_18_dp_txt" name="mg_18_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="118">
            <input class="input_mg" id="mg_18_p_txt" name="mg_18_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="119">
            <input class="input_mg" id="mg_18_mp_txt" name="mg_18_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="120">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_18_dp_txt" name="st_18_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="166">
            <input class="input_st" id="st_18_p_txt" name="st_18_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="167">
            <input class="input_st" id="st_18_mp_txt" name="st_18_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_18();}" tabindex="168">
        </div>

        <div class="BOP_hover_btn" id="BOP_18_dp_btn" onclick="toggle_BOP_18_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_dp(); calc();}">
            <div id="BOP_18_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_18_p_btn" onclick="toggle_BOP_18_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_p(); calc();}">
            <div id="BOP_18_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_18_mp_btn" onclick="toggle_BOP_18_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_18_mp(); calc();}">
            <div id="BOP_18_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_18_dp_btn" onclick="toggle_PI_18_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_dp(); calc();}">
            <div id="PI_18_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_18_p_btn" onclick="toggle_PI_18_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_p(); calc();}">
            <div id="PI_18_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_18_mp_btn" onclick="toggle_PI_18_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_18_mp(); calc();}">
            <div id="PI_18_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_18_dp_btn" onclick="toggle_furcation_18_dp();">
        
            <div id="furkation_1_18_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_18_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_18_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_18_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_18_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_18_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="furkation_hover_btn" id="furkation_18_mp_btn" onclick="toggle_furcation_18_mp();">
        
            <div id="furkation_1_18_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_18_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_18_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_18_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_18_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_18_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_18_txt" name="bemerkung_18" type="text" value="" tabindex="214">
        </div>                <div class="tooth_hover_btn" id="tooth_17_btn" onclick="if (event.shiftKey) {clear_data_17(); calc();} else {toggle_tooth_17(); calc();}">2</div>

        <div id="tooth_line_17_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_17_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
    
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_17_txt" name="beweglichkeit_17" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="7">
        </div>
    
        <div id="implantat_17_btn" onclick="toggle_implant_17();">
            <div id="implantat_17_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_17_b_image" style="display: none;">
            <img src="./img/implants/1/17b.png" width="54" height="137" alt="">
        </div>
        <div id="implantat_17_p_image" style="display: none;">
            <img src="./img/implants/1/17p.png" width="54" height="119" alt="">
        </div>
        
        <div class="furkation_hover_btn" id="furkation_17_b_btn" onclick="toggle_furcation_17_b();">
        
            <div id="furkation_1_17_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_17_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_17_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_17_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_17_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_17_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_17_db_btn" onclick="toggle_BOP_17_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_db(); calc();}">
            <div id="BOP_17_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_17_b_btn" onclick="toggle_BOP_17_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_b(); calc();}">
            <div id="BOP_17_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_17_mb_btn" onclick="toggle_BOP_17_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_mb(); calc();}">
            <div id="BOP_17_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_17_db_btn" onclick="toggle_PI_17_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_db(); calc();}">
            <div id="PI_17_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_17_b_btn" onclick="toggle_PI_17_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_b(); calc();}">
            <div id="PI_17_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_17_mb_btn" onclick="toggle_PI_17_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_mb(); calc();}">
            <div id="PI_17_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                                                
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_17_db_txt" name="mg_17_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="25">
            <input class="input_mg" id="mg_17_b_txt" name="mg_17_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="26">
            <input class="input_mg" id="mg_17_mb_txt" name="mg_17_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="27">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_17_db_txt" name="st_17_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="73">
            <input class="input_st" id="st_17_b_txt" name="st_17_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="74">
            <input class="input_st" id="st_17_mb_txt" name="st_17_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="75">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_17_dp_txt" name="mg_17_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="121">
            <input class="input_mg" id="mg_17_p_txt" name="mg_17_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="122">
            <input class="input_mg" id="mg_17_mp_txt" name="mg_17_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="123">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_17_dp_txt" name="st_17_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="169">
            <input class="input_st" id="st_17_p_txt" name="st_17_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="170">
            <input class="input_st" id="st_17_mp_txt" name="st_17_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_17();}" tabindex="171">
        </div>

        <div class="BOP_hover_btn" id="BOP_17_dp_btn" onclick="toggle_BOP_17_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_dp(); calc();}">
            <div id="BOP_17_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_17_p_btn" onclick="toggle_BOP_17_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_p(); calc();}">
            <div id="BOP_17_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_17_mp_btn" onclick="toggle_BOP_17_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_17_mp(); calc();}">
            <div id="BOP_17_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_17_dp_btn" onclick="toggle_PI_17_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_dp(); calc();}">
            <div id="PI_17_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_17_p_btn" onclick="toggle_PI_17_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_p(); calc();}">
            <div id="PI_17_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_17_mp_btn" onclick="toggle_PI_17_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_17_mp(); calc();}">
            <div id="PI_17_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_17_dp_btn" onclick="toggle_furcation_17_dp();">
        
            <div id="furkation_1_17_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_17_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_17_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_17_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_17_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_17_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_17_mp_btn" onclick="toggle_furcation_17_mp();">
        
            <div id="furkation_1_17_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_17_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_17_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_17_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_17_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_17_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_17_txt" name="bemerkung_17" type="text" value="" tabindex="215">
        </div>                <div class="tooth_hover_btn" id="tooth_16_btn" onclick="if (event.shiftKey) {clear_data_16(); calc();} else {toggle_tooth_16(); calc();}">3</div>

        <div id="tooth_line_16_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_16_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
    
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_16_txt" name="beweglichkeit_16" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="8">
        </div>

        <div id="implantat_16_btn" onclick="toggle_implant_16();">
            <div id="implantat_16_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_16_b_image" style="display: none;">
            <img src="./img/implants/1/16b.png" width="62" height="137" alt="">
        </div>
        <div id="implantat_16_p_image" style="display: none;">
            <img src="./img/implants/1/16p.png" width="62" height="119" alt="">
        </div>
            
        <div class="furkation_hover_btn" id="furkation_16_b_btn" onclick="toggle_furcation_16_b();">
        
            <div id="furkation_1_16_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_16_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_16_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_16_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_16_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_16_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_16_db_btn" onclick="toggle_BOP_16_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_db(); calc();}">
            <div id="BOP_16_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_16_b_btn" onclick="toggle_BOP_16_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_b(); calc();}">
            <div id="BOP_16_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_16_mb_btn" onclick="toggle_BOP_16_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_mb(); calc();}">
            <div id="BOP_16_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_16_db_btn" onclick="toggle_PI_16_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_db(); calc();}">
            <div id="PI_16_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_16_b_btn" onclick="toggle_PI_16_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_b(); calc();}">
            <div id="PI_16_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_16_mb_btn" onclick="toggle_PI_16_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_mb(); calc();}">
            <div id="PI_16_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_16_db_txt" name="mg_16_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="28">
            <input class="input_mg" id="mg_16_b_txt" name="mg_16_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="29">
            <input class="input_mg" id="mg_16_mb_txt" name="mg_16_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="30">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_16_db_txt" name="st_16_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="76">
            <input class="input_st" id="st_16_b_txt" name="st_16_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="77">
            <input class="input_st" id="st_16_mb_txt" name="st_16_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="78">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_16_dp_txt" name="mg_16_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="124">
            <input class="input_mg" id="mg_16_p_txt" name="mg_16_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="125">
            <input class="input_mg" id="mg_16_mp_txt" name="mg_16_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="126">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_16_dp_txt" name="st_16_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="172">
            <input class="input_st" id="st_16_p_txt" name="st_16_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="173">
            <input class="input_st" id="st_16_mp_txt" name="st_16_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_16();}" tabindex="174">
        </div>

        <div class="BOP_hover_btn" id="BOP_16_dp_btn" onclick="toggle_BOP_16_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_dp(); calc();}">
            <div id="BOP_16_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_16_p_btn" onclick="toggle_BOP_16_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_p(); calc();}">
            <div id="BOP_16_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_16_mp_btn" onclick="toggle_BOP_16_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_16_mp(); calc();}">
            <div id="BOP_16_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_16_dp_btn" onclick="toggle_PI_16_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_dp(); calc();}">
            <div id="PI_16_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_16_p_btn" onclick="toggle_PI_16_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_p(); calc();}">
            <div id="PI_16_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_16_mp_btn" onclick="toggle_PI_16_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_16_mp(); calc();}">
            <div id="PI_16_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_16_dp_btn" onclick="toggle_furcation_16_dp();">
        
            <div id="furkation_1_16_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_16_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_16_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_16_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_16_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_16_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_16_mp_btn" onclick="toggle_furcation_16_mp();">
        
            <div id="furkation_1_16_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_16_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_16_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_16_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_16_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_16_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_16_txt" name="bemerkung_16" type="text" value="" tabindex="216">
        </div>                <div class="tooth_hover_btn" id="tooth_15_btn" onclick="if (event.shiftKey) {clear_data_15(); calc();} else {toggle_tooth_15(); calc();}">4</div>

        <div id="tooth_line_15_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_15_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_15_txt" name="beweglichkeit_15" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="9">
        </div>

        <div id="implantat_15_btn" onclick="toggle_implant_15();">
            <div id="implantat_15_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_15_b_image" style="display: none;">
            <img src="./img/implants/1/15b.png" width="41" height="137" alt="">
        </div>
        <div id="implantat_15_p_image" style="display: none;">
            <img src="./img/implants/1/15p.png" width="41" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_15_db_btn" onclick="toggle_BOP_15_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_db(); calc();}">
            <div id="BOP_15_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_15_b_btn" onclick="toggle_BOP_15_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_b(); calc();}">
            <div id="BOP_15_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_15_mb_btn" onclick="toggle_BOP_15_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_mb(); calc();}">
            <div id="BOP_15_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_15_db_btn" onclick="toggle_PI_15_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_db(); calc();}">
            <div id="PI_15_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_15_b_btn" onclick="toggle_PI_15_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_b(); calc();}">
            <div id="PI_15_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_15_mb_btn" onclick="toggle_PI_15_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_mb(); calc();}">
            <div id="PI_15_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                                
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_15_db_txt" name="mg_15_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="31">
            <input class="input_mg" id="mg_15_b_txt" name="mg_15_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="32">
            <input class="input_mg" id="mg_15_mb_txt" name="mg_15_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="33">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_15_db_txt" name="st_15_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="79">
            <input class="input_st" id="st_15_b_txt" name="st_15_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="80">
            <input class="input_st" id="st_15_mb_txt" name="st_15_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="81">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_15_dp_txt" name="mg_15_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="127">
            <input class="input_mg" id="mg_15_p_txt" name="mg_15_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="128">
            <input class="input_mg" id="mg_15_mp_txt" name="mg_15_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="129">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_15_dp_txt" name="st_15_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="175">
            <input class="input_st" id="st_15_p_txt" name="st_15_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="176">
            <input class="input_st" id="st_15_mp_txt" name="st_15_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_15();}" tabindex="177">
        </div>

        <div class="BOP_hover_btn" id="BOP_15_dp_btn" onclick="toggle_BOP_15_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_dp(); calc();}">
            <div id="BOP_15_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_15_p_btn" onclick="toggle_BOP_15_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_p(); calc();}">
            <div id="BOP_15_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_15_mp_btn" onclick="toggle_BOP_15_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_15_mp(); calc();}">
            <div id="BOP_15_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_15_dp_btn" onclick="toggle_PI_15_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_dp(); calc();}">
            <div id="PI_15_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_15_p_btn" onclick="toggle_PI_15_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_p(); calc();}">
            <div id="PI_15_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_15_mp_btn" onclick="toggle_PI_15_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_15_mp(); calc();}">
            <div id="PI_15_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_15_txt" name="bemerkung_15" type="text" value="" tabindex="217">
        </div>                <div class="tooth_hover_btn" id="tooth_14_btn" onclick="if (event.shiftKey) {clear_data_14(); calc();} else {toggle_tooth_14(); calc();}">5</div>

        <div id="tooth_line_14_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_14_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_14_txt" name="beweglichkeit_14" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="10">
        </div>

        <div id="implantat_14_btn" onclick="toggle_implant_14();">
            <div id="implantat_14_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_14_b_image" style="display: none;">
            <img src="./img/implants/1/14b.png" width="43" height="137" alt="">
        </div>
        <div id="implantat_14_p_image" style="display: none;">
            <img src="./img/implants/1/14p.png" width="43" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_14_db_btn" onclick="toggle_BOP_14_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_db(); calc();}">
            <div id="BOP_14_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_14_b_btn" onclick="toggle_BOP_14_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_b(); calc();}">
            <div id="BOP_14_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_14_mb_btn" onclick="toggle_BOP_14_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_mb(); calc();}">
            <div id="BOP_14_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_14_db_btn" onclick="toggle_PI_14_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_db(); calc();}">
            <div id="PI_14_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_14_b_btn" onclick="toggle_PI_14_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_b(); calc();}">
            <div id="PI_14_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_14_mb_btn" onclick="toggle_PI_14_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_mb(); calc();}">
            <div id="PI_14_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_14_db_txt" name="mg_14_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="34">
            <input class="input_mg" id="mg_14_b_txt" name="mg_14_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="35">
            <input class="input_mg" id="mg_14_mb_txt" name="mg_14_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="36">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_14_db_txt" name="st_14_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="82">
            <input class="input_st" id="st_14_b_txt" name="st_14_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="83">
            <input class="input_st" id="st_14_mb_txt" name="st_14_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="84">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_14_dp_txt" name="mg_14_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="130">
            <input class="input_mg" id="mg_14_p_txt" name="mg_14_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="131">
            <input class="input_mg" id="mg_14_mp_txt" name="mg_14_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="132">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_14_dp_txt" name="st_14_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="178">
            <input class="input_st" id="st_14_p_txt" name="st_14_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="179">
            <input class="input_st" id="st_14_mp_txt" name="st_14_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_14();}" tabindex="180">
        </div>

        <div class="BOP_hover_btn" id="BOP_14_dp_btn" onclick="toggle_BOP_14_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_dp(); calc();}">
            <div id="BOP_14_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_14_p_btn" onclick="toggle_BOP_14_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_p(); calc();}">
            <div id="BOP_14_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_14_mp_btn" onclick="toggle_BOP_14_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_14_mp(); calc();}">
            <div id="BOP_14_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_14_dp_btn" onclick="toggle_PI_14_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_dp(); calc();}">
            <div id="PI_14_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_14_p_btn" onclick="toggle_PI_14_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_p(); calc();}">
            <div id="PI_14_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_14_mp_btn" onclick="toggle_PI_14_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_14_mp(); calc();}">
            <div id="PI_14_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_14_dp_btn" onclick="toggle_furcation_14_dp();">
        
            <div id="furkation_1_14_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_14_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_14_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_14_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="14" alt="">
        </div>
        <div id="furkation_2_14_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="14" alt="">
        </div>
        <div id="furkation_3_14_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="14" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_14_mp_btn" onclick="toggle_furcation_14_mp();">
        
            <div id="furkation_1_14_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_14_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_14_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_14_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="14" alt="">
        </div>
        <div id="furkation_2_14_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="14" alt="">
        </div>
        <div id="furkation_3_14_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="14" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_14_txt" name="bemerkung_14" type="text" value="" tabindex="218">
        </div>                <div class="tooth_hover_btn" id="tooth_13_btn" onclick="if (event.shiftKey) {clear_data_13(); calc();} else {toggle_tooth_13(); calc();}">6</div>

        <div id="tooth_line_13_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_13_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_13_txt" name="beweglichkeit_13" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="11">
        </div>

        <div id="implantat_13_btn" onclick="toggle_implant_13();">
            <div id="implantat_13_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_13_b_image" style="display: none;">
            <img src="./img/implants/1/13b.png" width="42" height="137" alt="">
        </div>
        <div id="implantat_13_p_image" style="display: none;">
            <img src="./img/implants/1/13p.png" width="42" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_13_db_btn" onclick="toggle_BOP_13_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_db(); calc();}">
            <div id="BOP_13_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_13_b_btn" onclick="toggle_BOP_13_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_b(); calc();}">
            <div id="BOP_13_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_13_mb_btn" onclick="toggle_BOP_13_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_mb(); calc();}">
            <div id="BOP_13_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_13_db_btn" onclick="toggle_PI_13_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_db(); calc();}">
            <div id="PI_13_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_13_b_btn" onclick="toggle_PI_13_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_b(); calc();}">
            <div id="PI_13_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_13_mb_btn" onclick="toggle_PI_13_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_mb(); calc();}">
            <div id="PI_13_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_13_db_txt" name="mg_13_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="37">
            <input class="input_mg" id="mg_13_b_txt" name="mg_13_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="38">
            <input class="input_mg" id="mg_13_mb_txt" name="mg_13_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="39">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_13_db_txt" name="st_13_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="85">
            <input class="input_st" id="st_13_b_txt" name="st_13_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="86">
            <input class="input_st" id="st_13_mb_txt" name="st_13_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="87">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_13_dp_txt" name="mg_13_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="133">
            <input class="input_mg" id="mg_13_p_txt" name="mg_13_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="134">
            <input class="input_mg" id="mg_13_mp_txt" name="mg_13_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="135">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_13_dp_txt" name="st_13_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="181">
            <input class="input_st" id="st_13_p_txt" name="st_13_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="182">
            <input class="input_st" id="st_13_mp_txt" name="st_13_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_13();}" tabindex="183">
        </div>

        <div class="BOP_hover_btn" id="BOP_13_dp_btn" onclick="toggle_BOP_13_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_dp(); calc();}">
            <div id="BOP_13_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_13_p_btn" onclick="toggle_BOP_13_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_p(); calc();}">
            <div id="BOP_13_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_13_mp_btn" onclick="toggle_BOP_13_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_13_mp(); calc();}">
            <div id="BOP_13_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_13_dp_btn" onclick="toggle_PI_13_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_dp(); calc();}">
            <div id="PI_13_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_13_p_btn" onclick="toggle_PI_13_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_p(); calc();}">
            <div id="PI_13_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_13_mp_btn" onclick="toggle_PI_13_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_13_mp(); calc();}">
            <div id="PI_13_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_13_txt" name="bemerkung_13" type="text" value="" tabindex="219">
        </div>                <div class="tooth_hover_btn" id="tooth_12_btn" onclick="if (event.shiftKey) {clear_data_12(); calc();} else {toggle_tooth_12(); calc();}">7</div>

        <div id="tooth_line_12_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_12_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_12_txt" name="beweglichkeit_12" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="12">
        </div>

        <div id="implantat_12_btn" onclick="toggle_implant_12();">
            <div id="implantat_12_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_12_b_image" style="display: none;">
            <img src="./img/implants/1/12b.png" width="37" height="137" alt="">
        </div>
        <div id="implantat_12_p_image" style="display: none;">
            <img src="./img/implants/1/12p.png" width="37" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_12_db_btn" onclick="toggle_BOP_12_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_db(); calc();}">
            <div id="BOP_12_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_12_b_btn" onclick="toggle_BOP_12_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_b(); calc();}">
            <div id="BOP_12_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_12_mb_btn" onclick="toggle_BOP_12_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_mb(); calc();}">
            <div id="BOP_12_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_12_db_btn" onclick="toggle_PI_12_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_db(); calc();}">
            <div id="PI_12_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_12_b_btn" onclick="toggle_PI_12_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_b(); calc();}">
            <div id="PI_12_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_12_mb_btn" onclick="toggle_PI_12_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_mb(); calc();}">
            <div id="PI_12_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_12_db_txt" name="mg_12_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="40">
            <input class="input_mg" id="mg_12_b_txt" name="mg_12_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="41">
            <input class="input_mg" id="mg_12_mb_txt" name="mg_12_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="42">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_12_db_txt" name="st_12_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="88">
            <input class="input_st" id="st_12_b_txt" name="st_12_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="89">
            <input class="input_st" id="st_12_mb_txt" name="st_12_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="90">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_12_dp_txt" name="mg_12_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="136">
            <input class="input_mg" id="mg_12_p_txt" name="mg_12_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="137">
            <input class="input_mg" id="mg_12_mp_txt" name="mg_12_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="138">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_12_dp_txt" name="st_12_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="184">
            <input class="input_st" id="st_12_p_txt" name="st_12_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="185">
            <input class="input_st" id="st_12_mp_txt" name="st_12_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_12();}" tabindex="186">
        </div>

        <div class="BOP_hover_btn" id="BOP_12_dp_btn" onclick="toggle_BOP_12_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_dp(); calc();}">
            <div id="BOP_12_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_12_p_btn" onclick="toggle_BOP_12_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_p(); calc();}">
            <div id="BOP_12_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_12_mp_btn" onclick="toggle_BOP_12_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_12_mp(); calc();}">
            <div id="BOP_12_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_12_dp_btn" onclick="toggle_PI_12_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_dp(); calc();}">
            <div id="PI_12_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_12_p_btn" onclick="toggle_PI_12_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_p(); calc();}">
            <div id="PI_12_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_12_mp_btn" onclick="toggle_PI_12_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_12_mp(); calc();}">
            <div id="PI_12_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_12_txt" name="bemerkung_12" type="text" value="" tabindex="220">
        </div>                <div class="tooth_hover_btn" id="tooth_11_btn" onclick="if (event.shiftKey) {clear_data_11(); calc();} else {toggle_tooth_11(); calc();}">8</div>

        <div id="tooth_line_11_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_11_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_11_txt" name="beweglichkeit_11" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="13">
        </div>

        <div id="implantat_11_btn" onclick="toggle_implant_11();">
            <div id="implantat_11_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_11_b_image" style="display: none;">
            <img src="./img/implants/1/11b.png" width="62" height="137" alt="">
        </div>
        <div id="implantat_11_p_image" style="display: none;">
            <img src="./img/implants/1/11p.png" width="62" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_11_db_btn" onclick="toggle_BOP_11_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_db(); calc();}">
            <div id="BOP_11_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_11_b_btn" onclick="toggle_BOP_11_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_b(); calc();}">
            <div id="BOP_11_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_11_mb_btn" onclick="toggle_BOP_11_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_mb(); calc();}">
            <div id="BOP_11_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_11_db_btn" onclick="toggle_PI_11_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_db(); calc();}">
            <div id="PI_11_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_11_b_btn" onclick="toggle_PI_11_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_b(); calc();}">
            <div id="PI_11_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_11_mb_btn" onclick="toggle_PI_11_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_mb(); calc();}">
            <div id="PI_11_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_11_db_txt" name="mg_11_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="43">
            <input class="input_mg" id="mg_11_b_txt" name="mg_11_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="44">
            <input class="input_mg" id="mg_11_mb_txt" name="mg_11_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="45">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_11_db_txt" name="st_11_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="91">
            <input class="input_st" id="st_11_b_txt" name="st_11_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="92">
            <input class="input_st" id="st_11_mb_txt" name="st_11_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="93">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_11_dp_txt" name="mg_11_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="139">
            <input class="input_mg" id="mg_11_p_txt" name="mg_11_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="140">
            <input class="input_mg" id="mg_11_mp_txt" name="mg_11_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="141">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_11_dp_txt" name="st_11_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="187">
            <input class="input_st" id="st_11_p_txt" name="st_11_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="188">
            <input class="input_st" id="st_11_mp_txt" name="st_11_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_11();}" tabindex="189">
        </div>

        <div class="BOP_hover_btn" id="BOP_11_dp_btn" onclick="toggle_BOP_11_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_dp(); calc();}">
            <div id="BOP_11_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_11_p_btn" onclick="toggle_BOP_11_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_p(); calc();}">
            <div id="BOP_11_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_11_mp_btn" onclick="toggle_BOP_11_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_11_mp(); calc();}">
            <div id="BOP_11_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_11_dp_btn" onclick="toggle_PI_11_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_dp(); calc();}">
            <div id="PI_11_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_11_p_btn" onclick="toggle_PI_11_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_p(); calc();}">
            <div id="PI_11_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_11_mp_btn" onclick="toggle_PI_11_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_11_mp(); calc();}">
            <div id="PI_11_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_11_txt" name="bemerkung_11" type="text" value="" tabindex="221">
        </div>
                <div class="tooth_hover_btn" id="tooth_21_btn" onclick="if (event.shiftKey) {clear_data_21(); calc();} else {toggle_tooth_21(); calc();}">9</div>

        <div id="tooth_line_21_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_21_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>

        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_21_txt" name="beweglichkeit_21" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="14">
        </div>
        
        <div id="implantat_21_btn" onclick="toggle_implant_21();">
            <div id="implantat_21_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_21_b_image" style="display: none;">
            <img src="./img/implants/2/21b.png" width="61" height="137" alt="">
        </div>
        <div id="implantat_21_p_image" style="display: none;">
            <img src="./img/implants/2/21p.png" width="61" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_21_db_btn" onclick="toggle_BOP_21_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_db(); calc();}">
            <div id="BOP_21_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_21_b_btn" onclick="toggle_BOP_21_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_b(); calc();}">
            <div id="BOP_21_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_21_mb_btn" onclick="toggle_BOP_21_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_mb(); calc();}">
            <div id="BOP_21_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_21_db_btn" onclick="toggle_PI_21_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_db(); calc();}">
            <div id="PI_21_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_21_b_btn" onclick="toggle_PI_21_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_b(); calc();}">
            <div id="PI_21_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_21_mb_btn" onclick="toggle_PI_21_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_mb(); calc();}">
            <div id="PI_21_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_21_db_txt" name="mg_21_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="48">
            <input class="input_mg" id="mg_21_b_txt" name="mg_21_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="47">
            <input class="input_mg" id="mg_21_mb_txt" name="mg_21_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="46">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_21_db_txt" name="st_21_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="96">
            <input class="input_st" id="st_21_b_txt" name="st_21_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="95">
            <input class="input_st" id="st_21_mb_txt" name="st_21_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="94">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_21_dp_txt" name="mg_21_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="144">
            <input class="input_mg" id="mg_21_p_txt" name="mg_21_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="143">
            <input class="input_mg" id="mg_21_mp_txt" name="mg_21_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="142">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_21_dp_txt" name="st_21_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="192">
            <input class="input_st" id="st_21_p_txt" name="st_21_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="191">
            <input class="input_st" id="st_21_mp_txt" name="st_21_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_21();}" tabindex="190">
        </div>

        <div class="BOP_hover_btn" id="BOP_21_dp_btn" onclick="toggle_BOP_21_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_dp(); calc();}">
            <div id="BOP_21_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_21_p_btn" onclick="toggle_BOP_21_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_p(); calc();}">
            <div id="BOP_21_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_21_mp_btn" onclick="toggle_BOP_21_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_21_mp(); calc();}">
            <div id="BOP_21_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_21_dp_btn" onclick="toggle_PI_21_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_dp(); calc();}">
            <div id="PI_21_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_21_p_btn" onclick="toggle_PI_21_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_p(); calc();}">
            <div id="PI_21_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_21_mp_btn" onclick="toggle_PI_21_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_21_mp(); calc();}">
            <div id="PI_21_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_21_txt" name="bemerkung_21" type="text" value="" tabindex="222">
        </div>                <div class="tooth_hover_btn" id="tooth_22_btn" onclick="if (event.shiftKey) {clear_data_22(); calc();} else {toggle_tooth_22(); calc();}">10</div>

        <div id="tooth_line_22_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_22_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_22_txt" name="beweglichkeit_22" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="15">
        </div>

        <div id="implantat_22_btn" onclick="toggle_implant_22();">
            <div id="implantat_22_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_22_b_image" style="display: none;">
            <img src="./img/implants/2/22b.png" width="37" height="137" alt="">
        </div>
        <div id="implantat_22_p_image" style="display: none;">
            <img src="./img/implants/2/22p.png" width="37" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_22_db_btn" onclick="toggle_BOP_22_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_db(); calc();}">
            <div id="BOP_22_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_22_b_btn" onclick="toggle_BOP_22_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_b(); calc();}">
            <div id="BOP_22_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_22_mb_btn" onclick="toggle_BOP_22_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_mb(); calc();}">
            <div id="BOP_22_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_22_db_btn" onclick="toggle_PI_22_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_db(); calc();}">
            <div id="PI_22_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_22_b_btn" onclick="toggle_PI_22_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_b(); calc();}">
            <div id="PI_22_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_22_mb_btn" onclick="toggle_PI_22_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_mb(); calc();}">
            <div id="PI_22_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_22_db_txt" name="mg_22_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="51">
            <input class="input_mg" id="mg_22_b_txt" name="mg_22_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="50">
            <input class="input_mg" id="mg_22_mb_txt" name="mg_22_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="49">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_22_db_txt" name="st_22_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="99">
            <input class="input_st" id="st_22_b_txt" name="st_22_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="98">
            <input class="input_st" id="st_22_mb_txt" name="st_22_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="97">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_22_dp_txt" name="mg_22_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="147">
            <input class="input_mg" id="mg_22_p_txt" name="mg_22_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="146">
            <input class="input_mg" id="mg_22_mp_txt" name="mg_22_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="145">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_22_dp_txt" name="st_22_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="195">
            <input class="input_st" id="st_22_p_txt" name="st_22_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="194">
            <input class="input_st" id="st_22_mp_txt" name="st_22_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_22();}" tabindex="193">
        </div>

        <div class="BOP_hover_btn" id="BOP_22_dp_btn" onclick="toggle_BOP_22_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_dp(); calc();}">
            <div id="BOP_22_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_22_p_btn" onclick="toggle_BOP_22_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_p(); calc();}">
            <div id="BOP_22_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_22_mp_btn" onclick="toggle_BOP_22_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_22_mp(); calc();}">
            <div id="BOP_22_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_22_dp_btn" onclick="toggle_PI_22_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_dp(); calc();}">
            <div id="PI_22_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_22_p_btn" onclick="toggle_PI_22_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_p(); calc();}">
            <div id="PI_22_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_22_mp_btn" onclick="toggle_PI_22_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_22_mp(); calc();}">
            <div id="PI_22_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_22_txt" name="bemerkung_22" type="text" value="" tabindex="223">
        </div>                <div class="tooth_hover_btn" id="tooth_23_btn" onclick="if (event.shiftKey) {clear_data_23(); calc();} else {toggle_tooth_23(); calc();}">11</div>

        <div id="tooth_line_23_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_23_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>

        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_23_txt" name="beweglichkeit_23" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="16">
        </div>

        <div id="implantat_23_btn" onclick="toggle_implant_23();">
            <div id="implantat_23_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_23_b_image" style="display: none;">
            <img src="./img/implants/2/23b.png" width="42" height="137" alt="">
        </div>
        <div id="implantat_23_p_image" style="display: none;">
            <img src="./img/implants/2/23p.png" width="42" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_23_db_btn" onclick="toggle_BOP_23_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_db(); calc();}">
            <div id="BOP_23_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_23_b_btn" onclick="toggle_BOP_23_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_b(); calc();}">
            <div id="BOP_23_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_23_mb_btn" onclick="toggle_BOP_23_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_mb(); calc();}">
            <div id="BOP_23_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_23_db_btn" onclick="toggle_PI_23_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_db(); calc();}">
            <div id="PI_23_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_23_b_btn" onclick="toggle_PI_23_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_b(); calc();}">
            <div id="PI_23_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_23_mb_btn" onclick="toggle_PI_23_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_mb(); calc();}">
            <div id="PI_23_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_23_db_txt" name="mg_23_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="54">
            <input class="input_mg" id="mg_23_b_txt" name="mg_23_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="53">
            <input class="input_mg" id="mg_23_mb_txt" name="mg_23_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="52">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_23_db_txt" name="st_23_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="102">
            <input class="input_st" id="st_23_b_txt" name="st_23_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="101">
            <input class="input_st" id="st_23_mb_txt" name="st_23_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="100">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_23_dp_txt" name="mg_23_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="150">
            <input class="input_mg" id="mg_23_p_txt" name="mg_23_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="149">
            <input class="input_mg" id="mg_23_mp_txt" name="mg_23_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="148">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_23_dp_txt" name="st_23_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="198">
            <input class="input_st" id="st_23_p_txt" name="st_23_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="197">
            <input class="input_st" id="st_23_mp_txt" name="st_23_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_23();}" tabindex="196">
        </div>

        <div class="BOP_hover_btn" id="BOP_23_dp_btn" onclick="toggle_BOP_23_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_dp(); calc();}">
            <div id="BOP_23_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_23_p_btn" onclick="toggle_BOP_23_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_p(); calc();}">
            <div id="BOP_23_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_23_mp_btn" onclick="toggle_BOP_23_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_23_mp(); calc();}">
            <div id="BOP_23_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_23_dp_btn" onclick="toggle_PI_23_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_dp(); calc();}">
            <div id="PI_23_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_23_p_btn" onclick="toggle_PI_23_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_p(); calc();}">
            <div id="PI_23_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_23_mp_btn" onclick="toggle_PI_23_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_23_mp(); calc();}">
            <div id="PI_23_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_23_txt" name="bemerkung_23" type="text" value="" tabindex="224">
        </div>                <div class="tooth_hover_btn" id="tooth_24_btn" onclick="if (event.shiftKey) {clear_data_24(); calc();} else {toggle_tooth_24(); calc();}">12</div>

        <div id="tooth_line_24_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_24_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>

        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_24_txt" name="beweglichkeit_24" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="17">
        </div>

        <div id="implantat_24_btn" onclick="toggle_implant_24();">
            <div id="implantat_24_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_24_b_image" style="display: none;">
            <img src="./img/implants/2/24b.png" width="43" height="137" alt="">
        </div>
        <div id="implantat_24_p_image" style="display: none;">
            <img src="./img/implants/2/24p.png" width="43" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_24_db_btn" onclick="toggle_BOP_24_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_db(); calc();}">
            <div id="BOP_24_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_24_b_btn" onclick="toggle_BOP_24_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_b(); calc();}">
            <div id="BOP_24_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_24_mb_btn" onclick="toggle_BOP_24_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_mb(); calc();}">
            <div id="BOP_24_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_24_db_btn" onclick="toggle_PI_24_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_db(); calc();}">
            <div id="PI_24_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_24_b_btn" onclick="toggle_PI_24_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_b(); calc();}">
            <div id="PI_24_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_24_mb_btn" onclick="toggle_PI_24_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_mb(); calc();}">
            <div id="PI_24_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                    
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_24_db_txt" name="mg_24_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="57">
            <input class="input_mg" id="mg_24_b_txt" name="mg_24_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="56">
            <input class="input_mg" id="mg_24_mb_txt" name="mg_24_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="55">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_24_db_txt" name="st_24_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="105">
            <input class="input_st" id="st_24_b_txt" name="st_24_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="104">
            <input class="input_st" id="st_24_mb_txt" name="st_24_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="103">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_24_dp_txt" name="mg_24_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="153">
            <input class="input_mg" id="mg_24_p_txt" name="mg_24_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="152">
            <input class="input_mg" id="mg_24_mp_txt" name="mg_24_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="151">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_24_dp_txt" name="st_24_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="201">
            <input class="input_st" id="st_24_p_txt" name="st_24_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="200">
            <input class="input_st" id="st_24_mp_txt" name="st_24_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_24();}" tabindex="199">
        </div>

        <div class="BOP_hover_btn" id="BOP_24_dp_btn" onclick="toggle_BOP_24_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_dp(); calc();}">
            <div id="BOP_24_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_24_p_btn" onclick="toggle_BOP_24_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_p(); calc();}">
            <div id="BOP_24_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_24_mp_btn" onclick="toggle_BOP_24_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_24_mp(); calc();}">
            <div id="BOP_24_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_24_dp_btn" onclick="toggle_PI_24_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_dp(); calc();}">
            <div id="PI_24_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_24_p_btn" onclick="toggle_PI_24_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_p(); calc();}">
            <div id="PI_24_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_24_mp_btn" onclick="toggle_PI_24_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_24_mp(); calc();}">
            <div id="PI_24_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_24_dp_btn" onclick="toggle_furcation_24_dp();">
        
            <div id="furkation_1_24_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_24_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_24_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_24_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="14" alt="">
        </div>
        <div id="furkation_2_24_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="14" alt="">
        </div>
        <div id="furkation_3_24_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="14" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_24_mp_btn" onclick="toggle_furcation_24_mp();">
        
            <div id="furkation_1_24_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_24_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_24_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_24_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="14" alt="">
        </div>
        <div id="furkation_2_24_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="14" alt="">
        </div>
        <div id="furkation_3_24_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="14" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_24_txt" name="bemerkung_24" type="text" value="" tabindex="225">
        </div>                <div class="tooth_hover_btn" id="tooth_25_btn" onclick="if (event.shiftKey) {clear_data_25(); calc();} else {toggle_tooth_25(); calc();}">13</div>

        <div id="tooth_line_25_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_25_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_25_txt" name="beweglichkeit_25" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="18">
        </div>

        <div id="implantat_25_btn" onclick="toggle_implant_25();">
            <div id="implantat_25_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_25_b_image" style="display: none;">
            <img src="./img/implants/2/25b.png" width="40" height="137" alt="">
        </div>
        <div id="implantat_25_p_image" style="display: none;">
            <img src="./img/implants/2/25p.png" width="40" height="119" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_25_db_btn" onclick="toggle_BOP_25_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_db(); calc();}">
            <div id="BOP_25_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_25_b_btn" onclick="toggle_BOP_25_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_b(); calc();}">
            <div id="BOP_25_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_25_mb_btn" onclick="toggle_BOP_25_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_mb(); calc();}">
            <div id="BOP_25_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_25_db_btn" onclick="toggle_PI_25_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_db(); calc();}">
            <div id="PI_25_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_25_b_btn" onclick="toggle_PI_25_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_b(); calc();}">
            <div id="PI_25_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_25_mb_btn" onclick="toggle_PI_25_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_mb(); calc();}">
            <div id="PI_25_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                        
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_25_db_txt" name="mg_25_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="60">
            <input class="input_mg" id="mg_25_b_txt" name="mg_25_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="59">
            <input class="input_mg" id="mg_25_mb_txt" name="mg_25_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="58">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_25_db_txt" name="st_25_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="108">
            <input class="input_st" id="st_25_b_txt" name="st_25_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="107">
            <input class="input_st" id="st_25_mb_txt" name="st_25_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="106">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_25_dp_txt" name="mg_25_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="156">
            <input class="input_mg" id="mg_25_p_txt" name="mg_25_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="155">
            <input class="input_mg" id="mg_25_mp_txt" name="mg_25_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="154">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_25_dp_txt" name="st_25_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="204">
            <input class="input_st" id="st_25_p_txt" name="st_25_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="203">
            <input class="input_st" id="st_25_mp_txt" name="st_25_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_25();}" tabindex="202">
        </div>

        <div class="BOP_hover_btn" id="BOP_25_dp_btn" onclick="toggle_BOP_25_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_dp(); calc();}">
            <div id="BOP_25_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_25_p_btn" onclick="toggle_BOP_25_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_p(); calc();}">
            <div id="BOP_25_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_25_mp_btn" onclick="toggle_BOP_25_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_25_mp(); calc();}">
            <div id="BOP_25_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_25_dp_btn" onclick="toggle_PI_25_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_dp(); calc();}">
            <div id="PI_25_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_25_p_btn" onclick="toggle_PI_25_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_p(); calc();}">
            <div id="PI_25_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_25_mp_btn" onclick="toggle_PI_25_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_25_mp(); calc();}">
            <div id="PI_25_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_25_txt" name="bemerkung_25" type="text" value="" tabindex="226">
        </div>                <div class="tooth_hover_btn" id="tooth_26_btn" onclick="if (event.shiftKey) {clear_data_26(); calc();} else {toggle_tooth_26(); calc();}">14</div>

        <div id="tooth_line_26_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_26_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_26_txt" name="beweglichkeit_26" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="19">
        </div>

        <div id="implantat_26_btn" onclick="toggle_implant_26();">
            <div id="implantat_26_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_26_b_image" style="display: none;">
            <img src="./img/implants/2/26b.png" width="62" height="137" alt="">
        </div>
        <div id="implantat_26_p_image" style="display: none;">
            <img src="./img/implants/2/26p.png" width="62" height="119" alt="">
        </div>
    
        <div class="furkation_hover_btn" id="furkation_26_b_btn" onclick="toggle_furcation_26_b();">
        
            <div id="furkation_1_26_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_26_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_26_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_26_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_26_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_26_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_26_db_btn" onclick="toggle_BOP_26_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_db(); calc();}">
            <div id="BOP_26_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_26_b_btn" onclick="toggle_BOP_26_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_b(); calc();}">
            <div id="BOP_26_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_26_mb_btn" onclick="toggle_BOP_26_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_mb(); calc();}">
            <div id="BOP_26_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_26_db_btn" onclick="toggle_PI_26_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_db(); calc();}">
            <div id="PI_26_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_26_b_btn" onclick="toggle_PI_26_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_b(); calc();}">
            <div id="PI_26_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_26_mb_btn" onclick="toggle_PI_26_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_mb(); calc();}">
            <div id="PI_26_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                                
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_26_db_txt" name="mg_26_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="63">
            <input class="input_mg" id="mg_26_b_txt" name="mg_26_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="62">
            <input class="input_mg" id="mg_26_mb_txt" name="mg_26_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="61">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_26_db_txt" name="st_26_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="111">
            <input class="input_st" id="st_26_b_txt" name="st_26_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="110">
            <input class="input_st" id="st_26_mb_txt" name="st_26_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="109">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_26_dp_txt" name="mg_26_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="159">
            <input class="input_mg" id="mg_26_p_txt" name="mg_26_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="158">
            <input class="input_mg" id="mg_26_mp_txt" name="mg_26_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="157">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_26_dp_txt" name="st_26_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="207">
            <input class="input_st" id="st_26_p_txt" name="st_26_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="206">
            <input class="input_st" id="st_26_mp_txt" name="st_26_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_26();}" tabindex="205">
        </div>

        <div class="BOP_hover_btn" id="BOP_26_dp_btn" onclick="toggle_BOP_26_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_dp(); calc();}">
            <div id="BOP_26_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_26_p_btn" onclick="toggle_BOP_26_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_p(); calc();}">
            <div id="BOP_26_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_26_mp_btn" onclick="toggle_BOP_26_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_26_mp(); calc();}">
            <div id="BOP_26_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_26_dp_btn" onclick="toggle_PI_26_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_dp(); calc();}">
            <div id="PI_26_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_26_p_btn" onclick="toggle_PI_26_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_p(); calc();}">
            <div id="PI_26_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_26_mp_btn" onclick="toggle_PI_26_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_26_mp(); calc();}">
            <div id="PI_26_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_26_dp_btn" onclick="toggle_furcation_26_dp();">
        
            <div id="furkation_1_26_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_26_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_26_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_26_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_26_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_26_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_26_mp_btn" onclick="toggle_furcation_26_mp();">
        
            <div id="furkation_1_26_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_26_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_26_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_26_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="16" alt="">
        </div>
        <div id="furkation_2_26_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="16" alt="">
        </div>
        <div id="furkation_3_26_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="16" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_26_txt" name="bemerkung_26" type="text" value="" tabindex="227">
        </div>                <div class="tooth_hover_btn" id="tooth_27_btn" onclick="if (event.shiftKey) {clear_data_27(); calc();} else {toggle_tooth_27(); calc();}">15</div>

        <div id="tooth_line_27_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_27_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_27_txt" name="beweglichkeit_27" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="20">
        </div>

        <div id="implantat_27_btn" onclick="toggle_implant_27();">
            <div id="implantat_27_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_27_b_image" style="display: none;">
            <img src="./img/implants/2/27b.png" width="55" height="137" alt="">
        </div>
        <div id="implantat_27_p_image" style="display: none;">
            <img src="./img/implants/2/27p.png" width="55" height="119" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_27_b_btn" onclick="toggle_furcation_27_b();">
        
            <div id="furkation_1_27_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_27_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_27_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_27_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_27_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_27_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_27_db_btn" onclick="toggle_BOP_27_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_db(); calc();}">
            <div id="BOP_27_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_27_b_btn" onclick="toggle_BOP_27_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_b(); calc();}">
            <div id="BOP_27_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_27_mb_btn" onclick="toggle_BOP_27_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_mb(); calc();}">
            <div id="BOP_27_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_27_db_btn" onclick="toggle_PI_27_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_db(); calc();}">
            <div id="PI_27_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_27_b_btn" onclick="toggle_PI_27_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_b(); calc();}">
            <div id="PI_27_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_27_mb_btn" onclick="toggle_PI_27_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_mb(); calc();}">
            <div id="PI_27_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
            
        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_27_db_txt" name="mg_27_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="66">
            <input class="input_mg" id="mg_27_b_txt" name="mg_27_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="65">
            <input class="input_mg" id="mg_27_mb_txt" name="mg_27_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="64">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_27_db_txt" name="st_27_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="114">
            <input class="input_st" id="st_27_b_txt" name="st_27_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="113">
            <input class="input_st" id="st_27_mb_txt" name="st_27_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="112">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_27_dp_txt" name="mg_27_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="162">
            <input class="input_mg" id="mg_27_p_txt" name="mg_27_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="161">
            <input class="input_mg" id="mg_27_mp_txt" name="mg_27_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="160">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_27_dp_txt" name="st_27_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="210">
            <input class="input_st" id="st_27_p_txt" name="st_27_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="209">
            <input class="input_st" id="st_27_mp_txt" name="st_27_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_27();}" tabindex="208">
        </div>

        <div class="BOP_hover_btn" id="BOP_27_dp_btn" onclick="toggle_BOP_27_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_dp(); calc();}">
            <div id="BOP_27_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_27_p_btn" onclick="toggle_BOP_27_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_p(); calc();}">
            <div id="BOP_27_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_27_mp_btn" onclick="toggle_BOP_27_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_27_mp(); calc();}">
            <div id="BOP_27_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_27_dp_btn" onclick="toggle_PI_27_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_dp(); calc();}">
            <div id="PI_27_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_27_p_btn" onclick="toggle_PI_27_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_p(); calc();}">
            <div id="PI_27_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_27_mp_btn" onclick="toggle_PI_27_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_27_mp(); calc();}">
            <div id="PI_27_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_27_dp_btn" onclick="toggle_furcation_27_dp();">
        
            <div id="furkation_1_27_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_27_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_27_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_27_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_27_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_27_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_27_mp_btn" onclick="toggle_furcation_27_mp();">
        
            <div id="furkation_1_27_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_27_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_27_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_27_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_27_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_27_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_27_txt" name="bemerkung_27" type="text" value="" tabindex="228">
        </div>                <div class="tooth_hover_btn" id="tooth_28_btn" onclick="if (event.shiftKey) {clear_data_28(); calc();} else {toggle_tooth_28(); calc();}">16</div>
        
        <div id="tooth_line_28_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_28_p" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="ok_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_28_txt" name="beweglichkeit_28" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="21">
        </div>

        <div id="implantat_28_btn" onclick="toggle_implant_28();">
            <div id="implantat_28_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_28_b_image" style="display: none;">
            <img src="./img/implants/2/28b.png" width="60" height="137" alt="">
        </div>
        <div id="implantat_28_p_image" style="display: none;">
            <img src="./img/implants/2/28p.png" width="60" height="119" alt="">
        </div>
    
        <div class="furkation_hover_btn" id="furkation_28_b_btn" onclick="toggle_furcation_28_b();">
        
            <div id="furkation_1_28_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_28_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_28_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_28_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_28_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_28_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_28_db_btn" onclick="toggle_BOP_28_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_db(); calc();}">
            <div id="BOP_28_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_28_b_btn" onclick="toggle_BOP_28_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_b(); calc();}">
            <div id="BOP_28_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_28_mb_btn" onclick="toggle_BOP_28_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_mb(); calc();}">
            <div id="BOP_28_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_28_db_btn" onclick="toggle_PI_28_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_db(); calc();}">
            <div id="PI_28_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_28_b_btn" onclick="toggle_PI_28_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_b(); calc();}">
            <div id="PI_28_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_28_mb_btn" onclick="toggle_PI_28_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_mb(); calc();}">
            <div id="PI_28_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="ok_bukk_mg_input">
            <input class="input_mg" id="mg_28_db_txt" name="mg_28_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="69">
            <input class="input_mg" id="mg_28_b_txt" name="mg_28_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="68">
            <input class="input_mg" id="mg_28_mb_txt" name="mg_28_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="67">
        </div>
        <div class="ok_bukk_st_input">
            <input class="input_st" id="st_28_db_txt" name="st_28_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="117">
            <input class="input_st" id="st_28_b_txt" name="st_28_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="116">
            <input class="input_st" id="st_28_mb_txt" name="st_28_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="115">
        </div>

        <div class="ok_pal_mg_input">
            <input class="input_mg" id="mg_28_dp_txt" name="mg_28_dp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="165">
            <input class="input_mg" id="mg_28_p_txt" name="mg_28_p" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="164">
            <input class="input_mg" id="mg_28_mp_txt" name="mg_28_mp" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="163">
        </div>
        <div class="ok_pal_st_input">
            <input class="input_st" id="st_28_dp_txt" name="st_28_dp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="213">
            <input class="input_st" id="st_28_p_txt" name="st_28_p" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="212">
            <input class="input_st" id="st_28_mp_txt" name="st_28_mp" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_28();}" tabindex="211">
        </div>

        <div class="BOP_hover_btn" id="BOP_28_dp_btn" onclick="toggle_BOP_28_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_dp(); calc();}">
            <div id="BOP_28_dp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_28_p_btn" onclick="toggle_BOP_28_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_p(); calc();}">
            <div id="BOP_28_p_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_28_mp_btn" onclick="toggle_BOP_28_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_28_mp(); calc();}">
            <div id="BOP_28_mp_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_28_dp_btn" onclick="toggle_PI_28_dp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_dp(); calc();}">
            <div id="PI_28_dp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_28_p_btn" onclick="toggle_PI_28_p(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_p(); calc();}">
            <div id="PI_28_p_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_28_mp_btn" onclick="toggle_PI_28_mp(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_28_mp(); calc();}">
            <div id="PI_28_mp_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_28_dp_btn" onclick="toggle_furcation_28_dp();">
        
            <div id="furkation_1_28_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_28_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_28_dp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_28_dp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_28_dp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_28_dp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="furkation_hover_btn" id="furkation_28_mp_btn" onclick="toggle_furcation_28_mp();">
        
            <div id="furkation_1_28_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_28_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_28_mp_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_28_mp" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_28_mp" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_28_mp" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="ok_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_28_txt" name="bemerkung_28" type="text" value="" tabindex="229">
        </div>
                <div class="tooth_hover_btn" id="tooth_38_btn" onclick="if (event.shiftKey) {clear_data_38(); calc();} else {toggle_tooth_38(); calc();}">17</div>
        
        <div id="tooth_line_38_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_38_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_38_txt" name="beweglichkeit_38" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="453">
        </div>

        <div id="implantat_38_btn" onclick="toggle_implant_38();">
            <div id="implantat_38_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_38_b_image" style="display: none;">
            <img src="./img/implants/3/38b.png" width="80" height="131" alt="">
        </div>
        <div id="implantat_38_l_image" style="display: none;">
            <img src="./img/implants/3/38l.png" width="84" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_38_b_btn" onclick="toggle_furcation_38_b();">
        
            <div id="furkation_1_38_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_38_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_38_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_38_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_38_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_38_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_38_db_btn" onclick="toggle_BOP_38_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_db(); calc();}">
            <div id="BOP_38_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_38_b_btn" onclick="toggle_BOP_38_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_b(); calc();}">
            <div id="BOP_38_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_38_mb_btn" onclick="toggle_BOP_38_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_mb(); calc();}">
            <div id="BOP_38_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_38_db_btn" onclick="toggle_PI_38_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_db(); calc();}">
            <div id="PI_38_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_38_b_btn" onclick="toggle_PI_38_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_b(); calc();}">
            <div id="PI_38_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_38_mb_btn" onclick="toggle_PI_38_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_mb(); calc();}">
            <div id="PI_38_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                    
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_38_db_txt" name="mg_38_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="389">
            <input class="input_mg" id="mg_38_b_txt" name="mg_38_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="388">
            <input class="input_mg" id="mg_38_mb_txt" name="mg_38_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="387">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_38_db_txt" name="st_38_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="437">
            <input class="input_st" id="st_38_b_txt" name="st_38_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="436">
            <input class="input_st" id="st_38_mb_txt" name="st_38_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="435">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_38_dl_txt" name="mg_38_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="293">
            <input class="input_mg" id="mg_38_l_txt" name="mg_38_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="292">
            <input class="input_mg" id="mg_38_ml_txt" name="mg_38_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="291">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_38_dl_txt" name="st_38_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="341">
            <input class="input_st" id="st_38_l_txt" name="st_38_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="340">
            <input class="input_st" id="st_38_ml_txt" name="st_38_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_38();}" tabindex="339">
        </div>

        <div class="BOP_hover_btn" id="BOP_38_dl_btn" onclick="toggle_BOP_38_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_dl(); calc();}">
            <div id="BOP_38_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_38_l_btn" onclick="toggle_BOP_38_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_l(); calc();}">
            <div id="BOP_38_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_38_ml_btn" onclick="toggle_BOP_38_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_38_ml(); calc();}">
            <div id="BOP_38_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_38_dl_btn" onclick="toggle_PI_38_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_dl(); calc();}">
            <div id="PI_38_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_38_l_btn" onclick="toggle_PI_38_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_l(); calc();}">
            <div id="PI_38_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_38_ml_btn" onclick="toggle_PI_38_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_38_ml(); calc();}">
            <div id="PI_38_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_38_l_btn" onclick="toggle_furcation_38_l();">
        
            <div id="furkation_1_38_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_38_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_38_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_38_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_38_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_38_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_38_txt" name="bemerkung_38" type="text" value="" tabindex="245">
        </div>                <div class="tooth_hover_btn" id="tooth_37_btn" onclick="if (event.shiftKey) {clear_data_37(); calc();} else {toggle_tooth_37(); calc();}">18</div>
        
        <div id="tooth_line_37_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_37_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>

        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_37_txt" name="beweglichkeit_37" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="452">
        </div>

        <div id="implantat_37_btn" onclick="toggle_implant_37();">
            <div id="implantat_37_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_37_b_image" style="display: none;">
            <img src="./img/implants/3/37b.png" width="62" height="131" alt="">
        </div>
        <div id="implantat_37_l_image" style="display: none;">
            <img src="./img/implants/3/37l.png" width="63" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_37_b_btn" onclick="toggle_furcation_37_b();">
        
            <div id="furkation_1_37_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_37_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_37_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_37_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_37_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_37_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_37_db_btn" onclick="toggle_BOP_37_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_db(); calc();}">
            <div id="BOP_37_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_37_b_btn" onclick="toggle_BOP_37_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_b(); calc();}">
            <div id="BOP_37_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_37_mb_btn" onclick="toggle_BOP_37_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_mb(); calc();}">
            <div id="BOP_37_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_37_db_btn" onclick="toggle_PI_37_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_db(); calc();}">
            <div id="PI_37_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_37_b_btn" onclick="toggle_PI_37_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_b(); calc();}">
            <div id="PI_37_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_37_mb_btn" onclick="toggle_PI_37_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_mb(); calc();}">
            <div id="PI_37_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                        
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_37_db_txt" name="mg_37_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="386">
            <input class="input_mg" id="mg_37_b_txt" name="mg_37_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="385">
            <input class="input_mg" id="mg_37_mb_txt" name="mg_37_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="384">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_37_db_txt" name="st_37_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="434">
            <input class="input_st" id="st_37_b_txt" name="st_37_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="433">
            <input class="input_st" id="st_37_mb_txt" name="st_37_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="432">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_37_dl_txt" name="mg_37_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="290">
            <input class="input_mg" id="mg_37_l_txt" name="mg_37_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="289">
            <input class="input_mg" id="mg_37_ml_txt" name="mg_37_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="288">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_37_dl_txt" name="st_37_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="338">
            <input class="input_st" id="st_37_l_txt" name="st_37_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="337">
            <input class="input_st" id="st_37_ml_txt" name="st_37_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_37();}" tabindex="336">
        </div>

        <div class="BOP_hover_btn" id="BOP_37_dl_btn" onclick="toggle_BOP_37_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_dl(); calc();}">
            <div id="BOP_37_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="BOP_hover_btn" id="BOP_37_l_btn" onclick="toggle_BOP_37_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_l(); calc();}">
            <div id="BOP_37_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_37_ml_btn" onclick="toggle_BOP_37_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_37_ml(); calc();}">
            <div id="BOP_37_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_37_dl_btn" onclick="toggle_PI_37_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_dl(); calc();}">
            <div id="PI_37_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_37_l_btn" onclick="toggle_PI_37_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_l(); calc();}">
            <div id="PI_37_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_37_ml_btn" onclick="toggle_PI_37_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_37_ml(); calc();}">
            <div id="PI_37_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_37_l_btn" onclick="toggle_furcation_37_l();">
        
            <div id="furkation_1_37_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_37_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_37_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_37_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_37_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_37_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_37_txt" name="bemerkung_37" type="text" value="" tabindex="244">
        </div>                <div class="tooth_hover_btn" id="tooth_36_btn" onclick="if (event.shiftKey) {clear_data_36(); calc();} else {toggle_tooth_36(); calc();}">19</div>
        
        <div id="tooth_line_36_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_36_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_36_txt" name="beweglichkeit_36" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="451">
        </div>

        <div id="implantat_36_btn" onclick="toggle_implant_36();">
            <div id="implantat_36_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_36_b_image" style="display: none;">
            <img src="./img/implants/3/36b.png" width="67" height="131" alt="">
        </div>
        <div id="implantat_36_l_image" style="display: none;">
            <img src="./img/implants/3/36l.png" width="61" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_36_b_btn" onclick="toggle_furcation_36_b();">
        
            <div id="furkation_1_36_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_36_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_36_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_36_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_36_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_36_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_36_db_btn" onclick="toggle_BOP_36_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_db(); calc();}">
            <div id="BOP_36_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_36_b_btn" onclick="toggle_BOP_36_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_b(); calc();}">
            <div id="BOP_36_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_36_mb_btn" onclick="toggle_BOP_36_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_mb(); calc();}">
            <div id="BOP_36_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_36_db_btn" onclick="toggle_PI_36_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_db(); calc();}">
            <div id="PI_36_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_36_b_btn" onclick="toggle_PI_36_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_b(); calc();}">
            <div id="PI_36_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_36_mb_btn" onclick="toggle_PI_36_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_mb(); calc();}">
            <div id="PI_36_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                    
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_36_db_txt" name="mg_36_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="383">
            <input class="input_mg" id="mg_36_b_txt" name="mg_36_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="382">
            <input class="input_mg" id="mg_36_mb_txt" name="mg_36_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="381">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_36_db_txt" name="st_36_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="431">
            <input class="input_st" id="st_36_b_txt" name="st_36_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="430">
            <input class="input_st" id="st_36_mb_txt" name="st_36_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="429">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_36_dl_txt" name="mg_36_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="287">
            <input class="input_mg" id="mg_36_l_txt" name="mg_36_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="286">
            <input class="input_mg" id="mg_36_ml_txt" name="mg_36_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="285">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_36_dl_txt" name="st_36_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="335">
            <input class="input_st" id="st_36_l_txt" name="st_36_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="334">
            <input class="input_st" id="st_36_ml_txt" name="st_36_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_36();}" tabindex="333">
        </div>

        <div class="BOP_hover_btn" id="BOP_36_dl_btn" onclick="toggle_BOP_36_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_dl(); calc();}">
            <div id="BOP_36_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_36_l_btn" onclick="toggle_BOP_36_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_l(); calc();}">
            <div id="BOP_36_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_36_ml_btn" onclick="toggle_BOP_36_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_36_ml(); calc();}">
            <div id="BOP_36_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_36_dl_btn" onclick="toggle_PI_36_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_dl(); calc();}">
            <div id="PI_36_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_36_l_btn" onclick="toggle_PI_36_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_l(); calc();}">
            <div id="PI_36_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_36_ml_btn" onclick="toggle_PI_36_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_36_ml(); calc();}">
            <div id="PI_36_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_36_l_btn" onclick="toggle_furcation_36_l();">
        
            <div id="furkation_1_36_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_36_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_36_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_36_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_36_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_36_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_36_txt" name="bemerkung_36" type="text" value="" tabindex="243">
        </div>                <div class="tooth_hover_btn" id="tooth_35_btn" onclick="if (event.shiftKey) {clear_data_35(); calc();} else {toggle_tooth_35(); calc();}">20</div>

        <div id="tooth_line_35_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_35_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_35_txt" name="beweglichkeit_35" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="450">
        </div>

        <div id="implantat_35_btn" onclick="toggle_implant_35();">
            <div id="implantat_35_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_35_b_image" style="display: none;">
            <img src="./img/implants/3/35b.png" width="43" height="131" alt="">
        </div>
        <div id="implantat_35_l_image" style="display: none;">
            <img src="./img/implants/3/35l.png" width="44" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_35_db_btn" onclick="toggle_BOP_35_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_db(); calc();}">
            <div id="BOP_35_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_35_b_btn" onclick="toggle_BOP_35_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_b(); calc();}">
            <div id="BOP_35_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_35_mb_btn" onclick="toggle_BOP_35_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_mb(); calc();}">
            <div id="BOP_35_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_35_db_btn" onclick="toggle_PI_35_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_db(); calc();}">
            <div id="PI_35_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_35_b_btn" onclick="toggle_PI_35_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_b(); calc();}">
            <div id="PI_35_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_35_mb_btn" onclick="toggle_PI_35_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_mb(); calc();}">
            <div id="PI_35_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                            
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_35_db_txt" name="mg_35_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="380">
            <input class="input_mg" id="mg_35_b_txt" name="mg_35_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="379">
            <input class="input_mg" id="mg_35_mb_txt" name="mg_35_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="378">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_35_db_txt" name="st_35_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="428">
            <input class="input_st" id="st_35_b_txt" name="st_35_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="427">
            <input class="input_st" id="st_35_mb_txt" name="st_35_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="426">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_35_dl_txt" name="mg_35_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="284">
            <input class="input_mg" id="mg_35_l_txt" name="mg_35_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="283">
            <input class="input_mg" id="mg_35_ml_txt" name="mg_35_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="282">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_35_dl_txt" name="st_35_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="332">
            <input class="input_st" id="st_35_l_txt" name="st_35_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="331">
            <input class="input_st" id="st_35_ml_txt" name="st_35_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_35();}" tabindex="330">
        </div>

        <div class="BOP_hover_btn" id="BOP_35_dl_btn" onclick="toggle_BOP_35_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_dl(); calc();}">
            <div id="BOP_35_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_35_l_btn" onclick="toggle_BOP_35_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_l(); calc();}">
            <div id="BOP_35_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_35_ml_btn" onclick="toggle_BOP_35_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_35_ml(); calc();}">
            <div id="BOP_35_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_35_dl_btn" onclick="toggle_PI_35_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_dl(); calc();}">
            <div id="PI_35_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_35_l_btn" onclick="toggle_PI_35_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_l(); calc();}">
            <div id="PI_35_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_35_ml_btn" onclick="toggle_PI_35_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_35_ml(); calc();}">
            <div id="PI_35_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_35_txt" name="bemerkung_35" type="text" value="" tabindex="242">
        </div>                <div class="tooth_hover_btn" id="tooth_34_btn" onclick="if (event.shiftKey) {clear_data_34(); calc();} else {toggle_tooth_34(); calc();}">21</div>

        <div id="tooth_line_34_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_34_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_34_txt" name="beweglichkeit_34" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="449">
        </div>

        <div id="implantat_34_btn" onclick="toggle_implant_34();">
            <div id="implantat_34_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_34_b_image" style="display: none;">
            <img src="./img/implants/3/34b.png" width="38" height="131" alt="">
        </div>
        <div id="implantat_34_l_image" style="display: none;">
            <img src="./img/implants/3/34l.png" width="40" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_34_db_btn" onclick="toggle_BOP_34_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_db(); calc();}">
            <div id="BOP_34_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_34_b_btn" onclick="toggle_BOP_34_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_b(); calc();}">
            <div id="BOP_34_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_34_mb_btn" onclick="toggle_BOP_34_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_mb(); calc();}">
            <div id="BOP_34_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_34_db_btn" onclick="toggle_PI_34_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_db(); calc();}">
            <div id="PI_34_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_34_b_btn" onclick="toggle_PI_34_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_b(); calc();}">
            <div id="PI_34_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_34_mb_btn" onclick="toggle_PI_34_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_mb(); calc();}">
            <div id="PI_34_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                        
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_34_db_txt" name="mg_34_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="377">
            <input class="input_mg" id="mg_34_b_txt" name="mg_34_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="376">
            <input class="input_mg" id="mg_34_mb_txt" name="mg_34_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="375">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_34_db_txt" name="st_34_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="425">
            <input class="input_st" id="st_34_b_txt" name="st_34_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="424">
            <input class="input_st" id="st_34_mb_txt" name="st_34_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="423">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_34_dl_txt" name="mg_34_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="281">
            <input class="input_mg" id="mg_34_l_txt" name="mg_34_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="280">
            <input class="input_mg" id="mg_34_ml_txt" name="mg_34_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="279">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_34_dl_txt" name="st_34_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="329">
            <input class="input_st" id="st_34_l_txt" name="st_34_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="328">
            <input class="input_st" id="st_34_ml_txt" name="st_34_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_34();}" tabindex="327">
        </div>

        <div class="BOP_hover_btn" id="BOP_34_dl_btn" onclick="toggle_BOP_34_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_dl(); calc();}">
            <div id="BOP_34_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_34_l_btn" onclick="toggle_BOP_34_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_l(); calc();}">
            <div id="BOP_34_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_34_ml_btn" onclick="toggle_BOP_34_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_34_ml(); calc();}">
            <div id="BOP_34_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_34_dl_btn" onclick="toggle_PI_34_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_dl(); calc();}">
            <div id="PI_34_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_34_l_btn" onclick="toggle_PI_34_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_l(); calc();}">
            <div id="PI_34_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_34_ml_btn" onclick="toggle_PI_34_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_34_ml(); calc();}">
            <div id="PI_34_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_34_txt" name="bemerkung_34" type="text" value="" tabindex="241">
        </div>                <div class="tooth_hover_btn" id="tooth_33_btn" onclick="if (event.shiftKey) {clear_data_33(); calc();} else {toggle_tooth_33(); calc();}">22</div>

        <div id="tooth_line_33_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_33_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_33_txt" name="beweglichkeit_33" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="448">
        </div>

        <div id="implantat_33_btn" onclick="toggle_implant_33();">
            <div id="implantat_33_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_33_b_image" style="display: none;">
            <img src="./img/implants/3/33b.png" width="39" height="131" alt="">
        </div>
        <div id="implantat_33_l_image" style="display: none;">
            <img src="./img/implants/3/33l.png" width="37" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_33_db_btn" onclick="toggle_BOP_33_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_db(); calc();}">
            <div id="BOP_33_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_33_b_btn" onclick="toggle_BOP_33_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_b(); calc();}">
            <div id="BOP_33_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_33_mb_btn" onclick="toggle_BOP_33_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_mb(); calc();}">
            <div id="BOP_33_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_33_db_btn" onclick="toggle_PI_33_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_db(); calc();}">
            <div id="PI_33_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_33_b_btn" onclick="toggle_PI_33_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_b(); calc();}">
            <div id="PI_33_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_33_mb_btn" onclick="toggle_PI_33_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_mb(); calc();}">
            <div id="PI_33_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_33_db_txt" name="mg_33_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="374">
            <input class="input_mg" id="mg_33_b_txt" name="mg_33_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="373">
            <input class="input_mg" id="mg_33_mb_txt" name="mg_33_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="372">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_33_db_txt" name="st_33_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="422">
            <input class="input_st" id="st_33_b_txt" name="st_33_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="421">
            <input class="input_st" id="st_33_mb_txt" name="st_33_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="420">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_33_dl_txt" name="mg_33_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="278">
            <input class="input_mg" id="mg_33_l_txt" name="mg_33_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="277">
            <input class="input_mg" id="mg_33_ml_txt" name="mg_33_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="276">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_33_dl_txt" name="st_33_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="326">
            <input class="input_st" id="st_33_l_txt" name="st_33_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="325">
            <input class="input_st" id="st_33_ml_txt" name="st_33_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_33();}" tabindex="324">
        </div>

        <div class="BOP_hover_btn" id="BOP_33_dl_btn" onclick="toggle_BOP_33_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_dl(); calc();}">
            <div id="BOP_33_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_33_l_btn" onclick="toggle_BOP_33_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_l(); calc();}">
            <div id="BOP_33_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_33_ml_btn" onclick="toggle_BOP_33_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_33_ml(); calc();}">
            <div id="BOP_33_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_33_dl_btn" onclick="toggle_PI_33_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_dl(); calc();}">
            <div id="PI_33_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_33_l_btn" onclick="toggle_PI_33_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_l(); calc();}">
            <div id="PI_33_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_33_ml_btn" onclick="toggle_PI_33_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_33_ml(); calc();}">
            <div id="PI_33_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_33_txt" name="bemerkung_33" type="text" value="" tabindex="240">
        </div>                <div class="tooth_hover_btn" id="tooth_32_btn" onclick="if (event.shiftKey) {clear_data_32(); calc();} else {toggle_tooth_32(); calc();}">23</div>

        <div id="tooth_line_32_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_32_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_32_txt" name="beweglichkeit_32" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="447">
        </div>
    
        <div id="implantat_32_btn" onclick="toggle_implant_32();">
            <div id="implantat_32_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_32_b_image" style="display: none;">
            <img src="./img/implants/3/32b.png" width="37" height="131" alt="">
        </div>
        <div id="implantat_32_l_image" style="display: none;">
            <img src="./img/implants/3/32l.png" width="35" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_32_db_btn" onclick="toggle_BOP_32_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_db(); calc();}">
            <div id="BOP_32_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_32_b_btn" onclick="toggle_BOP_32_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_b(); calc();}">
            <div id="BOP_32_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_32_mb_btn" onclick="toggle_BOP_32_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_mb(); calc();}">
            <div id="BOP_32_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_32_db_btn" onclick="toggle_PI_32_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_db(); calc();}">
            <div id="PI_32_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_32_b_btn" onclick="toggle_PI_32_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_b(); calc();}">
            <div id="PI_32_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_32_mb_btn" onclick="toggle_PI_32_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_mb(); calc();}">
            <div id="PI_32_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                        
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_32_db_txt" name="mg_32_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="371">
            <input class="input_mg" id="mg_32_b_txt" name="mg_32_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="370">
            <input class="input_mg" id="mg_32_mb_txt" name="mg_32_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="369">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_32_db_txt" name="st_32_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="419">
            <input class="input_st" id="st_32_b_txt" name="st_32_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="418">
            <input class="input_st" id="st_32_mb_txt" name="st_32_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="417">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_32_dl_txt" name="mg_32_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="275">
            <input class="input_mg" id="mg_32_l_txt" name="mg_32_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="274">
            <input class="input_mg" id="mg_32_ml_txt" name="mg_32_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="273">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_32_dl_txt" name="st_32_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="323">
            <input class="input_st" id="st_32_l_txt" name="st_32_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="322">
            <input class="input_st" id="st_32_ml_txt" name="st_32_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_32();}" tabindex="321">
        </div>

        <div class="BOP_hover_btn" id="BOP_32_dl_btn" onclick="toggle_BOP_32_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_dl(); calc();}">
            <div id="BOP_32_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_32_l_btn" onclick="toggle_BOP_32_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_l(); calc();}">
            <div id="BOP_32_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_32_ml_btn" onclick="toggle_BOP_32_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_32_ml(); calc();}">
            <div id="BOP_32_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_32_dl_btn" onclick="toggle_PI_32_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_dl(); calc();}">
            <div id="PI_32_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_32_l_btn" onclick="toggle_PI_32_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_l(); calc();}">
            <div id="PI_32_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_32_ml_btn" onclick="toggle_PI_32_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_32_ml(); calc();}">
            <div id="PI_32_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_32_txt" name="bemerkung_32" type="text" value="" tabindex="239">
        </div>                <div class="tooth_hover_btn" id="tooth_31_btn" onclick="if (event.shiftKey) {clear_data_31(); calc();} else {toggle_tooth_31(); calc();}">24</div>

        <div id="tooth_line_31_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_31_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_31_txt" name="beweglichkeit_31" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="446">
        </div>

        <div id="implantat_31_btn" onclick="toggle_implant_31();">
            <div id="implantat_31_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_31_b_image" style="display: none;">
            <img src="./img/implants/3/31b.png" width="42" height="131" alt="">
        </div>
        <div id="implantat_31_l_image" style="display: none;">
            <img src="./img/implants/3/31l.png" width="44" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_31_db_btn" onclick="toggle_BOP_31_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_db(); calc();}">
            <div id="BOP_31_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_31_b_btn" onclick="toggle_BOP_31_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_b(); calc();}">
            <div id="BOP_31_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_31_mb_btn" onclick="toggle_BOP_31_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_mb(); calc();}">
            <div id="BOP_31_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_31_db_btn" onclick="toggle_PI_31_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_db(); calc();}">
            <div id="PI_31_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_31_b_btn" onclick="toggle_PI_31_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_b(); calc();}">
            <div id="PI_31_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_31_mb_btn" onclick="toggle_PI_31_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_mb(); calc();}">
            <div id="PI_31_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                        
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_31_db_txt" name="mg_31_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="368">
            <input class="input_mg" id="mg_31_b_txt" name="mg_31_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="367">
            <input class="input_mg" id="mg_31_mb_txt" name="mg_31_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="366">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_31_db_txt" name="st_31_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="416">
            <input class="input_st" id="st_31_b_txt" name="st_31_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="415">
            <input class="input_st" id="st_31_mb_txt" name="st_31_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="414">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_31_dl_txt" name="mg_31_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="272">
            <input class="input_mg" id="mg_31_l_txt" name="mg_31_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="271">
            <input class="input_mg" id="mg_31_ml_txt" name="mg_31_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="270">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_31_dl_txt" name="st_31_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="320">
            <input class="input_st" id="st_31_l_txt" name="st_31_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="319">
            <input class="input_st" id="st_31_ml_txt" name="st_31_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_31();}" tabindex="318">
        </div>

        <div class="BOP_hover_btn" id="BOP_31_dl_btn" onclick="toggle_BOP_31_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_dl(); calc();}">
            <div id="BOP_31_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_31_l_btn" onclick="toggle_BOP_31_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_l(); calc();}">
            <div id="BOP_31_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_31_ml_btn" onclick="toggle_BOP_31_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_31_ml(); calc();}">
            <div id="BOP_31_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_31_dl_btn" onclick="toggle_PI_31_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_dl(); calc();}">
            <div id="PI_31_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_31_l_btn" onclick="toggle_PI_31_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_l(); calc();}">
            <div id="PI_31_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_31_ml_btn" onclick="toggle_PI_31_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_31_ml(); calc();}">
            <div id="PI_31_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_31_txt" name="bemerkung_31" type="text" value="" tabindex="238">
        </div>
                <div class="tooth_hover_btn" id="tooth_41_btn" onclick="if (event.shiftKey) {clear_data_41(); calc();} else {toggle_tooth_41(); calc();}">25</div>

        <div id="tooth_line_41_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_41_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>

        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_41_txt" name="beweglichkeit_41" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="445">
        </div>

        <div id="implantat_41_btn" onclick="toggle_implant_41();">
            <div id="implantat_41_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_41_b_image" style="display: none;">
            <img src="./img/implants/4/41b.png" width="43" height="131" alt="">
        </div>
        <div id="implantat_41_l_image" style="display: none;">
            <img src="./img/implants/4/41l.png" width="46" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_41_db_btn" onclick="toggle_BOP_41_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_db(); calc();}">
            <div id="BOP_41_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_41_b_btn" onclick="toggle_BOP_41_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_b(); calc();}">
            <div id="BOP_41_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_41_mb_btn" onclick="toggle_BOP_41_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_mb(); calc();}">
            <div id="BOP_41_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_41_db_btn" onclick="toggle_PI_41_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_db(); calc();}">
            <div id="PI_41_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_41_b_btn" onclick="toggle_PI_41_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_b(); calc();}">
            <div id="PI_41_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_41_mb_btn" onclick="toggle_PI_41_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_mb(); calc();}">
            <div id="PI_41_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                            
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_41_db_txt" name="mg_41_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="363">
            <input class="input_mg" id="mg_41_b_txt" name="mg_41_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="364">
            <input class="input_mg" id="mg_41_mb_txt" name="mg_41_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="365">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_41_db_txt" name="st_41_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="411">
            <input class="input_st" id="st_41_b_txt" name="st_41_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="412">
            <input class="input_st" id="st_41_mb_txt" name="st_41_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="413">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_41_dl_txt" name="mg_41_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="267">
            <input class="input_mg" id="mg_41_l_txt" name="mg_41_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="268">
            <input class="input_mg" id="mg_41_ml_txt" name="mg_41_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="269">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_41_dl_txt" name="st_41_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="315">
            <input class="input_st" id="st_41_l_txt" name="st_41_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="316">
            <input class="input_st" id="st_41_ml_txt" name="st_41_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_41();}" tabindex="317">
        </div>

        <div class="BOP_hover_btn" id="BOP_41_dl_btn" onclick="toggle_BOP_41_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_dl(); calc();}">
            <div id="BOP_41_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_41_l_btn" onclick="toggle_BOP_41_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_l(); calc();}">
            <div id="BOP_41_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_41_ml_btn" onclick="toggle_BOP_41_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_41_ml(); calc();}">
            <div id="BOP_41_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_41_dl_btn" onclick="toggle_PI_41_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_dl(); calc();}">
            <div id="PI_41_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_41_l_btn" onclick="toggle_PI_41_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_l(); calc();}">
            <div id="PI_41_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_41_ml_btn" onclick="toggle_PI_41_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_41_ml(); calc();}">
            <div id="PI_41_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_41_txt" name="bemerkung_41" type="text" value="" tabindex="237">
        </div>                <div class="tooth_hover_btn" id="tooth_42_btn" onclick="if (event.shiftKey) {clear_data_42(); calc();} else {toggle_tooth_42(); calc();}">26</div>

        <div id="tooth_line_42_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_42_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_42_txt" name="beweglichkeit_42" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="444">
        </div>

        <div id="implantat_42_btn" onclick="toggle_implant_42();">
            <div id="implantat_42_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_42_b_image" style="display: none;">
            <img src="./img/implants/4/42b.png" width="38" height="131" alt="">
        </div>
        <div id="implantat_42_l_image" style="display: none;">
            <img src="./img/implants/4/42l.png" width="35" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_42_db_btn" onclick="toggle_BOP_42_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_db(); calc();}">
            <div id="BOP_42_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_42_b_btn" onclick="toggle_BOP_42_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_b(); calc();}">
            <div id="BOP_42_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_42_mb_btn" onclick="toggle_BOP_42_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_mb(); calc();}">
            <div id="BOP_42_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_42_db_btn" onclick="toggle_PI_42_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_db(); calc();}">
            <div id="PI_42_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_42_b_btn" onclick="toggle_PI_42_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_b(); calc();}">
            <div id="PI_42_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_42_mb_btn" onclick="toggle_PI_42_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_mb(); calc();}">
            <div id="PI_42_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                    
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_42_db_txt" name="mg_42_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="360">
            <input class="input_mg" id="mg_42_b_txt" name="mg_42_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="361">
            <input class="input_mg" id="mg_42_mb_txt" name="mg_42_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="362">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_42_db_txt" name="st_42_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="408">
            <input class="input_st" id="st_42_b_txt" name="st_42_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="409">
            <input class="input_st" id="st_42_mb_txt" name="st_42_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="410">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_42_dl_txt" name="mg_42_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="264">
            <input class="input_mg" id="mg_42_l_txt" name="mg_42_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="265">
            <input class="input_mg" id="mg_42_ml_txt" name="mg_42_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="266">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_42_dl_txt" name="st_42_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="312">
            <input class="input_st" id="st_42_l_txt" name="st_42_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="313">
            <input class="input_st" id="st_42_ml_txt" name="st_42_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_42();}" tabindex="314">
        </div>

        <div class="BOP_hover_btn" id="BOP_42_dl_btn" onclick="toggle_BOP_42_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_dl(); calc();}">
            <div id="BOP_42_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_42_l_btn" onclick="toggle_BOP_42_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_l(); calc();}">
            <div id="BOP_42_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_42_ml_btn" onclick="toggle_BOP_42_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_42_ml(); calc();}">
            <div id="BOP_42_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_42_dl_btn" onclick="toggle_PI_42_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_dl(); calc();}">
            <div id="PI_42_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_42_l_btn" onclick="toggle_PI_42_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_l(); calc();}">
            <div id="PI_42_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_42_ml_btn" onclick="toggle_PI_42_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_42_ml(); calc();}">
            <div id="PI_42_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_42_txt" name="bemerkung_42" type="text" value="" tabindex="236">
        </div>                <div class="tooth_hover_btn" id="tooth_43_btn" onclick="if (event.shiftKey) {clear_data_43(); calc();} else {toggle_tooth_43(); calc();}">27</div>

        <div id="tooth_line_43_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_43_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_43_txt" name="beweglichkeit_43" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="443">
        </div>

        <div id="implantat_43_btn" onclick="toggle_implant_43();">
            <div id="implantat_43_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_43_b_image" style="display: none;">
            <img src="./img/implants/4/43b.png" width="39" height="131" alt="">
        </div>
        <div id="implantat_43_l_image" style="display: none;">
            <img src="./img/implants/4/43l.png" width="36" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_43_db_btn" onclick="toggle_BOP_43_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_db(); calc();}">
            <div id="BOP_43_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_43_b_btn" onclick="toggle_BOP_43_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_b(); calc();}">
            <div id="BOP_43_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_43_mb_btn" onclick="toggle_BOP_43_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_mb(); calc();}">
            <div id="BOP_43_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_43_db_btn" onclick="toggle_PI_43_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_db(); calc();}">
            <div id="PI_43_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_43_b_btn" onclick="toggle_PI_43_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_b(); calc();}">
            <div id="PI_43_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_43_mb_btn" onclick="toggle_PI_43_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_mb(); calc();}">
            <div id="PI_43_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_43_db_txt" name="mg_43_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="357">
            <input class="input_mg" id="mg_43_b_txt" name="mg_43_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="358">
            <input class="input_mg" id="mg_43_mb_txt" name="mg_43_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="359">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_43_db_txt" name="st_43_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="405">
            <input class="input_st" id="st_43_b_txt" name="st_43_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="406">
            <input class="input_st" id="st_43_mb_txt" name="st_43_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="407">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_43_dl_txt" name="mg_43_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="261">
            <input class="input_mg" id="mg_43_l_txt" name="mg_43_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="262">
            <input class="input_mg" id="mg_43_ml_txt" name="mg_43_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="263">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_43_dl_txt" name="st_43_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="309">
            <input class="input_st" id="st_43_l_txt" name="st_43_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="310">
            <input class="input_st" id="st_43_ml_txt" name="st_43_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_43();}" tabindex="311">
        </div>

        <div class="BOP_hover_btn" id="BOP_43_dl_btn" onclick="toggle_BOP_43_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_dl(); calc();}">
            <div id="BOP_43_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_43_l_btn" onclick="toggle_BOP_43_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_l(); calc();}">
            <div id="BOP_43_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_43_ml_btn" onclick="toggle_BOP_43_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_43_ml(); calc();}">
            <div id="BOP_43_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_43_dl_btn" onclick="toggle_PI_43_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_dl(); calc();}">
            <div id="PI_43_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_43_l_btn" onclick="toggle_PI_43_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_l(); calc();}">
            <div id="PI_43_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_43_ml_btn" onclick="toggle_PI_43_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_43_ml(); calc();}">
            <div id="PI_43_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_43_txt" name="bemerkung_43" type="text" value="" tabindex="235">
        </div>                <div class="tooth_hover_btn" id="tooth_44_btn" onclick="if (event.shiftKey) {clear_data_44(); calc();} else {toggle_tooth_44(); calc();}">28</div>

        <div id="tooth_line_44_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_44_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_44_txt" name="beweglichkeit_44" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="442">
        </div>

        <div id="implantat_44_btn" onclick="toggle_implant_44();">
            <div id="implantat_44_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_44_b_image" style="display: none;">
            <img src="./img/implants/4/44b.png" width="37" height="131" alt="">
        </div>
        <div id="implantat_44_l_image" style="display: none;">
            <img src="./img/implants/4/44l.png" width="40" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_44_db_btn" onclick="toggle_BOP_44_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_db(); calc();}">
            <div id="BOP_44_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_44_b_btn" onclick="toggle_BOP_44_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_b(); calc();}">
            <div id="BOP_44_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_44_mb_btn" onclick="toggle_BOP_44_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_mb(); calc();}">
            <div id="BOP_44_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_44_db_btn" onclick="toggle_PI_44_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_db(); calc();}">
            <div id="PI_44_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_44_b_btn" onclick="toggle_PI_44_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_b(); calc();}">
            <div id="PI_44_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_44_mb_btn" onclick="toggle_PI_44_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_mb(); calc();}">
            <div id="PI_44_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_44_db_txt" name="mg_44_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="354">
            <input class="input_mg" id="mg_44_b_txt" name="mg_44_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="355">
            <input class="input_mg" id="mg_44_mb_txt" name="mg_44_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="356">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_44_db_txt" name="st_44_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="402">
            <input class="input_st" id="st_44_b_txt" name="st_44_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="403">
            <input class="input_st" id="st_44_mb_txt" name="st_44_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="404">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_44_dl_txt" name="mg_44_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="258">
            <input class="input_mg" id="mg_44_l_txt" name="mg_44_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="259">
            <input class="input_mg" id="mg_44_ml_txt" name="mg_44_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="260">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_44_dl_txt" name="st_44_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="306">
            <input class="input_st" id="st_44_l_txt" name="st_44_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="307">
            <input class="input_st" id="st_44_ml_txt" name="st_44_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_44();}" tabindex="308">
        </div>

        <div class="BOP_hover_btn" id="BOP_44_dl_btn" onclick="toggle_BOP_44_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_dl(); calc();}">
            <div id="BOP_44_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_44_l_btn" onclick="toggle_BOP_44_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_l(); calc();}">
            <div id="BOP_44_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_44_ml_btn" onclick="toggle_BOP_44_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_44_ml(); calc();}">
            <div id="BOP_44_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_44_dl_btn" onclick="toggle_PI_44_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_dl(); calc();}">
            <div id="PI_44_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_44_l_btn" onclick="toggle_PI_44_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_l(); calc();}">
            <div id="PI_44_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_44_ml_btn" onclick="toggle_PI_44_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_44_ml(); calc();}">
            <div id="PI_44_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_44_txt" name="bemerkung_44" type="text" value="" tabindex="234">
        </div>                <div class="tooth_hover_btn" id="tooth_45_btn" onclick="if (event.shiftKey) {clear_data_45(); calc();} else {toggle_tooth_45(); calc();}">29</div>

        <div id="tooth_line_45_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_45_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_45_txt" name="beweglichkeit_45" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="441">
        </div>

        <div id="implantat_45_btn" onclick="toggle_implant_45();">
            <div id="implantat_45_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>

        <div id="implantat_45_b_image" style="display: none;">
            <img src="./img/implants/4/45b.png" width="43" height="131" alt="">
        </div>
        <div id="implantat_45_l_image" style="display: none;">
            <img src="./img/implants/4/45l.png" width="43" height="133" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_45_db_btn" onclick="toggle_BOP_45_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_db(); calc();}">
            <div id="BOP_45_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_45_b_btn" onclick="toggle_BOP_45_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_b(); calc();}">
            <div id="BOP_45_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_45_mb_btn" onclick="toggle_BOP_45_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_mb(); calc();}">
            <div id="BOP_45_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_45_db_btn" onclick="toggle_PI_45_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_db(); calc();}">
            <div id="PI_45_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_45_b_btn" onclick="toggle_PI_45_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_b(); calc();}">
            <div id="PI_45_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_45_mb_btn" onclick="toggle_PI_45_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_mb(); calc();}">
            <div id="PI_45_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
                                    
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_45_db_txt" name="mg_45_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="351">
            <input class="input_mg" id="mg_45_b_txt" name="mg_45_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="352">
            <input class="input_mg" id="mg_45_mb_txt" name="mg_45_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="353">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_45_db_txt" name="st_45_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="399">
            <input class="input_st" id="st_45_b_txt" name="st_45_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="400">
            <input class="input_st" id="st_45_mb_txt" name="st_45_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="401">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_45_dl_txt" name="mg_45_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="255">
            <input class="input_mg" id="mg_45_l_txt" name="mg_45_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="256">
            <input class="input_mg" id="mg_45_ml_txt" name="mg_45_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="257">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_45_dl_txt" name="st_45_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="303">
            <input class="input_st" id="st_45_l_txt" name="st_45_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="304">
            <input class="input_st" id="st_45_ml_txt" name="st_45_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_45();}" tabindex="305">
        </div>

        <div class="BOP_hover_btn" id="BOP_45_dl_btn" onclick="toggle_BOP_45_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_dl(); calc();}">
            <div id="BOP_45_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_45_l_btn" onclick="toggle_BOP_45_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_l(); calc();}">
            <div id="BOP_45_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_45_ml_btn" onclick="toggle_BOP_45_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_45_ml(); calc();}">
            <div id="BOP_45_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_45_dl_btn" onclick="toggle_PI_45_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_dl(); calc();}">
            <div id="PI_45_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_45_l_btn" onclick="toggle_PI_45_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_l(); calc();}">
            <div id="PI_45_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_45_ml_btn" onclick="toggle_PI_45_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_45_ml(); calc();}">
            <div id="PI_45_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_non-molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_45_txt" name="bemerkung_45" type="text" value="" tabindex="233">
        </div>                <div class="tooth_hover_btn" id="tooth_46_btn" onclick="if (event.shiftKey) {clear_data_46(); calc();} else {toggle_tooth_46(); calc();}">30</div>
        
        <div id="tooth_line_46_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_46_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_46_txt" name="beweglichkeit_46" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="440">
        </div>

        <div id="implantat_46_btn" onclick="toggle_implant_46();">
            <div id="implantat_46_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_46_b_image" style="display: none;">
            <img src="./img/implants/4/46b.png" width="67" height="131" alt="">
        </div>
        <div id="implantat_46_l_image" style="display: none;">
            <img src="./img/implants/4/46l.png" width="62" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_46_b_btn" onclick="toggle_furcation_46_b();">
        
            <div id="furkation_1_46_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_46_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_46_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_46_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_46_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_46_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_46_db_btn" onclick="toggle_BOP_46_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_db(); calc();}">
            <div id="BOP_46_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_46_b_btn" onclick="toggle_BOP_46_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_b(); calc();}">
            <div id="BOP_46_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_46_mb_btn" onclick="toggle_BOP_46_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_mb(); calc();}">
            <div id="BOP_46_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_46_db_btn" onclick="toggle_PI_46_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_db(); calc();}">
            <div id="PI_46_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_46_b_btn" onclick="toggle_PI_46_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_b(); calc();}">
            <div id="PI_46_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_46_mb_btn" onclick="toggle_PI_46_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_mb(); calc();}">
            <div id="PI_46_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                                        
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_46_db_txt" name="mg_46_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="348">
            <input class="input_mg" id="mg_46_b_txt" name="mg_46_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="349">
            <input class="input_mg" id="mg_46_mb_txt" name="mg_46_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="350">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_46_db_txt" name="st_46_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="396">
            <input class="input_st" id="st_46_b_txt" name="st_46_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="397">
            <input class="input_st" id="st_46_mb_txt" name="st_46_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="398">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_46_dl_txt" name="mg_46_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="252">
            <input class="input_mg" id="mg_46_l_txt" name="mg_46_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="253">
            <input class="input_mg" id="mg_46_ml_txt" name="mg_46_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="254">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_46_dl_txt" name="st_46_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="300">
            <input class="input_st" id="st_46_l_txt" name="st_46_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="301">
            <input class="input_st" id="st_46_ml_txt" name="st_46_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_46();}" tabindex="302">
        </div>

        <div class="BOP_hover_btn" id="BOP_46_dl_btn" onclick="toggle_BOP_46_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_dl(); calc();}">
            <div id="BOP_46_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_46_l_btn" onclick="toggle_BOP_46_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_l(); calc();}">
            <div id="BOP_46_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_46_ml_btn" onclick="toggle_BOP_46_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_46_ml(); calc();}">
            <div id="BOP_46_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_46_dl_btn" onclick="toggle_PI_46_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_dl(); calc();}">
            <div id="PI_46_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_46_l_btn" onclick="toggle_PI_46_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_l(); calc();}">
            <div id="PI_46_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_46_ml_btn" onclick="toggle_PI_46_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_46_ml(); calc();}">
            <div id="PI_46_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_46_l_btn" onclick="toggle_furcation_46_l();">
        
            <div id="furkation_1_46_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_46_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_46_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_46_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_46_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_46_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_46_txt" name="bemerkung_46" type="text" value="" tabindex="232">
        </div>                <div class="tooth_hover_btn" id="tooth_47_btn" onclick="if (event.shiftKey) {clear_data_47(); calc();} else {toggle_tooth_47(); calc();}">31</div>
        
        <div id="tooth_line_47_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_47_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_47_txt" name="beweglichkeit_47" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="439">
        </div>

        <div id="implantat_47_btn" onclick="toggle_implant_47();">
            <div id="implantat_47_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_47_b_image" style="display: none;">
            <img src="./img/implants/4/47b.png" width="62" height="131" alt="">
        </div>
        <div id="implantat_47_l_image" style="display: none;">
            <img src="./img/implants/4/47l.png" width="63" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_47_b_btn" onclick="toggle_furcation_47_b();">
        
            <div id="furkation_1_47_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_47_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_47_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_47_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_47_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_47_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_47_db_btn" onclick="toggle_BOP_47_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_db(); calc();}">
            <div id="BOP_47_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_47_b_btn" onclick="toggle_BOP_47_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_b(); calc();}">
            <div id="BOP_47_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_47_mb_btn" onclick="toggle_BOP_47_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_mb(); calc();}">
            <div id="BOP_47_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_47_db_btn" onclick="toggle_PI_47_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_db(); calc();}">
            <div id="PI_47_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_47_b_btn" onclick="toggle_PI_47_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_b(); calc();}">
            <div id="PI_47_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_47_mb_btn" onclick="toggle_PI_47_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_mb(); calc();}">
            <div id="PI_47_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
                            
        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_47_db_txt" name="mg_47_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="345">
            <input class="input_mg" id="mg_47_b_txt" name="mg_47_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="346">
            <input class="input_mg" id="mg_47_mb_txt" name="mg_47_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="347">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_47_db_txt" name="st_47_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="393">
            <input class="input_st" id="st_47_b_txt" name="st_47_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="394">
            <input class="input_st" id="st_47_mb_txt" name="st_47_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="395">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_47_dl_txt" name="mg_47_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="249">
            <input class="input_mg" id="mg_47_l_txt" name="mg_47_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="250">
            <input class="input_mg" id="mg_47_ml_txt" name="mg_47_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="251">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_47_dl_txt" name="st_47_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="297">
            <input class="input_st" id="st_47_l_txt" name="st_47_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="298">
            <input class="input_st" id="st_47_ml_txt" name="st_47_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_47();}" tabindex="299">
        </div>

        <div class="BOP_hover_btn" id="BOP_47_dl_btn" onclick="toggle_BOP_47_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_dl(); calc();}">
            <div id="BOP_47_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_47_l_btn" onclick="toggle_BOP_47_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_l(); calc();}">
            <div id="BOP_47_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_47_ml_btn" onclick="toggle_BOP_47_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_47_ml(); calc();}">
            <div id="BOP_47_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_47_dl_btn" onclick="toggle_PI_47_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_dl(); calc();}">
            <div id="PI_47_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_47_l_btn" onclick="toggle_PI_47_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_l(); calc();}">
            <div id="PI_47_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_47_ml_btn" onclick="toggle_PI_47_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_47_ml(); calc();}">
            <div id="PI_47_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_47_l_btn" onclick="toggle_furcation_47_l();">
        
            <div id="furkation_1_47_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_47_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_47_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_47_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_47_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_47_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_47_txt" name="bemerkung_47" type="text" value="" tabindex="231">
        </div>                <div class="tooth_hover_btn" id="tooth_48_btn" onclick="if (event.shiftKey) {clear_data_48(); calc();} else {toggle_tooth_48(); calc();}">32</div>
        
        <div id="tooth_line_48_b" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div id="tooth_line_48_l" style="display: none;">
            <img src="./img/svg/line.svg" height="153">
        </div>
        
        <div class="uk_beweglichkeit_input">
            <input class="input_beweglichkeit" id="beweglichkeit_48_txt" name="beweglichkeit_48" type="text" maxlength="1" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_beweglichkeit(event)" tabindex="438">
        </div>

        <div id="implantat_48_btn" onclick="toggle_implant_48();">
            <div id="implantat_48_tab" style="display: none;">
                <img src="./img/svg/implant.svg" height="14" alt="">
            </div>
        </div>
        
        <div id="implantat_48_b_image" style="display: none;">
            <img src="./img/implants/4/48b.png" width="64" height="131" alt="">
        </div>
        <div id="implantat_48_l_image" style="display: none;">
            <img src="./img/implants/4/48l.png" width="68" height="133" alt="">
        </div>

        <div class="furkation_hover_btn" id="furkation_48_b_btn" onclick="toggle_furcation_48_b();">
        
            <div id="furkation_1_48_b_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_48_b_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_48_b_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_48_b" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_48_b" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_48_b" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>

        <div class="BOP_hover_btn" id="BOP_48_db_btn" onclick="toggle_BOP_48_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_db(); calc();}">
            <div id="BOP_48_db_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_48_b_btn" onclick="toggle_BOP_48_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_b(); calc();}">
            <div id="BOP_48_b_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_48_mb_btn" onclick="toggle_BOP_48_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_mb(); calc();}">
            <div id="BOP_48_mb_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_48_db_btn" onclick="toggle_PI_48_db(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_db(); calc();}">
            <div id="PI_48_db_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_48_b_btn" onclick="toggle_PI_48_b(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_b(); calc();}">
            <div id="PI_48_b_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_48_mb_btn" onclick="toggle_PI_48_mb(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_mb(); calc();}">
            <div id="PI_48_mb_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="uk_bukk_mg_input">
            <input class="input_mg" id="mg_48_db_txt" name="mg_48_db" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="342">
            <input class="input_mg" id="mg_48_b_txt" name="mg_48_b" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="343">
            <input class="input_mg" id="mg_48_mb_txt" name="mg_48_mb" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="344">
        </div>
        <div class="uk_bukk_st_input">
            <input class="input_st" id="st_48_db_txt" name="st_48_db" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="390">
            <input class="input_st" id="st_48_b_txt" name="st_48_b" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="391">
            <input class="input_st" id="st_48_mb_txt" name="st_48_mb" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="392">
        </div>

        <div class="uk_ling_mg_input">
            <input class="input_mg" id="mg_48_dl_txt" name="mg_48_dl" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="246">
            <input class="input_mg" id="mg_48_l_txt" name="mg_48_l" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="247">
            <input class="input_mg" id="mg_48_ml_txt" name="mg_48_ml" type="text" maxlength="3" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '' || this.value.substr(this.value.length - 1) === '-' || this.value.length > 3 || this.value.substr(0, 2) === '--' || this.value.substr(1, 1) === '-') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_mg(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="248">
        </div>
        <div class="uk_ling_st_input">
            <input class="input_st" id="st_48_dl_txt" name="st_48_dl" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="294">
            <input class="input_st" id="st_48_l_txt" name="st_48_l" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="295">
            <input class="input_st" id="st_48_ml_txt" name="st_48_ml" type="text" maxlength="2" value="0" onfocus="if (this.value === '0') {this.value = '';}" onblur="if (this.value === '') {this.value = '0';} if (1*this.value > 30) { this.value = '30';}" onclick="this.setSelectionRange(0, this.value.length);" onkeypress="validate_st(event)" oninput="if (this.value != '-') {change_probing_48();}" tabindex="296">
        </div>

        <div class="BOP_hover_btn" id="BOP_48_dl_btn" onclick="toggle_BOP_48_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_dl(); calc();}">
            <div id="BOP_48_dl_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_48_l_btn" onclick="toggle_BOP_48_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_l(); calc();}">
            <div id="BOP_48_l_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="BOP_hover_btn" id="BOP_48_ml_btn" onclick="toggle_BOP_48_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_BOP_48_ml(); calc();}">
            <div id="BOP_48_ml_rectangle" style="display: none;">
                <img src="./img/svg/BOP_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="PI_hover_btn" id="PI_48_dl_btn" onclick="toggle_PI_48_dl(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_dl(); calc();}">
            <div id="PI_48_dl_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_48_l_btn" onclick="toggle_PI_48_l(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_l(); calc();}">
            <div id="PI_48_l_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>
        
        <div class="PI_hover_btn" id="PI_48_ml_btn" onclick="toggle_PI_48_ml(); calc();" onmouseenter="if (event.shiftKey) {toggle_PI_48_ml(); calc();}">
            <div id="PI_48_ml_rectangle" style="display: none;">
                <img src="./img/svg/PI_molar.svg" height="13.85" alt="">
            </div>
        </div>

        <div class="furkation_hover_btn" id="furkation_48_l_btn" onclick="toggle_furcation_48_l();">
        
            <div id="furkation_1_48_l_tab" style="display: none;">
                <img src="./img/svg/furcation_1.svg" height="15" alt="">
            </div>
            <div id="furkation_2_48_l_tab" style="display: none;">
                <img src="./img/svg/furcation_2.svg" height="15" alt="">
            </div>
            <div id="furkation_3_48_l_tab" style="display: none;">
                <img src="./img/svg/furcation_3.svg" height="15" alt="">
            </div>
        
        </div>

        <div id="furkation_1_48_l" style="display: none;">
            <img src="./img/svg/furcation_1.svg" height="17" alt="">
        </div>
        <div id="furkation_2_48_l" style="display: none;">
            <img src="./img/svg/furcation_2.svg" height="17" alt="">
        </div>
        <div id="furkation_3_48_l" style="display: none;">
            <img src="./img/svg/furcation_3.svg" height="17" alt="">
        </div>
        
        <div class="uk_bemerkung_input">
            <input class="input_bemerkung" id="bemerkung_48_txt" name="bemerkung_48" type="text" value="" tabindex="230">
        </div>
                    <svg class="svg_periodontal_chart">
           
        <!-- 1. Quadrant -->
 
            <!-- Bukkal -->
           
            <polygon class="pocket" id="polygon_18_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_18_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_18_b" points="295, 585  332, 585"></polyline>
            
                    <polygon class="pocket" id="polygon_inter_18_17_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_18_17_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_18_17_b" points="332, 585  346, 585"></polyline>

            <polygon class="pocket" id="polygon_17_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_17_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_17_b" points="346, 585  386, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_17_16_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_17_16_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_17_16_b" points="386, 585  397, 585"></polyline>   

            <polygon class="pocket" id="polygon_16_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_16_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_16_b" points="397, 585  451, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_16_15_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_16_15_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_16_15_b" points="451, 585  463, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_15_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_15_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_15_b" points="463, 585  489, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_15_14_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_15_14_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_15_14_b" points="489, 585  504, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_14_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_14_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_14_b" points="504, 585  528, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_14_13_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_14_13_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_14_13_b" points="528, 585  544, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_13_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_13_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_13_b" points="544, 585  570, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_13_12_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_13_12_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_13_12_b" points="570, 585  588, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_12_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_12_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_12_b" points="588, 585  612, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_12_11_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_12_11_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_12_11_b" points="612, 585  628, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_11_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_11_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_11_b" points="628, 585  660, 585"></polyline>
        
            <!-- Palatinal -->

            <polygon class="pocket" id="polygon_18_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_18_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_18_p" points="291, 694  331, 694"></polyline>

                    <polygon class="pocket" id="polygon_inter_18_17_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_18_17_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_18_17_p" points="331, 694  344, 694"></polyline>

            <polygon class="pocket" id="polygon_17_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_17_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_17_p" points="344, 694  383, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_17_16_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_17_16_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_17_16_p" points="383, 694  399, 694"></polyline>   

            <polygon class="pocket" id="polygon_16_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_16_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_16_p" points="399, 694  445, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_16_15_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_16_15_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_16_15_p" points="445, 694  461, 694"></polyline>   

            <polygon class="pocket" id="polygon_15_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_15_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_15_p" points="461, 694  487, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_15_14_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_15_14_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_15_14_p" points="487, 694  504, 694"></polyline>   

            <polygon class="pocket" id="polygon_14_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_14_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_14_p" points="504, 694  529, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_14_13_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_14_13_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_14_13_p" points="529, 694  546, 694"></polyline>   

            <polygon class="pocket" id="polygon_13_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_13_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_13_p" points="546, 694  573, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_13_12_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_13_12_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_13_12_p" points="573, 694  586, 694"></polyline>   

            <polygon class="pocket" id="polygon_12_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_12_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_12_p" points="586, 694  612, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_12_11_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_12_11_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_12_11_p" points="612, 694  627, 694"></polyline>   

            <polygon class="pocket" id="polygon_11_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_11_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_11_p" points="627, 694  658, 694"></polyline>

        <!-- 2. Quadrant -->
            
           <!-- Bukkal -->
           
            <polygon class="pocket" id="polygon_28_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_28_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_28_b" points="1026, 585  1063, 585"></polyline>
            
                    <polygon class="pocket" id="polygon_inter_28_27_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_28_27_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_28_27_b" points="1011, 585  1026, 585"></polyline>

            <polygon class="pocket" id="polygon_27_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_27_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_27_b" points="972, 585  1011, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_27_26_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_27_26_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_27_26_b" points="961, 585  972, 585"></polyline>   

            <polygon class="pocket" id="polygon_26_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_26_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_26_b" points="907, 585  961, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_26_25_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_26_25_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_26_25_b" points="895, 585  907, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_25_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_25_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_25_b" points="869, 585  895, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_25_24_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_25_24_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_25_24_b" points="855, 585  869, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_24_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_24_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_24_b" points="829, 585  855, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_24_23_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_24_23_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_24_23_b" points="815, 585  829, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_23_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_23_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_23_b" points="787, 585  815, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_23_22_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_23_22_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_23_22_b" points="770, 585  787, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_22_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_22_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_22_b" points="746, 585  770, 585"></polyline>

                    <polygon class="pocket" id="polygon_inter_22_21_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_22_21_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_22_21_b" points="729, 585  746, 585"></polyline>   
            
            <polygon class="pocket" id="polygon_21_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_21_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_21_b" points="698, 585  729, 585"></polyline>
        
            <!-- Palatinal -->

            <polygon class="pocket" id="polygon_28_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_28_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_28_p" points="1028, 694  1067, 694"></polyline>

                    <polygon class="pocket" id="polygon_inter_28_27_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_28_27_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_28_27_p" points="1015, 694  1028, 694"></polyline>

            <polygon class="pocket" id="polygon_27_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_27_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_27_p" points="976, 694  1015, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_27_26_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_27_26_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_27_26_p" points="960, 694  976, 694"></polyline>   

            <polygon class="pocket" id="polygon_26_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_26_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_26_p" points="912, 694  960, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_26_25_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_26_25_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_26_25_p" points="897, 694  912, 694"></polyline>   

            <polygon class="pocket" id="polygon_25_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_25_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_25_p" points="871, 694  897, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_25_24_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_25_24_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_25_24_p" points="854, 694  871, 694"></polyline>   

            <polygon class="pocket" id="polygon_24_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_24_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_24_p" points="829, 694  854, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_24_23_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_24_23_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_24_23_p" points="813, 694  829, 694"></polyline>   

            <polygon class="pocket" id="polygon_23_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_23_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_23_p" points="785, 694  813, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_23_22_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_23_22_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_23_22_p" points="772, 694  785, 694"></polyline>   

            <polygon class="pocket" id="polygon_22_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_22_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_22_p" points="746, 694  772, 694"></polyline>   

                    <polygon class="pocket" id="polygon_inter_22_21_p" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_22_21_p" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_22_21_p" points="731, 694  746, 694"></polyline>   

            <polygon class="pocket" id="polygon_21_p" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_21_p" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_21_p" points="700, 694  731, 694"></polyline>

        <!-- 3. Quadrant -->

            <!-- Bukkal -->
           
            <polygon class="pocket" id="polygon_38_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_38_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_38_b" points="1016, 1310  1061, 1310"></polyline>
            
                    <polygon class="pocket" id="polygon_inter_38_37_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_38_37_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_38_37_b" points="999, 1310  1016, 1310"></polyline>

            <polygon class="pocket" id="polygon_37_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_37_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_37_b" points="952, 1310  999, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_37_36_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_37_36_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_37_36_b" points="936, 1310  952, 1310"></polyline>   

            <polygon class="pocket" id="polygon_36_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_36_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_36_b" points="887, 1310  936, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_36_35_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_36_35_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_36_35_b" points="864, 1310  887, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_35_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_35_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_35_b" points="845, 1310  864, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_35_34_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_35_34_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_35_34_b" points="824, 1310  845, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_34_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_34_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_34_b" points="805, 1310  824, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_34_33_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_34_33_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_34_33_b" points="787, 1310  805, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_33_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_33_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_33_b" points="766, 1310  787, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_33_32_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_33_32_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_33_32_b" points="748, 1310  766, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_32_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_32_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_32_b" points="728, 1310  748, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_32_31_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_32_31_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_32_31_b" points="714, 1310  728, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_31_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_31_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_31_b" points="695, 1310  714, 1310"></polyline>
        
            <!-- Lingual -->

            <polygon class="pocket" id="polygon_38_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_38_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_38_l" points="1012, 1195  1061, 1195"></polyline>

                    <polygon class="pocket" id="polygon_inter_38_37_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_38_37_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_38_37_l" points="995, 1195  1012, 1195"></polyline>

            <polygon class="pocket" id="polygon_37_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_37_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_37_l" points="947, 1195  995, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_37_36_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_37_36_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_37_36_l" points="932, 1195  947, 1195"></polyline>   

            <polygon class="pocket" id="polygon_36_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_36_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_36_l" points="887, 1195  932, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_36_35_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_36_35_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_36_35_l" points="868, 1195  887, 1195"></polyline>   

            <polygon class="pocket" id="polygon_35_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_35_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_35_l" points="845, 1195  868, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_35_34_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_35_34_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_35_34_l" points="827, 1195  845, 1195"></polyline>   

            <polygon class="pocket" id="polygon_34_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_34_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_34_l" points="804, 1195  827, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_34_33_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_34_33_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_34_33_l" points="787, 1195  804, 1195"></polyline>   

            <polygon class="pocket" id="polygon_33_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_33_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_33_l" points="767, 1195  787, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_33_32_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_33_32_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_33_32_l" points="751, 1195  767, 1195"></polyline>   

            <polygon class="pocket" id="polygon_32_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_32_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_32_l" points="733, 1195  751, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_32_31_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_32_31_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_32_31_l" points="715, 1195  733, 1195"></polyline>   

            <polygon class="pocket" id="polygon_31_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_31_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_31_l" points="698, 1195  715, 1195"></polyline>           
           
           
        <!-- 4. Quadrant -->

            <!-- Bukkal -->
           
            <polygon class="pocket" id="polygon_48_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_48_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_48_b" points="296, 1310  342, 1310"></polyline>
            
                    <polygon class="pocket" id="polygon_inter_48_47_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_48_47_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_48_47_b" points="342, 1310  358, 1310"></polyline>

            <polygon class="pocket" id="polygon_47_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_47_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_47_b" points="358, 1310  406, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_47_46_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_47_46_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_47_46_b" points="406, 1310  422, 1310"></polyline>   

            <polygon class="pocket" id="polygon_46_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_46_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_46_b" points="422, 1310  469, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_46_45_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_46_45_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_46_45_b" points="469, 1310  492, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_45_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_45_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_45_b" points="492, 1310  513, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_45_44_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_45_44_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_45_44_b" points="513, 1310  533, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_44_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_44_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_44_b" points="533, 1310  553, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_44_43_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_44_43_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_44_43_b" points="553, 1310  570, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_43_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_43_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_43_b" points="570, 1310  592, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_43_42_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_43_42_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_43_42_b" points="592, 1310  610, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_42_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_42_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_42_b" points="610, 1310  629, 1310"></polyline>

                    <polygon class="pocket" id="polygon_inter_42_41_b" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_42_41_b" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_42_41_b" points="629, 1310  643, 1310"></polyline>   
            
            <polygon class="pocket" id="polygon_41_b" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_41_b" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_41_b" points="643, 1310  662, 1310"></polyline>
        
            <!-- Lingual -->

            <polygon class="pocket" id="polygon_48_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_48_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_48_l" points="297, 1195  346, 1195"></polyline>

                    <polygon class="pocket" id="polygon_inter_48_47_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_48_47_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_48_47_l" points="346, 1195  362, 1195"></polyline>

            <polygon class="pocket" id="polygon_47_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_47_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_47_l" points="362, 1195  410, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_47_46_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_47_46_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_47_46_l" points="410, 1195  425, 1195"></polyline>   

            <polygon class="pocket" id="polygon_46_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_46_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_46_l" points="425, 1195  469, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_46_45_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_46_45_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_46_45_l" points="469, 1195  489, 1195"></polyline>   

            <polygon class="pocket" id="polygon_45_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_45_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_45_l" points="489, 1195  513, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_45_44_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_45_44_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_45_44_l" points="513, 1195  531, 1195"></polyline>   

            <polygon class="pocket" id="polygon_44_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_44_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_44_l" points="531, 1195  553, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_44_43_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_44_43_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_44_43_l" points="553, 1195  570, 1195"></polyline>   

            <polygon class="pocket" id="polygon_43_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_43_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_43_l" points="570, 1195  590, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_43_42_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_43_42_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_43_42_l" points="590, 1195  607, 1195"></polyline>   

            <polygon class="pocket" id="polygon_42_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_42_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_42_l" points="607, 1195  625, 1195"></polyline>   

                    <polygon class="pocket" id="polygon_inter_42_41_l" points=""></polygon>
                    <polyline class="attachment_level" id="polyline_an_inter_42_41_l" points=""></polyline>
                    <polyline class="gingival_margin" id="polyline_mg_inter_42_41_l" points="625, 1195  642, 1195"></polyline>   

            <polygon class="pocket" id="polygon_41_l" points=""></polygon>
            <polyline class="attachment_level" id="polyline_an_41_l" points=""></polyline>
            <polyline class="gingival_margin" id="polyline_mg_41_l" points="642, 1195  661, 1195"></polyline>      

        </svg>
        

        <div class="menu_button" id="menu_button_print" onclick="window.print();" type="button"><img src="./img/svg/fa/print-solid.svg" height="14"></div>
        <!-- <div class="menu_button" id="menu_alert" style="left: 250px; width: auto;">
            <p>Please note: There is a known printing issue with recent updates of Google Chrome and Microsoft Edge, while no errors were found with Firefox and Apple Safari.  Please use the latter browsers while the bug is being fixed, or use the plain form instead located at: https://www.periodontalchart-online.com/uk/periodontalchart.com. Thank you for using our online perio tools.  :-)</p>
        </div> -->
        <!-- <div class="menu_button" id="menu_button_analysis" onclick="open_analysis();" type="button"><img src="./img/svg/fa/chart-bar-solid.svg" height="14"></div>
        <div class="menu_button" id="menu_button_settings" onclick="open_settings();" type="button"><img src="./img/svg/fa/cog-solid.svg" height="14"></div> -->

        <div class="modal" id="modal_analysis">
  <div class="modal-content">
    <span class="close" onclick="close_analysis();">×</span>
    <p>Analyse der Daten aus dem Parodontalstatus...</p>
  </div>
</div>        <div class="modal" id="modal_settings">
  <div class="modal-content">
    <span class="close" onclick="close_settings();">×</span>
    <p>Einstellungen für das Formular...</p>
  </div>
</div></form>

</div>
    
<script type="text/javascript" src="./common/js/tabindex/default_tabindex.js"></script>
<script type="text/javascript" src="./common/js/calc/calc.js"></script>
<script type="text/javascript" src="./common/js/select_row.js"></script>
<script type="text/javascript" src="./common/js/activate_row.js"></script>
<script type="text/javascript" src="./common/js/open_modal.js"></script>

<script type="text/javascript" src="./common/js/1/18.js"></script>
<script type="text/javascript" src="./common/js/1/17.js"></script>
<script type="text/javascript" src="./common/js/1/16.js"></script>
<script type="text/javascript" src="./common/js/1/15.js"></script>    
<script type="text/javascript" src="./common/js/1/14.js"></script>
<script type="text/javascript" src="./common/js/1/13.js"></script>
<script type="text/javascript" src="./common/js/1/12.js"></script>
<script type="text/javascript" src="./common/js/1/11.js"></script>

<script type="text/javascript" src="./common/js/2/21.js"></script>
<script type="text/javascript" src="./common/js/2/22.js"></script>
<script type="text/javascript" src="./common/js/2/23.js"></script>
<script type="text/javascript" src="./common/js/2/24.js"></script>
<script type="text/javascript" src="./common/js/2/25.js"></script>
<script type="text/javascript" src="./common/js/2/26.js"></script>
<script type="text/javascript" src="./common/js/2/27.js"></script>
<script type="text/javascript" src="./common/js/2/28.js"></script>

<script type="text/javascript" src="./common/js/3/38.js"></script>
<script type="text/javascript" src="./common/js/3/37.js"></script>
<script type="text/javascript" src="./common/js/3/36.js"></script>
<script type="text/javascript" src="./common/js/3/35.js"></script>
<script type="text/javascript" src="./common/js/3/34.js"></script>
<script type="text/javascript" src="./common/js/3/33.js"></script>
<script type="text/javascript" src="./common/js/3/32.js"></script>
<script type="text/javascript" src="./common/js/3/31.js"></script>

<script type="text/javascript" src="./common/js/4/41.js"></script>
<script type="text/javascript" src="./common/js/4/42.js"></script>
<script type="text/javascript" src="./common/js/4/43.js"></script>
<script type="text/javascript" src="./common/js/4/44.js"></script>
<script type="text/javascript" src="./common/js/4/45.js"></script>
<script type="text/javascript" src="./common/js/4/46.js"></script>
<script type="text/javascript" src="./common/js/4/47.js"></script>
<script type="text/javascript" src="./common/js/4/48.js"></script>



</body></html>