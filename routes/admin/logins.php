<?php
require_once('../../config.php');
require_once('../../classes/login.php');

echo json_encode(Login::getLogins());