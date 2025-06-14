<?php
require_once '../config/config.php';
require_once '../app/controller/WorkoutController.php';

if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit;
}

$controller = new WorkoutController($pdo);
$controller->handleLogger($_SESSION["user_id"]);
