<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Forgot Password | MindCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* 🌿 Light mode gradient */
    body {
      background: linear-gradient(to bottom right, #d0f0c0, #a8e6cf);
      color: #1e1e1e;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: background 0.5s ease, color 0.5s ease;
    }

    /* 🌑 Dark mode gradient */
    body.dark-mode {
      background: linear-gradient(to bottom right, #2e7d32, #1b5e20);
      color: #f8f9fa;
    }

    /* Card design */
    .card {
      width: 100%;
      max-width: 420px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 1rem;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
      transition: background-color 0.4s ease, color 0.4s ease;
      color: #1e1e1e;
    }

    /* ✅ Softer dark card background for readability */
    body.dark-mode .card {
      background-color: rgba(50, 50, 50, 0.9);
      color: #f8f9fa;
    }

    .card h4 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 1rem;
    }

    /* Buttons */
    .btn-primary {
      background-color: #4caf50;
      border: none;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #45a049;
    }

    body.dark-mode .btn-primary {
      background-color: #81c784;
      color: #1e1e1e;
    }

    /* Links */
    a {
      color: #2e7d32;
      text-decoration: none;
      font-weight: 500;
    }

    a:hover {
      text-decoration: underline;
    }

    body.dark-mode a {
      color: #a5d6a7;
    }

    /* 🌗 Dark mode toggle */
    #themeToggle {
      position: absolute;
      top: 20px;
      right: 20px;
      background-color: transparent;
      border: 2px solid #4caf50;
      color: #4caf50;
      border-radius: 25px;
      padding: 8px 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 8px;
      transition: all 0.3s ease;
    }

    #themeToggle:hover {
      background-color: #4caf50;
      color: #fff;
    }

    .rotate {
      transform: rotate(360deg);
      transition: transform 0.5s ease;
    }
  </style>
</head>
<body>
  <!-- 🌗 Dark Mode Toggle -->
  <button id="themeToggle">
    <span id="themeIcon">🌞</span>
    <span id="themeLabel">Light Mode</span>
  </button>

  <div class="card p-4">
    <h4>Reset Your Password</h4>

    <?php if (isset($_GET['error'])): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
    <?php elseif (isset($_GET['success'])): ?>
      <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <form method="POST" action="send-reset-link.php">
      <input type="email" name="email" class="form-control mb-3" placeholder="Enter your email" required>
      <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
    </form>

    <div class="mt-3 text-center">
      <a href="login.php">Back to Login</a>
    </div>
  </div>

  <script>
    const toggleBtn = document.getElementById('themeToggle');
    const icon = document.getElementById('themeIcon');
    const label = document.getElementById('themeLabel');

    const prefersDark = localStorage.getItem('dark-mode') === 'true';
    if (prefersDark) {
      document.body.classList.add('dark-mode');
      icon.textContent = '🌙';
      label.textContent = 'Dark Mode';
    }

    toggleBtn.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      const isDark = document.body.classList.contains('dark-mode');
      localStorage.setItem('dark-mode', isDark);
      icon.classList.add('rotate');
      setTimeout(() => icon.classList.remove('rotate'), 500);
      icon.textContent = isDark ? '🌙' : '🌞';
      label.textContent = isDark ? 'Dark Mode' : 'Light Mode';
    });
  </script>
</body>
</html>