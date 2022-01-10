<?php
require_once('../../config.php');
require_once('../../classes/quote.php');

$result = Quote::getQuotes();

if(!$result){
    echo json_encode(new Quote());
}else{
    echo json_encode($result);
}