<?php
require_once('../../config.php');
require_once('../../classes/user.php');

$result = User::getUsers();
if(!$result){
    echo json_encode(new User());
}else{
    echo json_encode($result);
}
