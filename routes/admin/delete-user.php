<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$result = User::deleteFromID($_GET['id']);
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