<?php
require_once '../config/config.php';
require_once '../app/controller/LoginController.php';

$controller = new LoginController($pdo);
$controller->handleLogin();
