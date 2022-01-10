<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$jsonInput = json_decode(file_get_contents('php://input'));

$user = User::fromID($jsonInput->id);
// public $id, $address="", $email="",$altEmail="", $gender="", $contact="", $name="", $password="",$createdDate;
$json = array();

if($user!=false){
    $user->address = $jsonInput->address;
    $user->email = $jsonInput->email;
    $user->altEmail = $jsonInput->altEmail;
    $user->gender = $jsonInput->gender;
    $user->contact = $jsonInput->contact;
    $user->name = $jsonInput->name;

    if($user->update()){
        $json[0]=array(
            "response"=>"true"
        );
    }else{
        $json[0]=array(
            "response"=>"false"
        );
    }
}else{
    $json[0]=array(
        "response"=>"false"
    );
}

echo json_encode($json[0]);
