<?php
require_once '../core/Connection.php';

$db = new DatabaseConnection();
for($i = 1; $i <= 1000; $i++){
    echo $db->insert('medicines', 'description', "'Acetaminofen {$i}ml'");
}