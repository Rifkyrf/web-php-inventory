<?php
require_once 'app/config/database.php';
require_once 'app/controllers/AuthController.php';

$auth = new AuthController();
$auth->logout();
?>