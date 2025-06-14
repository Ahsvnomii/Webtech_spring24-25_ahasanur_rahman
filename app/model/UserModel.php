<?php
class UserModel {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function isEmailTaken($email) {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function registerUser($name, $email, $password, $age, $weight, $gender) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, age, weight, gender) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed, $age, $weight, $gender]);
    }

    public function loginUser($email) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch();
}

}
?>