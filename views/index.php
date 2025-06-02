<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Fitness Tracker - Welcome</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #f5f7fa, #c3cfe2);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .container {
      background: white;
      padding: 40px 50px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 90%;
      max-width: 400px;
      position: relative;
    }

    .icon {
      width: 60px;
      height: 60px;
      margin: 0 auto 20px;
      animation: pulse 2s infinite ease-in-out;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.1); opacity: 0.85; }
    }

    h1 {
      margin-bottom: 24px;
      font-size: 24px;
      color: #333;
    }

    .btn {
      padding: 12px 24px;
      margin: 12px 6px;
      font-size: 16px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .btn-login {
      background-color: #23a6d5;
      color: white;
    }

    .btn-login:hover {
      background-color: #1d8dbf;
    }

    .btn-signup {
      background-color: #2ecc71;
      color: white;
    }

    .btn-signup:hover {
      background-color: #27ae60;
    }

    .footer {
      font-size: 12px;
      color: #777;
      margin-top: 20px;
    }
  </style>
</head>
<body>

<div class="container">

  <svg class="icon" fill="#23a6d5" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
    <path d="M54 20v-4a2 2 0 0 0-4 0v4h-4v-4a2 2 0 0 0-4 0v4h-4v24h4v4a2 2 0 0 0 4 0v-4h4v4a2 2 0 0 0 4 0v-4h4V20h-4zm-4 20h-4V24h4v16zM14 20v-4a2 2 0 0 0-4 0v4H6v24h4v4a2 2 0 0 0 4 0v-4h4v4a2 2 0 0 0 4 0v-4h4V20h-4v-4a2 2 0 0 0-4 0v4h-4zm0 16h-4V24h4v12z"/>
  </svg>

  <h1>Welcome to Fitness Tracker</h1>
  <button class="btn btn-login" onclick="window.location.href='login.php'">Sign In</button>
  <button class="btn btn-signup" onclick="window.location.href='signup.php'">Sign Up</button>

  <div class="footer">Track your progress. Achieve your goals.</div>
</div>

</body>
</html>
