<?php
session_start();
if (!isset($_SESSION['user'])) header("Location: login.php");
include 'db.php';

$user = $_SESSION['user'];
$user_id = $user['id'];

// Fetch unread notifications
$result = $conn->query("SELECT * FROM notifications WHERE user_id = $user_id AND is_read = 0 ORDER BY created_at DESC");
$notifications = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css"/>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center">
      <h4>Welcome, <?= htmlspecialchars($user['fullname']) ?> 👋</h4>
      <a href="logout.php" class="btn btn-outline-danger">Logout</a>
    </div>
    <hr>
    <p>This is your dashboard. You can now access assessments, appointments, and more.</p>

    <!-- Notifications Section -->
    <div class="mt-4 card card-notifications">
      <div class="card-body">
        <h5 class="card-title">🔔 Notifications</h5>
        <?php if (count($notifications) === 0): ?>
          <div class="alert alert-secondary">No new notifications.</div>
        <?php else: ?>
          <ul class="list-group">
            <?php foreach ($notifications as $note): ?>
              <li class="list-group-item">
                <?= htmlspecialchars($note['message']) ?>
                <br><small class="text-muted"><?= date('M d, H:i', strtotime($note['created_at'])) ?></small>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>

    <!-- Services Section -->
    <div class="mt-5 card card-services">
      <div class="card-body">
        <h5 class="card-title">💼 Our Services</h5>
        <button class="btn btn-primary w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#servicesList">
          Show Services
        </button>
        <div class="collapse" id="servicesList">
          <ol class="list-group list-group-numbered">
            <li class="list-group-item">Mental Health Assessments</li>
            <li class="list-group-item">Personalized Recommendations</li>
            <li class="list-group-item">Appointment Booking with Specialists</li>
            <li class="list-group-item">Progress Tracking Dashboard</li>
          </ol>
        </div>
      </div>
    </div>

    <!-- Therapies Section -->
    <div class="mt-4 card card-therapies">
      <div class="card-body">
        <h5 class="card-title">🧑‍⚕️ Therapies We Offer</h5>
        <button class="btn btn-success w-100 mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#therapiesList">
          Show Therapies
        </button>
        <div class="collapse" id="therapiesList">
          <ol class="list-group list-group-numbered">
            <li class="list-group-item">Cognitive Behavioral Therapy (CBT)</li>
            <li class="list-group-item">Mindfulness-Based Therapy</li>
            <li class="list-group-item">Interpersonal Therapy</li>
            <li class="list-group-item">Supportive Counseling</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS for collapse functionality -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>