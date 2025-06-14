<!DOCTYPE html>
<html>
<head>
  <title>Workout Logger</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(-45deg, #f3e5f5, #e3f2fd, #c8e6c9, #fff9c4);
      background-size: 400% 400%;
      animation: animatedBackground 10s ease infinite;
      padding: 40px;
    }

    @keyframes animatedBackground {
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

    h2 { color: #2e7d32; }

    input, select, button {
      width: 100%;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }

    .msg {
      background: #d0f0c0;
      padding: 10px;
      border-radius: 5px;
      color: #2e7d32;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>🏋️ Log Your Workout</h2>

  <?php if (!empty($this->message)): ?>
    <div class="msg"><?= htmlspecialchars($this->message) ?></div>
  <?php endif; ?>

  <form method="POST">
    <input type="text" name="type" placeholder="Workout Type (e.g. Chest, Cardio)" required>
    <input type="number" name="duration" placeholder="Duration in seconds" required min="30">
    <button type="submit">Log Workout</button>
  </form>

  <h3>🕒 Recent Workouts</h3>
  <table>
    <tr><th>Type</th><th>Duration</th><th>Date</th></tr>
    <?php foreach ($workouts as $w): ?>
      <tr>
        <td><?= htmlspecialchars($w["type"]) ?></td>
        <td><?= round($w["duration_seconds"] / 60) ?> min</td>
        <td><?= $w["date_logged"] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div>

</body>
</html>
