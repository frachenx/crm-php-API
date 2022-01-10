<?php
require_once('../config.php');
require_once('../classes/admin.php');
$jsonInput = json_decode(file_get_contents('php://input'));
$adminID = Admin::login($jsonInput->name,$jsonInput->password);
$json = array();
if(!$adminID){
    $json[]=array(
        "response"=> "false"
    );
}else{
    $json[] = array(
        "response"=> $adminID
    );
}

echo json_encode($json[0]);