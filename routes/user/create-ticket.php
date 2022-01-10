<?php
require_once('../../config.php');
require_once('../../classes/ticket.php');

$jsonInput =  json_decode(file_get_contents('php://input'));
$ticket =  new Ticket();

$ticket->title = $jsonInput->title;
$ticket->task = $jsonInput->task;
$ticket->prio = $jsonInput->prio;
$ticket->description = $jsonInput->description;
$ticket->email = $jsonInput->email;


$json = array();
if ($ticket->add()){
    $json[]=array(
        "response"=>"true"
    );
}else{
    $json[]=array(
        "response"=>"false"
    );
}

echo json_encode($json[0]);


