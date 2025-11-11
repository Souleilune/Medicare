<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Fade-in animation */
    .fade-in {
      animation: fadeIn 1.5s ease-in-out;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Sidebar with gradient (light mode) */
    .sidebar {
      width: 250px;
      min-height: 100vh;
      background: linear-gradient(to bottom right, #d0f0c0, #a8e6cf);
      color: #1e1e1e;
    }

    .sidebar .nav-link {
      color: #2c3e50;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.fw-bold {
      color: #1e1e1e;
      background-color: rgba(0, 0, 0, 0.1);
      border-radius: 8px;
    }

    /* Light mode (default) */
    body {
      background-color: #f8f9fa;
      color: #212529;
    }

    .card {
      background-color: #ffffff;
      color: #212529;
      border: 1px solid #dee2e6;
    }

    .list-group-item {
      background-color: #ffffff;
      color: #212529;
    }

    /* Dark mode */
    body.dark-mode {
      background-color: #121212;
      color: #f8f9fa;
    }

    /* Dark mode sidebar gradient */
    body.dark-mode .sidebar {
      background: linear-gradient(to bottom right, #2e7d32, #1b5e20);
      color: #f8f9fa;
    }

    body.dark-mode .sidebar .nav-link {
      color: #e0e0e0;
    }

    body.dark-mode .sidebar .nav-link:hover,
    body.dark-mode .sidebar .nav-link.fw-bold {
      background-color: rgba(255, 255, 255, 0.15);
      color: white;
    }

    body.dark-mode .card {
      background-color: #1f1f1f;
      color: #f1f1f1;
      border: 1px solid #2a2a2a;
    }

    body.dark-mode .list-group-item {
      background-color: #1f1f1f;
      color: #f1f1f1;
      border-color: #2a2a2a;
    }

    body.dark-mode .dropdown-menu {
      background-color: #2a2a2a;
      color: #f1f1f1;
    }

    body.dark-mode .dropdown-item-text {
      color: #f1f1f1;
    }

    /* Toggle button */
    #themeToggle {
      border-color: #6c757d;
      color: #1e1e1e;
      background-color: rgba(255, 255, 255, 0.6);
      font-weight: 500;
      transition: all 0.3s ease;
    }

    #themeToggle:hover {
      background-color: rgba(255, 255, 255, 0.8);
      transform: scale(1.05);
    }

    body.dark-mode #themeToggle {
      color: #f8f9fa;
      background-color: rgba(255, 255, 255, 0.1);
      border-color: #adb5bd;
    }

    body.dark-mode #themeToggle:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    #themeIcon.rotate {
      display: inline-block;
      animation: rotateIcon 0.5s ease-in-out;
    }

    @keyframes rotateIcon {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-flex flex-column align-items-center p-3">
      <div class="logo-wrapper mb-3">
        <img src="images/MindCare.png" alt="MindCare Logo" class="logo-img" style="max-width: 120px;" />
      </div>

      <div class="dropdown w-100 mb-3">
        <button class="btn btn-outline-dark dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
          Resources
        </button>
        <ul class="dropdown-menu w-100">
          <li><h6 class="dropdown-header">Services</h6></li>
          <li><span class="dropdown-item-text">Mental Health Assessments</span></li>
          <li><span class="dropdown-item-text">Personalized Recommendations</span></li>
          <li><span class="dropdown-item-text">Appointment Booking</span></li>
          <li><span class="dropdown-item-text">Progress Tracking Dashboard</span></li>
          <li><hr class="dropdown-divider"></li>
          <li><h6 class="dropdown-header">Therapies</h6></li>
          <li><span class="dropdown-item-text">Cognitive Behavioral Therapy</span></li>
          <li><span class="dropdown-item-text">Mindfulness-Based Therapy</span></li>
          <li><span class="dropdown-item-text">Interpersonal Therapy</span></li>
          <li><span class="dropdown-item-text">Supportive Counseling</span></li>
        </ul>
      </div>

      <nav class="nav flex-column w-100 text-center">
        <a class="nav-link" href="assessment.php">Assessment</a>
        <a class="nav-link" href="recommendations.php">Recommendations</a>
        <a class="nav-link" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link" href="appointments.php">My Appointments</a>
        <a class="nav-link fw-bold" href="profile.php">Profile</a>
        <a class="nav-link" href="faq.php">FAQ</a>
        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
      </nav>

      <button id="themeToggle" class="btn d-flex align-items-center gap-2 mt-4">
        <span id="themeIcon">🌞</span>
        <span id="themeLabel">Light Mode</span>
      </button>
    </div>

    <!-- Main Content -->
    <div class="container py-5 fade-in">
      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_GET['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <h2 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['user']['fullname']) ?></h2>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Profile Information</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></li>
            <li class="list-group-item"><strong>Gender:</strong> <?= htmlspecialchars($_SESSION['user']['gender']) ?></li>
            <li class="list-group-item"><strong>Role:</strong> <?= htmlspecialchars($_SESSION['user']['role']) ?></li>
            <li class="list-group-item"><strong>Created At:</strong> <?= htmlspecialchars($_SESSION['user']['created_at']) ?></li>
          </ul>
        </div>
      </div>

      <div class="mt-4">
        <a href="edit-profile.php" class="btn btn-warning">Edit Profile</a>
        <a href="index.php" class="btn btn-secondary">Dashboard</a>
        <a href="logout.php" class="btn btn-danger">Logout</a>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
