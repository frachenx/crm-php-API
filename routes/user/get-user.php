<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$id = $_GET['id'];

$user = User::fromID($id);

if($user!=false){
    echo json_encode($user);
}else{
    echo json_encode(new User());
}