<?php
require_once('../config.php');
require_once('../classes/user.php');
require_once('../classes/login.php');
$jsonInput = json_decode(file_get_contents('php://input'));

$result = User::login($jsonInput->email,$jsonInput->password);

if(!$result){
    $json = array();
    $json[]= array(
        "response"=> "false"
    );
    echo  json_encode($json[0]);
}else{
    $login =  new Login();
    $login->userID = $result;
    $login->loginDate = date('Y-m-d H:i:s');
    $login->IP = $_SERVER['REMOTE_ADDR'];
    $login->mac = exec('getmac');
    $login->add();

    $json = array();
    $json[]= array(
        "response"=> $result
    );
    echo  json_encode($json[0]);
}
