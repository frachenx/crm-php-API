<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$jsonInput = json_decode(file_get_contents('php://input'));
$user =  User::fromID($jsonInput->userID);
$json = array();
if ($user != false) {
    if(password_verify($jsonInput->password,$user->password)){
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
