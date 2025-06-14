<?php
require_once '../config/config.php';
require_once '../app/controller/DashboardController.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$controller = new DashboardController($pdo);
$controller->showDashboard($_SESSION["user_id"]);
