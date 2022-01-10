<?php
require_once("../../config.php");
require_once('../../classes/quote.php');

$jsonInput = json_decode(file_get_contents('php://input'));

$quote = Quote::fromID($jsonInput->quoteID);
$quote->remark = $jsonInput->remark;
$json = array();
if($quote->update()){
    $json[]=array(
        "response"=>"true"
    );
}else{
    $json[]=array(
        "response"=>"false"
    );
}

echo json_encode($json[0]);