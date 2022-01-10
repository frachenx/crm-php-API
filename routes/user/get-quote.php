<?php
require_once('../../config.php');
require_once('../../classes/quote.php');

$jsonInput =  json_decode(file_get_contents('php://input'));

// echo json_encode($jsonInput);
// exit();

$quote =  new Quote();

// public $id=0,$name="",$email="",$contact="",$company="",$webDesign=0,$cms=0,$seo=0,$smo=0,$staticWeb=0,$dynamicWeb=0,$flashWeb=0,$domainReg=0,$webHosting=0,$webMaintenance=0,$ecomm=0,$animation=0,$payment=0,$logo=0,$dashboard=0,$openSource=0,$newsLetter=0,$other=0,$query="",$remark,$postDate,$status;

$quote->id = $jsonInput->id;
$quote->name = $jsonInput->name;
$quote->email = $jsonInput->email;
$quote->contact = $jsonInput->contact;
$quote->company = $jsonInput->company;
$quote->webDesign = $jsonInput->webDesign;
$quote->cms = $jsonInput->cms;
$quote->seo = $jsonInput->seo;
$quote->smo = $jsonInput->smo;
$quote->staticWeb = $jsonInput->staticWeb;
$quote->dynamicWeb = $jsonInput->dynamicWeb;
$quote->flashWeb = $jsonInput->flashWeb;
$quote->domainReg = $jsonInput->domainReg;
$quote->webHosting = $jsonInput->webHosting;
$quote->webMaintenance = $jsonInput->webMaintenance;
$quote->ecomm = $jsonInput->ecomm;
$quote->animation = $jsonInput->animation;
$quote->payment = $jsonInput->payment;
$quote->logo = $jsonInput->logo;
$quote->dashboard = $jsonInput->dashboard;
$quote->openSource = $jsonInput->openSource;
$quote->newsLetter = $jsonInput->newsLetter;
$quote->other = $jsonInput->other;
$quote->query = $jsonInput->query;
$quote->remark = $jsonInput->remark;
$quote->postDate = date('Y-m-d h:i:s');
$quote->status = $jsonInput->status;

$json = array();
if($quote->add()){
    $json[]=array(
        "response"=>"true"
    );
}else{
    $json[]=array(
        "response"=>"false"
    );
}

echo json_encode($json[0]);