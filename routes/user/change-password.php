<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$jsonInput = json_decode(file_get_contents("php://input"));

$user = User::fromID($jsonInput->userID);

$json=array();
if($user!=false){
    if($user->changePassword(password_hash($jsonInput->password,PASSWORD_BCRYPT))){
        $json[] =array(
            "response"=>"true"
        );
    }else{
        $json[] =array(
            "response"=>"true"
        );
    }
}else{
    $json[] =array(
        "response"=>"true"
    );
}

echo json_encode($json[0]);