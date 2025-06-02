<?php
session_start();

// DB config
$host = "localhost";
$dbname = "fitness_tracker1";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB connection failed: " . $e->getMessage());
}

$email = $password = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if (empty($email) || empty($password)) {
        $errors[] = "Both fields are required.";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            header("Location: progress_chart.php");
            exit;
        } else {
            $errors[] = "Invalid email or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f2f2f2; }
    form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
    input { width: 100%; padding: 10px; margin: 10px 0; }
    .error { color: red; }
  </style>
</head>
<body>

<h2>Login</h2>

<form method="POST">
  <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
  <input type="password" name="password" placeholder="Password">
  <button type="submit">Login</button>

  <?php
  if (!empty($errors)) {
      echo "<div class='error'><ul>";
      foreach ($errors as $err) echo "<li>$err</li>";
      echo "</ul></div>";
  }
  ?>
</form>

</body>
</html>
