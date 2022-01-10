<?php
require_once('../../config.php');
require_once('../../classes/admin.php');

$jsonInput = json_decode(file_get_contents('php://input'));
$admin =  Admin::fromID($jsonInput->adminID);
$json = array();
if ($admin != false) {
    if(password_verify($jsonInput->password,$admin->password)){
        $json[0] = array(
            "response" => "true"
        );
    } else {
        $json[0] = array(
            "response" => "false"
        );
    }
}else{
    $json[0] = array(
        "response" => "false"
    );
}

echo json_encode($json[0]);
