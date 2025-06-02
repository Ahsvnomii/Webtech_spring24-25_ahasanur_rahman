<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=fitness_tracker1", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $duration = intval($_POST["duration"]);
    $note = $_POST["note"];
    $user_id = $_SESSION["user_id"];
    $exercises = json_decode($_POST["exercises"], true);

    // Save workout session
    $stmt = $pdo->prepare("INSERT INTO workout_sessions (user_id, duration_seconds, notes) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $duration, $note]);
    $session_id = $pdo->lastInsertId();

    // Save each exercise
    $stmt = $pdo->prepare("INSERT INTO exercise_logs (session_id, exercise_name, sets, reps, weight) VALUES (?, ?, ?, ?, ?)");
    foreach ($exercises as $ex) {
        $stmt->execute([$session_id, $ex["name"], $ex["sets"], $ex["reps"], $ex["weight"]]);
    }

    echo "<script>alert('Workout saved successfully!'); window.location.href='dashboard.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Workout Logger</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 30px;
      background: linear-gradient(-45deg, #e3f2fd, #f0f4c3);
      background-size: 400% 400%;
      animation: bgAnim 10s ease infinite;
    }

    @keyframes bgAnim {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    h2 { margin-bottom: 10px; color: #2e7d32; }

    .section { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }

    .timer { font-size: 32px; margin: 10px 0; }

    button {
      padding: 10px 16px;
      border: none;
      border-radius: 6px;
      margin: 5px;
      cursor: pointer;
    }

    .start { background-color: #43a047; color: white; }
    .stop { background-color: #e53935; color: white; }

    input, textarea {
      padding: 8px;
      width: 100%;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    table {
      width: 100%;
      margin-top: 15px;
      border-collapse: collapse;
      background: #fafafa;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 8px;
      text-align: center;
    }

    .save-btn {
      background-color: #2e7d32;
      color: white;
      padding: 10px 20px;
    }
  </style>
</head>
<body>

<h2>Workout Logger</h2>

<form method="POST" id="workoutForm">
  <div class="section">
    <h3>1. Timer</h3>
    <div class="timer" id="timer">00:00:00</div>
    <button type="button" class="start" onclick="startTimer()">Start</button>
    <button type="button" class="stop" onclick="stopTimer()">Stop</button>
  </div>

  <div class="section">
    <h3>2. Exercise Logger</h3>
    <input type="text" id="exercise" placeholder="Exercise Name" required>
    <input type="number" id="sets" placeholder="Sets" min="1">
    <input type="number" id="reps" placeholder="Reps" min="1">
    <input type="number" id="weight" placeholder="Weight (kg)" min="0" step="0.1">
    <button type="button" onclick="addExercise()">Add Exercise</button>

    <table id="exerciseTable" style="display:none;">
      <thead>
        <tr><th>Name</th><th>Sets</th><th>Reps</th><th>Weight</th></tr>
      </thead>
      <tbody></tbody>
    </table>
  </div>

  <div class="section">
    <h3>3. Session Summary</h3>
    <textarea name="note" placeholder="Add any notes..."></textarea>
    <input type="hidden" name="duration" id="durationInput">
    <input type="hidden" name="exercises" id="exercisesInput">
    <button type="submit" class="save-btn">Save Workout</button>
  </div>
</form>

<script>
  let timer = 0, interval;
  let exercises = [];

  function updateDisplay() {
    const hrs = String(Math.floor(timer / 3600)).padStart(2, '0');
    const mins = String(Math.floor((timer % 3600) / 60)).padStart(2, '0');
    const secs = String(timer % 60).padStart(2, '0');
    document.getElementById("timer").textContent = `${hrs}:${mins}:${secs}`;
  }

  function startTimer() {
    if (interval) return;
    interval = setInterval(() => { timer++; updateDisplay(); }, 1000);
  }

  function stopTimer() {
    clearInterval(interval);
    interval = null;
    document.getElementById("durationInput").value = timer;
  }

  function addExercise() {
    const name = document.getElementById("exercise").value;
    const sets = parseInt(document.getElementById("sets").value);
    const reps = parseInt(document.getElementById("reps").value);
    const weight = parseFloat(document.getElementById("weight").value);

    if (!name || !sets || !reps || isNaN(weight)) return alert("Fill all exercise fields!");

    exercises.push({ name, sets, reps, weight });
    updateTable();

    // Reset input
    document.getElementById("exercise").value = "";
    document.getElementById("sets").value = "";
    document.getElementById("reps").value = "";
    document.getElementById("weight").value = "";
  }

  function updateTable() {
    const table = document.getElementById("exerciseTable");
    const tbody = table.querySelector("tbody");
    tbody.innerHTML = "";
    exercises.forEach(ex => {
      tbody.innerHTML += `<tr><td>${ex.name}</td><td>${ex.sets}</td><td>${ex.reps}</td><td>${ex.weight}</td></tr>`;
    });
    table.style.display = "table";
    document.getElementById("exercisesInput").value = JSON.stringify(exercises);
  }

  document.getElementById("workoutForm").addEventListener("submit", () => {
    if (timer === 0) {
      alert("Please run and stop the timer first.");
      event.preventDefault();
    }
    if (exercises.length === 0) {
      alert("Please add at least one exercise.");
      event.preventDefault();
    }
  });
</script>

</body>
</html>
