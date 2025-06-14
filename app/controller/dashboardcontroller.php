<?php
require_once __DIR__ . '/../model/DashboardModel.php';

class DashboardController {
    private $model;

    public function __construct($pdo) {
        $this->model = new DashboardModel($pdo);
    }

    public function showDashboard($userId) {
        $userStats = $this->model->getUserStats($userId);
        include __DIR__ . '/../view/dashboardView.php';
    }
}
