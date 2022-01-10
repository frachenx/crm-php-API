<?php
require_once('../../config.php');
require_once('../../classes/ticket.php');

$result = Ticket::getAllTickets();

if(!$result){
    echo  json_encode(new Ticket());
}else{
    echo json_encode($result);
}