<?php
require_once('../../config.php');
require_once('../../classes/ticket.php');

$ticket = Ticket::fromID($_GET['id']);

$result = new Ticket();
if(!$ticket){
    echo json_encode($result);
}else{
    echo json_encode($ticket);
}