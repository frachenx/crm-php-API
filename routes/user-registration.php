<?php
require_once('../config.php');
require_once('../classes/user.php');

$jsonInput = json_decode(file_get_contents('php://input'));

$user =  new User();
$user->name=$jsonInput->name;
$user->email=$jsonInput->email;
$user->password=password_hash($jsonInput->password,PASSWORD_BCRYPT);
$user->gender=$jsonInput->gender;
$user->contact=$jsonInput->contact;

$result = $user->register();
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
