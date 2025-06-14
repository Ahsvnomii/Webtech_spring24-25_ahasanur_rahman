<?php
$pdo = new PDO("mysql:host=localhost;dbname=fitness_tracker1", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
session_start();
?>