<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <style>
    body { font-family: Arial; background: #eef2f7; padding: 40px; }
    form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    input, button { width: 100%; padding: 10px; margin: 8px 0; }
    .error-box {
      background: #ffe6e6;
      border: 1px solid #cc0000;
      padding: 10px;
      color: #b30000;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<h2 style="text-align:center;">Login</h2>

<form method="POST">
  <?php if (!empty($this->errors)): ?>
    <div class="error-box">
      <ul>
        <?php foreach ($this->errors as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
</form>

</body>
</html>
