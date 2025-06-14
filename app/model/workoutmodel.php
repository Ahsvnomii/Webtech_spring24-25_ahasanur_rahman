<?php
class WorkoutModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function logWorkout($userId, $type, $duration) {
        $stmt = $this->pdo->prepare("INSERT INTO workout_sessions (user_id, type, duration_seconds) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $type, $duration]);
    }

    public function getRecentWorkouts($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM workout_sessions WHERE user_id = ? ORDER BY id DESC LIMIT 5");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
