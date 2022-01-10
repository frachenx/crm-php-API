<?php
require_once('../../config.php');
require_once('../../classes/ticket.php');

$jsonInput = json_decode(file_get_contents('php://input'));
// echo  json_encode($jsonInput);
// exit();
$ticket = Ticket::fromID($jsonInput->ticketID);

$json=array();
if(!$ticket){
    $json[] = array(
        "response"=>"false"
    );
}else{
    $ticket->adminRemark=$jsonInput->remark;
    if($ticket->addRemark()){
        $json[] = array(
            "response"=>"true"
        );
    }else{
        $json[] = array(
            "response"=>"false"
        );
    }
}

echo json_encode($json[0]);