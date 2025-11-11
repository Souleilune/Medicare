<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register | MindCare</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* 🌿 Base layout */
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      min-height: 100vh;
      transition: background-color 0.5s ease, color 0.5s ease;
      color: #1e1e1e;
      background-color: #f8f9fa;
    }

    /* 🌿 Sidebar (same as FAQ) */
    .sidebar {
      width: 250px;
      background: linear-gradient(to bottom right, #d0f0c0, #a8e6cf);
      padding: 1.5rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      transition: background 0.5s ease, color 0.5s ease;
    }

    .logo-wrapper img {
      width: 120px;
      margin-bottom: 1rem;
    }

    .nav-link {
      text-decoration: none;
      color: #1e1e1e;
      font-weight: 500;
      margin: 0.5rem 0;
      display: block;
      transition: color 0.3s ease;
    }

    .nav-link:hover {
      color: #388e3c;
    }

    body.dark-mode .sidebar {
      background: linear-gradient(to bottom right, #2e7d32, #1b5e20);
    }

    body.dark-mode .nav-link {
      color: #f8f9fa;
    }

    body.dark-mode .nav-link:hover {
      color: #c8e6c9;
    }

    .nav-link.text-danger {
      color: #d32f2f !important;
    }

    /* 🌗 Theme Toggle */
    #themeToggle {
      margin-top: auto;
      background-color: transparent;
      border: 2px solid #4caf50;
      color: #4caf50;
      border-radius: 25px;
      padding: 6px 14px;
      font-weight: 600;
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 6px;
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

    /* 🌸 Main content area */
    .main-content {
      flex-grow: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background-color 0.5s ease, color 0.5s ease;
      background-color: #ffffff;
    }

    body.dark-mode .main-content {
      background-color: #121212;
      color: #f8f9fa;
    }

    /* Card form */
    .card {
      width: 100%;
      max-width: 480px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    body.dark-mode .card {
      background-color: rgba(30, 30, 30, 0.95);
      color: #f8f9fa;
    }

    /* Inputs and selects */
    .form-control, .form-select {
      border-radius: 8px;
      border: 1px solid #ccc;
      background-color: #fff;
      color: #1e1e1e;
      transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: #4caf50;
      box-shadow: 0 0 5px rgba(76, 175, 80, 0.4);
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select {
      background-color: #2c2c2c;
      color: #f8f9fa;
      border-color: #81c784;
    }

    body.dark-mode .form-control::placeholder {
      color: #bdbdbd;
    }

    /* Button */
    .btn-primary {
      background-color: #4caf50;
      border: none;
      transition: background-color 0.3s;
    }

    .btn-primary:hover {
      background-color: #45a049;
    }

    body.dark-mode .btn-primary {
      background-color: #81c784;
      color: #1e1e1e;
    }
  </style>
</head>
<body>

  <!-- 🌿 Sidebar (same as FAQ) -->
  <div class="sidebar">
    <div class="text-center">
      <div class="logo-wrapper">
        <img src="images/MindCare.png" alt="MindCare Logo">
      </div>
      <nav class="nav flex-column text-center">
        <a class="nav-link" href="assessment.php">Assessment</a>
        <a class="nav-link" href="recommendations.php">Recommendations</a>
        <a class="nav-link" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link" href="appointments.php">My Appointments</a>
        <a class="nav-link" href="profile.php">Profile</a>
        <a class="nav-link" href="faq.php">FAQ</a>
        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
      </nav>
    </div>

    <button id="themeToggle">
      <span id="themeIcon">🌞</span>
      <span id="themeLabel">Light Mode</span>
    </button>
  </div>

  <!-- 🌸 Main Form Section -->
  <div class="main-content">
    <div class="card">
      <h2 class="text-center mb-3">Create an Account</h2>

      <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
      <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success">Registration successful! You can now <a href="login.php">log in</a>.</div>
      <?php endif; ?>

      <form method="POST" action="register-handler.php">
        <div class="mb-3">
          <label for="fullname" class="form-label">Full Name</label>
          <input type="text" name="fullname" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" name="email" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required />
        </div>
        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select name="gender" class="form-select" required>
            <option value="">Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
      </form>
    </div>
  </div>

  <!-- 🌙 Dark Mode Toggle Script -->
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