<?php
class DashboardModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    
    public function getUserStats($userId) {
    // Get user name
    $stmt = $this->pdo->prepare("SELECT name FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    // Total workouts
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM workout_sessions WHERE user_id = ?");
    $stmt->execute([$userId]);
    $totalWorkouts = $stmt->fetchColumn();

    // Avg workout duration
    $stmt = $this->pdo->prepare("SELECT AVG(duration_seconds) FROM workout_sessions WHERE user_id = ?");
    $stmt->execute([$userId]);
    $avgDurationSeconds = $stmt->fetchColumn();
    $avgMinutes = $avgDurationSeconds ? round($avgDurationSeconds / 60) : 0;

    // Water intake today
    $stmt = $this->pdo->prepare("SELECT SUM(amount_ml) FROM water_logs WHERE user_id = ? AND DATE(log_time) = CURDATE()");
    $stmt->execute([$userId]);
    $waterToday = $stmt->fetchColumn() ?? 0;

    // Goals completed
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM goals WHERE user_id = ? AND status = 'completed'");
    $stmt->execute([$userId]);
    $completedGoals = $stmt->fetchColumn();

    return [
        "name" => $user["name"] ?? "User",
        "total_workouts" => $totalWorkouts,
        "avg_minutes" => $avgMinutes,
        "water_today" => $waterToday,
        "goals_completed" => $completedGoals
    ];
}

    }

