<?php
require_once '../config/config.php';
require_once '../app/controller/SignupController.php';

$controller = new SignupController($pdo);
$controller->handleSignup();
?>