<?php
require_once '../core/Connection.php';
function save($id){
    $db = new DatabaseConnection();
    session_start();
    
    if ($id == null) {
        $res = $db->insert('appointment', 'cod_patient, reason, comments, diagnosis_resume, treatment, description, disability_days, visited_on, next_appointment, cod_clinic', "'{$_POST['patient']}', '{$_POST['reason']}', '{$_POST['comments']}', '{$_POST['diagnosisResume']}', '{$_POST['treatment']}', '{$_POST['description']}', if('{$_POST['disabilityDays']}'='', null, '{$_POST['disabilityDays']}'), STR_TO_DATE('{$_POST['visitedOn']}', '%Y-%m-%dT%T:%i'), STR_TO_DATE('{$_POST['nextAppointment']}', '%Y-%m-%dT%T:%i'), '{$_SESSION['codClinic']}'");
        $res .= '|';
        $res .= $db->update('patients', "cod_patient='{$_POST['patient']}'", "systemic_diagnosis='{$_POST['systemicDiagnosis']}'");
    }else{
        $res = $db->update('appointment', "cod_appointment={$_POST['ID']}", "cod_patient='{$_POST['patient']}', reason='{$_POST['reason']}', comments='{$_POST['comments']}', diagnosis_resume='{$_POST['diagnosisResume']}', treatment='{$_POST['treatment']}', description='{$_POST['description']}', disability_days=if('{$_POST['disabilityDays']}'='', null, '{$_POST['disabilityDays']}'), visited_on=STR_TO_DATE('{$_POST['visitedOn']}', '%Y-%m-%dT%T:%i'), next_appointment=STR_TO_DATE('{$_POST['nextAppointment']}', '%Y-%m-%dT%T:%i')");
        $res = $db->update('patients', "cod_patient='{$_POST['patient']}'", "systemic_diagnosis='{$_POST['systemicDiagnosis']}'");
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('appointment a', 
                                "(select concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name from patients p where p.cod_patient = a.cod_patient)name, 
                                (select p.systemic_diagnosis from patients p where p.cod_patient = a.cod_patient) systemic_diagnosis, 
                                (select
                                    group_concat(m.medicine SEPARATOR', ') medicines
                                from prescriptions p 
                                    inner join mpp m on p.cod_prescription = m.cod_prescription
                                where
                                    p.cod_appointment =a.cod_appointment) medicines, 
                                a.cod_appointment, 
                                a.cod_patient, 
                                a.reason, 
                                a.comments, 
                                a.diagnosis_resume, 
                                a.treatment, 
                                a.description, 
                                a.disability_days, 
                                a.visited_on, 
                                next_appointment", 
                                'cod_appointment='.$id);
    echo json_encode($res);
}

function loadName($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('patients p', "concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name", 'cod_patient='.$id);
    echo json_encode($res);
}

function loadSystemicDiagnosis($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('patients p', "systemic_diagnosis", 'cod_patient='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('appointment', 'cod_appointment='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankectOquery('appointment a', "a.cod_appointment, (select concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name from patients p where cod_patient = a.cod_patient)name,a.reason, diagnosis_resume, a.visited_on, a.disability_days, a.cod_patient", 'visited_on desc');
    $formated = array('data' => $res);
    echo json_encode($formated);
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sa':
        echo save($_POST['ID']);
        break;
    case 'ea':
        load($_POST['ID']);
        break;
    case 'fa':
        loadName($_POST['ID']);
        break;
    case 'da':
        delete($_POST['ID']);
        break;
    case 'lsp':
        loadSystemicDiagnosis($_POST['ID']);
        break;
    default:
        query();
}