<?php
require_once __DIR__ . '/../model/WaterModel.php';

class WaterController {
    private $model;
    public $message = "";

    public function __construct($pdo) {
        $this->model = new WaterModel($pdo);
    }

    public function handleTracker($userId) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $this->model->logWater($userId);
            $this->message = "Water added successfully!";
        }

        $todayTotal = $this->model->getTodayTotal($userId);
        $recentLogs = $this->model->getRecentLogs($userId);

        include __DIR__ . '/../view/waterTrackerView.php';
    }
}
