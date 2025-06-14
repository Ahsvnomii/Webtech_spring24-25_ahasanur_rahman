<?php
require_once __DIR__ . '/../model/UserModel.php';

class LoginController {
    private $model;
    public $errors = [];

    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    public function handleLogin() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $email = trim($_POST["email"]);
            $password = $_POST["password"];

            if (empty($email) || empty($password)) {
                $this->errors[] = "Email and password are required.";
            } else {
                $user = $this->model->loginUser($email);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION["user_id"] = $user["id"];
                    $_SESSION["user_name"] = $user["name"];
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $this->errors[] = "Invalid email or password.";
                }
            }
        }

        include __DIR__ . '/../view/loginForm.php';
    }
}
