<?php
class WaterModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function logWater($userId) {
        $stmt = $this->pdo->prepare("INSERT INTO water_logs (user_id) VALUES (?)");
        return $stmt->execute([$userId]);
    }

    public function getTodayTotal($userId) {
        $stmt = $this->pdo->prepare("SELECT SUM(amount_ml) FROM water_logs WHERE user_id = ? AND DATE(log_time) = CURDATE()");
        $stmt->execute([$userId]);
        return $stmt->fetchColumn() ?? 0;
    }

    public function getRecentLogs($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM water_logs WHERE user_id = ? ORDER BY id DESC LIMIT 5");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
