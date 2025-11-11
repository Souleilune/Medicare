<?php
session_start();
include 'db.php';

$availability = [
  8 => [ // Dr. Santos
    'Monday' => ['09:00 AM', '10:00 AM', '02:00 PM'],
    'Tuesday' => ['09:00 AM', '11:00 AM'],
    'Wednesday' => ['10:00 AM', '01:00 PM'],
    'Thursday' => ['09:00 AM', '03:00 PM'],
    'Friday' => ['10:00 AM', '02:00 PM']
  ],
  9 => [ // Dr. Reyes
    'Monday' => ['08:00 AM', '01:00 PM'],
    'Tuesday' => ['10:00 AM', '03:00 PM'],
    'Wednesday' => ['09:00 AM', '11:00 AM'],
    'Thursday' => ['08:00 AM', '12:00 PM'],
    'Friday' => ['09:00 AM', '01:00 PM']
  ]
];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Book Appointment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-flex flex-column align-items-center p-3">
      <div class="logo-wrapper mb-3">
        <img src="images/MindCare.png" alt="MindCare Logo" class="logo-img" style="max-width: 120px;" />
      </div>

      <div class="dropdown w-100 mb-3">
        <button class="btn btn-outline-light dropdown-toggle w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
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
        <a class="nav-link fw-bold" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link" href="appointments.php">My Appointments</a>
        <a class="nav-link" href="profile.php">Profile</a>
        <a class="nav-link" href="faq.php">FAQ</a>
        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
      </nav>

      <button id="themeToggle" class="btn btn-outline-light d-flex align-items-center gap-2 mt-4">
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

      <h3>Book an Appointment</h3>

      <!-- Availability Display -->
      <div class="mb-4">
        <h5>Specialist Availability (Mon–Fri)</h5>
        <?php foreach ($availability as $id => $days): ?>
          <div class="mb-3 p-3 border rounded bg-light">
            <strong><?= $id === 8 ? 'Dr. Santos – Psychologist' : 'Dr. Reyes – Psychiatrist' ?></strong>
            <ul class="mb-0">
              <?php foreach ($days as $day => $slots): ?>
                <li><strong><?= $day ?>:</strong> <?= implode(', ', $slots) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Booking Form -->
      <form method="POST" action="save_appointment.php">
        <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">

        <label>Select Specialist:</label>
        <select name="specialist" class="form-select mb-3" required>
          <option value="8">Dr. Santos – Psychologist</option>
          <option value="9">Dr. Reyes – Psychiatrist</option>
        </select>

        <label>Date:</label>
        <input type="date" name="date" class="form-control mb-3" required>

        <label>Time:</label>
        <select name="time" id="time-select" class="form-select mb-3" required>
          <option value="">Select a time</option>
        </select>

        <button type="submit" class="btn btn-primary">Book Appointment</button>
      </form>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const availability = {
      8: {
        Monday: ['09:00 AM', '10:00 AM', '02:00 PM'],
        Tuesday: ['09:00 AM', '11:00 AM'],
        Wednesday: ['10:00 AM', '01:00 PM'],
        Thursday: ['09:00 AM', '03:00 PM'],
        Friday: ['10:00 AM', '02:00 PM']
      },
      9: {
        Monday: ['08:00 AM', '01:00 PM'],
        Tuesday: ['10:00 AM', '03:00 PM'],
        Wednesday: ['09:00 AM', '11:00 AM'],
        Thursday: ['08:00 AM', '12:00 PM'],
        Friday: ['09:00 AM', '01:00 PM']
      }
    };

    document.querySelector('select[name="specialist"]').addEventListener('change', updateTimes);
    document.querySelector('input[name="date"]').addEventListener('change', updateTimes);

    function updateTimes() {
      const specialist = document.querySelector('select[name="specialist"]').value;
      const dateInput = document.querySelector('input[name="date"]').value;
      const timeSelect = document.getElementById('time-select');

      timeSelect.innerHTML = '<option value="">Select a time</option>';

      if (!specialist || !dateInput) return;

      const date = new Date(dateInput);
      const day = date.toLocaleDateString('en-US', { weekday: 'long' });

      if (availability[specialist] && availability[specialist][day]) {
        availability[specialist][day].forEach(time => {
          const option = document.createElement('option');
          option.value = time;
          option.textContent = time;
          timeSelect.appendChild(option);
        });
      }
    }

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