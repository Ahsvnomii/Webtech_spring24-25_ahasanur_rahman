<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <style>
    body { font-family: Arial; background: #f4f7f9; padding: 40px; }
    .container {
      max-width: 700px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      color:rgb(29, 48, 99);
      font-size: 28px;
    }
  </style>
</head>
<body>

<div class="container">
  <h1>Welcome, <?= htmlspecialchars($userStats["name"]) ?> 👋</h1>
  <p>Here’s your fitness progress at a glance:</p>

  <div style="display: flex; flex-wrap: wrap; gap: 20px; margin-top: 20px;">
    <div style="flex:1; background:#e8f5e9; padding:20px; border-radius:8px;">
      <h3>🏋️ Total Workouts</h3>
      <p style="font-size: 24px;"><?= $userStats["total_workouts"] ?></p>
    </div>
    <div style="flex:1; background:#fff3e0; padding:20px; border-radius:8px;">
      <h3>⏱️ Avg Duration</h3>
      <p style="font-size: 24px;"><?= $userStats["avg_minutes"] ?> min</p>
    </div>
    <div style="flex:1; background:#e3f2fd; padding:20px; border-radius:8px;">
      <h3>💧 Water Today</h3>
      <p style="font-size: 24px;"><?= $userStats["water_today"] ?> ml</p>
    </div>
    <div style="flex:1; background:#f3e5f5; padding:20px; border-radius:8px;">
      <h3>🎯 Goals Completed</h3>
      <p style="font-size: 24px;"><?= $userStats["goals_completed"] ?></p>
    </div>
  </div>
</div>

<h2 style="margin-top:40px;">🚀 Quick Access</h2>
<div style="display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px;">
  <a href="workout_logger.php" class="dash-link">🏋️ Workout Logger</a>
  <a href="water_tracker.php" class="dash-link">💧 Water Tracker</a>
  <a href="goals.php" class="dash-link">🎯 Goal Setting</a>
  <a href="workout_plans.php" class="dash-link">📆 Workout Plans</a>
  <a href="challenges.php" class="dash-link">🏆 Friend Challenges</a>
  <a href="progress_charts.php" class="dash-link">📈 Progress Tracker</a>
</div>

<style>
  .dash-link {
    flex: 1 1 30%;
    background: #fafafa;
    border: 1px solid #ddd;
    padding: 15px;
    text-align: center;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    color: #333;
    transition: 0.3s;
  }
  .dash-link:hover {
    background: #dcedc8;
    color:rgb(48, 33, 100);
  }
</style>



</body>
</html>
