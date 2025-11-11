<?php
session_start();
include 'db.php';

$user_id = $_SESSION['user']['id'];

$result = $conn->query("
  SELECT a.id, a.appointment_date, a.appointment_time, a.status, u.fullname AS specialist_name
  FROM appointments a
  JOIN users u ON a.specialist_id = u.id
  WHERE a.user_id = $user_id
  ORDER BY a.appointment_date ASC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Appointments</title>
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
        <a class="nav-link" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link fw-bold" href="appointments.php">My Appointments</a>
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
      <h3 class="mb-4">My Appointments</h3>

      <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($_GET['success']) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php endif; ?>

      <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
          <thead class="table-light">
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Specialist</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= date('M d, Y', strtotime($row['appointment_date'])) ?></td>
                <td><?= date('g:i A', strtotime($row['appointment_time'])) ?></td>
                <td><?= htmlspecialchars($row['specialist_name']) ?></td>
                <td><span class="badge bg-info"><?= $row['status'] ?></span></td>
                <td class="d-flex gap-2">
                  <form method="POST" action="delete_appointment.php" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                    <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                  </form>
                  <form method="GET" action="reschedule_appointment.php">
                    <input type="hidden" name="appointment_id" value="<?= $row['id'] ?>">
                    <button type="submit" class="btn btn-sm btn-outline-warning">Reschedule</button>
                  </form>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="alert alert-info">You have no appointments yet.</div>
      <?php endif; ?>

      <a href="index.php" class="btn btn-outline-secondary mt-4">🏠 Back to Home</a>
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