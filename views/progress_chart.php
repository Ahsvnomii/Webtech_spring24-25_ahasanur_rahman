<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];
$pdo = new PDO("mysql:host=localhost;dbname=fitness_tracker1", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// 1. Workout Duration Over Time (last 7 sessions)
$stmt = $pdo->prepare("SELECT duration_seconds, session_time FROM workout_sessions WHERE user_id = ? ORDER BY session_time DESC LIMIT 7");
$stmt->execute([$user_id]);
$workoutData = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Total Exercises Logged Per Session (last 7 sessions)
$exerciseCounts = [];
$labels = [];
foreach ($workoutData as $row) {
    $labels[] = date("M d", strtotime($row['session_time']));
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM exercise_logs WHERE session_id = (SELECT id FROM workout_sessions WHERE user_id = ? AND session_time = ? LIMIT 1)");
    $stmt->execute([$user_id, $row['session_time']]);
    $exerciseCounts[] = $stmt->fetchColumn();
}

// 3. Water Intake (last 7 days)
$stmt = $pdo->prepare("SELECT DATE(log_time) as date, COUNT(*) as count FROM water_logs WHERE user_id = ? AND log_time >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) GROUP BY DATE(log_time)");
$stmt->execute([$user_id]);
$waterData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$waterDates = [];
$waterCounts = [];
for ($i = 6; $i >= 0; $i--) {
    $date = date("Y-m-d", strtotime("-{$i} days"));
    $waterDates[] = date("M d", strtotime($date));
    $waterCounts[] = isset($waterData[$date]) ? (int)$waterData[$date] : 0;
}

// 4. Goal Completion
$stmt = $pdo->prepare("SELECT COUNT(*) as total, SUM(CASE WHEN status='completed' THEN 1 ELSE 0 END) as done FROM goals WHERE user_id = ?");
$stmt->execute([$user_id]);
$goal = $stmt->fetch();
$goalDone = (int)$goal['done'];
$goalTotal = max((int)$goal['total'], 1);

// 5. Active Plans
$stmt = $pdo->prepare("SELECT COUNT(*) FROM workout_plans WHERE user_id = ? AND active = 1");
$stmt->execute([$user_id]);
$activePlans = $stmt->fetchColumn();

// 6. Challenges Joined Over Time
$stmt = $pdo->prepare("SELECT DATE(joined_at) as date, COUNT(*) as count FROM challenges WHERE user_id = ? GROUP BY DATE(joined_at)");
$stmt->execute([$user_id]);
$challengeData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
$challengeDates = array_keys($challengeData);
$challengeCounts = array_values($challengeData);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Progress Charts</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { margin: 0; font-family: Arial; display: flex; height: 100vh; background: #f0f4f8; }
    .sidebar {
      width: 250px;
      background:rgba(46, 125, 50, 0.08);
      color: white;
      padding: 20px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .sidebar a {
      text-decoration: none;
      color: white;
      background:rgb(34, 84, 99);
      padding: 10px;
      border-radius: 5px;
    }
    .sidebar a:hover { background:rgb(36, 82, 85); }
    .main {
      flex: 1;
      padding: 30px;
      overflow-y: auto;
    }
    .chart-container { margin-bottom: 40px; background: white; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
  </style>
</head>
<body>

<div class="sidebar">
  <h3>Fitness Features</h3>
  <a href="workout_logger.php">Workout Logger</a>
  <a href="water_tracker.php">Water Tracker</a>
  <a href="goals.php">Goal Setting</a>
  <a href="workout_plans.php">Workout Plans</a>
  <a href="challenges.php">Challenges</a>
</div>

<div class="main">
  <h2>Progress Overview</h2>

  <div class="chart-container">
    <h4>Workout Duration (Last 7 Sessions)</h4>
    <canvas id="durationChart"></canvas>
  </div>

  <div class="chart-container">
    <h4>Exercises Per Session</h4>
    <canvas id="exerciseChart"></canvas>
  </div>

  <div class="chart-container">
    <h4>Water Intake (Last 7 Days)</h4>
    <canvas id="waterChart"></canvas>
  </div>

  <div class="chart-container">
    <h4>Goal Completion</h4>
    <canvas id="goalChart"></canvas>
  </div>

  <div class="chart-container">
    <h4>Active Workout Plans</h4>
    <canvas id="plansChart"></canvas>
  </div>

  <div class="chart-container">
    <h4>Challenges Joined Over Time</h4>
    <canvas id="challengesChart"></canvas>
  </div>
</div>

<script>
  new Chart(document.getElementById('durationChart'), {
    type: 'line',
    data: {
      labels: <?= json_encode(array_reverse($labels)) ?>,
      datasets: [{
        label: 'Duration (min)',
        data: <?= json_encode(array_reverse(array_map(fn($d) => round($d['duration_seconds'] / 60), $workoutData))) ?>,
        borderColor: '#2e7d32', fill: false
      }]
    }
  });

  new Chart(document.getElementById('exerciseChart'), {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_reverse($labels)) ?>,
      datasets: [{
        label: 'Exercises',
        data: <?= json_encode(array_reverse($exerciseCounts)) ?>,
        backgroundColor: '#43a047'
      }]
    }
  });

  new Chart(document.getElementById('waterChart'), {
    type: 'bar',
    data: {
      labels: <?= json_encode($waterDates) ?>,
      datasets: [{
        label: 'Glasses',
        data: <?= json_encode($waterCounts) ?>,
        backgroundColor: '#29b6f6'
      }]
    }
  });

  new Chart(document.getElementById('goalChart'), {
    type: 'doughnut',
    data: {
      labels: ['Completed', 'Remaining'],
      datasets: [{
        data: [<?= $goalDone ?>, <?= $goalTotal - $goalDone ?>],
        backgroundColor: ['#66bb6a', '#ef5350']
      }]
    }
  });

  new Chart(document.getElementById('plansChart'), {
    type: 'bar',
    data: {
      labels: ['Active Plans'],
      datasets: [{
        label: 'Plans',
        data: [<?= $activePlans ?>],
        backgroundColor: '#8e24aa'
      }]
    }
  });

  new Chart(document.getElementById('challengesChart'), {
    type: 'line',
    data: {
      labels: <?= json_encode($challengeDates) ?>,
      datasets: [{
        label: 'Challenges Joined',
        data: <?= json_encode($challengeCounts) ?>,
        borderColor: '#fb8c00', fill: false
      }]
    }
  });
</script>

</body>
</html>
