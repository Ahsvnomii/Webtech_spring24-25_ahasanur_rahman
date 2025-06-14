<!DOCTYPE html>
<html>
<head>
  <title>Water Tracker</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(-45deg, #c8e6c9, #bbdefb, #f0f4c3, #d1c4e9);
      background-size: 400% 400%;
      animation: bgAnimate 10s ease infinite;
      padding: 40px;
    }

    @keyframes bgAnimate {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .container {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }

    h2, h3 { color: #0277bd; }

    .msg {
      background: #e3f2fd;
      color: #01579b;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
    }

    button {
      background: #42a5f5;
      color: white;
      border: none;
      padding: 10px 20px;
      font-size: 16px;
      border-radius: 6px;
      cursor: pointer;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>💧 Water Tracker</h2>

  <?php if (!empty($this->message)): ?>
    <div class="msg"><?= htmlspecialchars($this->message) ?></div>
  <?php endif; ?>

  <form method="POST">
    <button type="submit">+ Add 250ml Water</button>
  </form>

  <h3>🌊 Total Today: <?= $todayTotal ?> ml</h3>

  <h3>🕒 Recent Logs</h3>
  <table>
    <tr><th>Amount</th><th>Time</th></tr>
    <?php foreach ($recentLogs as $log): ?>
      <tr>
        <td><?= $log["amount_ml"] ?> ml</td>
        <td><?= date("h:i A", strtotime($log["log_time"])) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

</body>
</html>
