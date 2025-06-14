<?php
require_once '../config/config.php';
require_once '../app/controller/WaterController.php';

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

$controller = new WaterController($pdo);
$controller->handleTracker($_SESSION["user_id"]);
