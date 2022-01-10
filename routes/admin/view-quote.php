<?php
require_once('../../config.php');
require_once('../../classes/quote.php');

$quote = Quote::fromID($_GET['id']);

if(!$quote){
    echo json_encode(new Quote());
}else{
    echo json_encode($quote);
}

