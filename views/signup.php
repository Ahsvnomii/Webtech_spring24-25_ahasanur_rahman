
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f2f2f2; }
    form { background: white; padding: 20px; border-radius: 8px; max-width: 400px; margin: auto; }
    input, select { width: 100%; padding: 10px; margin: 10px 0; }
    .error { color: red; }
  </style>
</head>
<body>

<h2>Signup</h2>

<?php
$name = $email = $password = $confirm = $age = $weight = $gender = "";
$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST["name"]);
    $email    = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm  = $_POST["confirm"];
    $age      = intval($_POST["age"]);
    $weight   = trim($_POST["weight"]);
    $gender   = $_POST["gender"];

    // Validation
    if (empty($name) || empty($email) || empty($password) || empty($confirm) || empty($age) || empty($weight) || empty($gender)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_contains($email, ".com")) {
        $errors[] = "Invalid email. Must contain '@' and end with '.com'.";
    }

    if ($age < 18) {
        $errors[] = "You must be at least 18 years old.";
    }

    if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters, with both uppercase and lowercase letters.";
    }

    if ($password !== $confirm) {
        $errors[] = "Passwords do not match.";
    }

    if (empty($errors)) {
        echo "<p style='color:green;'>Signup successful! (Database save will be done in backend step.)</p>";
        // Later: Save to DB here
    }
}
?>

<form method="POST">
  <input type="text" name="name" placeholder="Full Name" value="<?= htmlspecialchars($name) ?>">
  <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
  <input type="password" name="password" placeholder="Password">
  <input type="password" name="confirm" placeholder="Confirm Password">
  <input type="number" name="age" placeholder="Age" value="<?= htmlspecialchars($age) ?>">
  <input type="number" name="weight" placeholder="Weight (kg)" value="<?= htmlspecialchars($weight) ?>">
  <select name="gender">
    <option value="">Select Gender</option>
    <option value="Male" <?= $gender === "Male" ? "selected" : "" ?>>Male</option>
    <option value="Female" <?= $gender === "Female" ? "selected" : "" ?>>Female</option>
  </select>
  <button type="submit">Sign Up</button>

  <?php
  if (!empty($errors)) {
      echo "<div class='error'><ul>";
      foreach ($errors as $err) {
          echo "<li>$err</li>";
      }
      echo "</ul></div>";
  }
  ?>
</form>

</body>
</html>
