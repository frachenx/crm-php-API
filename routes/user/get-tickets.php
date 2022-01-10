<?php
require_once('../../config.php');
require_once('../../classes/user.php');
require_once('../../classes/ticket.php');

$user = User::fromID($_GET['id']);

$json = array();

if($user!=false){
    $tickets = Ticket::getTickets($user->email);
    if($tickets!=false){
        $json = $tickets;
    }else{
        $json[] =array(
            new Ticket()
        );
    }
}else{
    $json[] =array(
        new Ticket()
    );
}

echo json_encode($json);