<?php
require_once __DIR__ . '/../model/UserModel.php';

class SignupController {
    private $model;
    public $errors = [];

    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    public function handleSignup() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $name     = trim($_POST["name"]);
            $email    = trim($_POST["email"]);
            $password = $_POST["password"];
            $confirm  = $_POST["confirm"];
            $age      = intval($_POST["age"]);
            $weight   = $_POST["weight"];
            $gender   = $_POST["gender"];

            if (empty($name) || empty($email) || empty($password) || empty($confirm) || empty($age) || empty($weight) || empty($gender)) {
                $this->errors[] = "All fields are required.";
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_contains($email, ".com")) {
                $this->errors[] = "Invalid email.";
            }
            if ($age < 18) {
                $this->errors[] = "Must be at least 18.";
            }
            if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
                $this->errors[] = "Password must include upper & lower case and be at least 8 characters.";
            }
            if ($password !== $confirm) {
                $this->errors[] = "Passwords do not match.";
            }
            if ($this->model->isEmailTaken($email)) {
                $this->errors[] = "Email already registered.";
            }

            if (empty($this->errors)) {
                if ($this->model->registerUser($name, $email, $password, $age, $weight, $gender)) {
                    header("Location: login.php?success=1");
                    exit;
                } else {
                    $this->errors[] = "Signup failed.";
                }
            }
        }

        include __DIR__ . '/../view/signupForm.php';
    }
}
?>