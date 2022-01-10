<?php
require_once('../../config.php');
require_once('../../classes/admin.php');

$jsonInput =  json_decode(file_get_contents('php://input'));
$admin =  Admin::fromID($jsonInput->adminID);

$admin->password = password_hash($jsonInput->password,PASSWORD_BCRYPT);
$result=$admin->update();

$json = array();

if($result){
    $json[]=array(
        "response"=>"true"
    );
}else{
    $json[]=array(
        "response"=>"false"
    );
}

echo json_encode($json[0]);
