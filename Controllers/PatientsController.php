<?php
require_once '../core/Connection.php';
function save($id,
                $firstName,
                $secondName,
                $firstSurname,
                $secondSurname,
                $phoneNumber,
                $cellphoneNumber,
                $address,
                $city,
                $state,
                $postalCode,
                $occupation,
                $height,
                $weight,
                $birthday,
                $gender,
                $numIdPatient,
                $emergencyCall,
                $related,
                $phoneEmergency,
                $cellphoneEmergency,
                $filledBy,
                $relatedFb,
                $doctorsCare,
                $doctorsName,
                $doctorsPhone,
                $doctorsAddress,
                $doctorsCity,
                $doctorsZip,
                $healthyPatient,
                $stableHealth,
                $doctorsCondition,
                $examsDate,
                $pastYears,
                $diseasePast,
                $takenMedicine,
                $medicine,
                $antibiotics,
                $antibioticsDoctor,
                $antibioticsTelephone,
                $diseaseExtra,
                $comments,
                $isAllergic,
                $allergies){
    $db = new DatabaseConnection();
    if ($id == null || $id == "") {
        $res = $db->insert('patients', 
                            'first_name, 
                            second_name, 
                            first_surname, 
                            second_surname, 
                            phone_number, 
                            cellphone_number, 
                            address, 
                            city, 
                            state, 
                            postal_code, 
                            occupation, 
                            height, 
                            weight, 
                            birthday, 
                            gender, 
                            num_id_patient, 
                            emergency_call, 
                            related, 
                            phone_emergency, 
                            cellphone_emergency, 
                            filled_by, 
                            related_fb, 
                            doctors_care, 
                            doctors_name, 
                            doctors_phone, 
                            doctors_address, 
                            doctors_city, 
                            doctors_zip, 
                            healthy_patients, 
                            stable_health, 
                            doctors_condition, 
                            exams_date, 
                            past_years, 
                            disease_past, 
                            taken_medicine, 
                            medicine, 
                            antibiotics, 
                            antibiotics_doctor, 
                            antibiotics_telephone, 
                            disease_extra, 
                            comments,
                            is_allergic,
                            allergies',"'{$firstName}', 
                            '{$secondName}', 
                            '{$firstSurname}', 
                            '{$secondSurname}', 
                            '{$phoneNumber}', 
                            '{$cellphoneNumber}', 
                            '{$address}', 
                            '{$city}', 
                            '{$state}', 
                            '{$postalCode}', 
                            '{$occupation}', 
                            if('{$height}'='', null, '{$height}'), 
                            if('{$weight}'='', null, '{$weight}'), 
                            if('{$birthday}'='', null, '{$birthday}'), 
                            '{$gender}', 
                            '{$numIdPatient}', 
                            '{$emergencyCall}', 
                            '{$related}', 
                            '{$phoneEmergency}', 
                            '{$cellphoneEmergency}', 
                            '{$filledBy}', 
                            '{$relatedFb}', 
                            '{$doctorsCare}', 
                            '{$doctorsName}', 
                            '{$doctorsPhone}', 
                            '{$doctorsAddress}', 
                            '{$doctorsCity}', 
                            '{$doctorsZip}', 
                            '{$healthyPatient}', 
                            '{$stableHealth}', 
                            '{$doctorsCondition}', 
                            if('{$examsDate}'='', null, '{$examsDate}'), 
                            '{$pastYears}', 
                            '{$diseasePast}', 
                            '{$takenMedicine}', 
                            '{$medicine}', 
                            '{$antibiotics}', 
                            '{$antibioticsDoctor}', 
                            '{$antibioticsTelephone}', 
                            '{$diseaseExtra}', 
                            '{$comments}', 
                            '{$isAllergic}', 
                            '{$allergies}'");
    }else{
        $res = $db->update('patients', "cod_patient={$id}", 
                                        "first_name='{$firstName}', 
                                        second_name='{$secondName}', 
                                        first_surname='{$firstSurname}', 
                                        second_surname='{$secondSurname}', 
                                        phone_number='{$phoneNumber}', 
                                        cellphone_number='{$cellphoneNumber}', 
                                        address='{$address}', 
                                        city='{$city}', 
                                        state='{$state}', 
                                        postal_code='{$postalCode}', 
                                        occupation='{$occupation}', 
                                        height=if('{$height}'='', null, '{$height}'), 
                                        weight=if('{$weight}'='', null, '{$weight}'), 
                                        birthday=if('{$birthday}'='', null, '{$birthday}'), 
                                        gender='{$gender}', 
                                        num_id_patient='{$numIdPatient}', 
                                        emergency_call='{$emergencyCall}', 
                                        related='{$related}', 
                                        phone_emergency='{$phoneEmergency}', 
                                        cellphone_emergency='{$cellphoneEmergency}', 
                                        filled_by='{$filledBy}', 
                                        related_fb='{$relatedFb}', 
                                        doctors_care='{$doctorsCare}', 
                                        doctors_name='{$doctorsName}', 
                                        doctors_phone='{$doctorsPhone}', 
                                        doctors_address='{$doctorsAddress}', 
                                        doctors_city='{$doctorsCity}', 
                                        doctors_zip='{$doctorsZip}', 
                                        healthy_patients='{$healthyPatient}', 
                                        stable_health='{$stableHealth}', 
                                        doctors_condition='{$doctorsCondition}', 
                                        exams_date=if('{$examsDate}'='', null, '{$examsDate}'), 
                                        past_years='{$pastYears}', 
                                        disease_past='{$diseasePast}', 
                                        taken_medicine='{$takenMedicine}', 
                                        medicine='{$medicine}', 
                                        antibiotics='{$antibiotics}', 
                                        antibiotics_doctor='{$antibioticsDoctor}', 
                                        antibiotics_telephone='{$antibioticsTelephone}', 
                                        disease_extra='{$diseaseExtra}', 
                                        comments='{$comments}', 
                                        is_allergic='{$isAllergic}', 
                                        allergies='{$allergies}'");
        $res = $id;
    }
    return $res;
}

function load($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('patients p', 'p.cod_patient, p.first_name, p.second_name, p.first_surname, p.second_surname, p.phone_number, p.cellphone_number, p.address, p.city, p.state, p.postal_code, p.occupation, p.height, p.weight, p.birthday, p.gender, p.num_id_patient, p.emergency_call, p.related, p.phone_emergency, p.cellphone_emergency, p.filled_by, p.related_fb, p.doctors_care, p.doctors_name, p.doctors_phone, p.doctors_address, p.doctors_city, p.doctors_state, p.doctors_zip, p.healthy_patients, p.stable_health, p.doctors_condition, p.exams_date, p.past_years, p.disease_past, p.taken_medicine, p.medicine, p.antibiotics, p.antibiotics_doctor, p.antibiotics_telephone, p.disease_extra, p.comments, p.is_allergic, p.allergies', 'cod_patient='.$id);
    echo json_encode($res);
}

function loadMQ($id){
    $db = new DatabaseConnection();
    $res = $db->filtered_query('answer_mq', 'cod_question, answer', 'cod_patient='.$id);
    echo json_encode($res);
}

function delete($id){
    $db = new DatabaseConnection();
    $res = $db->delete('patients', 'cod_patient='.$id);
    echo json_encode($res);
}

function query(){
    $db = new DatabaseConnection();
    $res = $db->blankect_query("patients p", "p.cod_patient, concat_ws(' ', p.first_name, p.second_name, p.first_surname, p.second_surname) name, (select x.reason from appointment x where x.cod_patient = p.cod_patient and x.cod_appointment  = (select max(c.cod_appointment) from appointment c where c.cod_patient = x.cod_patient)) last_reason, (select max(c.visited_on) from appointment c where c.cod_patient = p.cod_patient) last_visit");
    $formated = array('data' => $res);
    echo json_encode($formated);
}

function insertQuestions($id, $printed){
    $db = new DatabaseConnection();
    $res = $db->delete('answer_mq', 'cod_patient='.$id);
    foreach(explode(',', $printed) as $val){
        $res = $db->insert('answer_mq', 'cod_patient, cod_question, answer', "'{$id}', '{$val}', '{$_POST[$val]}'");
    }
}

$key="";
if (isset($_POST['function'])){
    $key=$_POST['function'];
}

switch ($key){
    case 'sp':
        //reOrder($_POST['ID'], $_POST['order']);
        $result = save($_POST['ID'],
        $_POST['firstName'],
        $_POST['secondName'],
        $_POST['firstSurname'],
        $_POST['secondSurname'],
        $_POST['phoneNumber'],
        $_POST['cellphoneNumber'],
        $_POST['address'],
        $_POST['city'],
        $_POST['state'],
        $_POST['postalCode'],
        $_POST['occupation'],
        $_POST['height'],
        $_POST['weight'],
        $_POST['birthday'],
        $_POST['gender'],
        $_POST['numIdPatient'],
        $_POST['emergencyCall'],
        $_POST['related'],
        $_POST['phoneEmergency'],
        $_POST['cellphoneEmergency'],
        $_POST['filledBy'],
        $_POST['relatedFb'],
        $_POST['doctorsCare'],
        $_POST['doctorsName'],
        $_POST['doctorsPhone'],
        $_POST['doctorsAddress'],
        $_POST['doctorsCity'],
        $_POST['doctorsZip'],
        $_POST['healthyPatient'],
        $_POST['stableHealth'],
        $_POST['doctorsCondition'],
        $_POST['examsDate'],
        $_POST['pastYears'],
        $_POST['diseasePast'],
        $_POST['takenMedicine'],
        $_POST['medicine'],
        $_POST['antibiotics'],
        $_POST['antibioticsDoctor'],
        $_POST['antibioticsTelephone'],
        $_POST['diseaseExtra'],
        $_POST['comments'],
        $_POST['isAllergic'],
        $_POST['allergies']);
        if($_POST['printed'] != 'N/A'){
            insertQuestions($result, $_POST['printed']);
        }
        echo $result;
        break;
    case 'ep':
        load($_POST['ID']);
        break;
    case 'dp':
        delete($_POST['ID']);
        break;
    case 'lp':
        loadMQ($_POST['ID']);
        break;
    default:
        query();
}