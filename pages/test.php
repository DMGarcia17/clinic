<?php
    require_once '../core/Connection.php';
    $db = new DatabaseConnection();

    $res = $db->blankect_query('files a', 'a.ID, a.name, (select b.extension from file_extensions b where b.ID = a.extension) extension');
    $formated = array('data' => $res);
    //$arr = array('a' => 1, 'b' => 2, 'c' => 3, 'd' => 4, 'e' => 5);
    echo json_encode($formated);