<?php
require_once __DIR__ . '/../model/WorkoutModel.php';

class WorkoutController {
    private $model;
    public $message = "";

    public function __construct($pdo) {
        $this->model = new WorkoutModel($pdo);
    }

    public function handleLogger($userId) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $type = trim($_POST["type"]);
            $duration = intval($_POST["duration"]);

            if ($type && $duration > 0) {
                $this->model->logWorkout($userId, $type, $duration);
                $this->message = "Workout logged successfully!";
            }
        }

        $workouts = $this->model->getRecentWorkouts($userId);
        include __DIR__ . '/../view/workoutLoggerView.php';
    }
}
