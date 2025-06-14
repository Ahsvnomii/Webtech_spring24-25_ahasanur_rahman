<!DOCTYPE html>
<html>
<head>
  <title>Signup</title>
  <style>
    body { font-family: Arial; background: #f4f7fa; padding: 40px; }
    form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    input, select, button { width: 100%; padding: 10px; margin: 8px 0; }
    .error-box {
      background: #ffe6e6;
      border: 1px solid #cc0000;
      padding: 10px;
      color: #b30000;
      margin-bottom: 10px;
      display: block;
    }
  </style>
</head>
<body>
<h2 style="text-align:center;">Create Your Account</h2>
<form method="POST" novalidate>
<?php if (!empty($this->errors)): ?>

    <div class="error-box">
      <ul>
        <?php foreach ($this->errors as $error): ?>

          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <input type="text" name="name" placeholder="Full Name" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <input type="password" name="confirm" placeholder="Confirm Password" required>
  <input type="number" name="age" placeholder="Age" min="18" required>
  <input type="number" name="weight" placeholder="Weight (kg)" step="0.1" required>
  <select name="gender" required>
    <option value="">Select Gender</option>
    <option>Male</option>
    <option>Female</option>
  </select>
  <button type="submit">Sign Up</button>
</form>
</body>
</html>