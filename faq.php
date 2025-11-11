<?php
session_start();
include 'db.php';  
$user_name = $_SESSION['user']['name'] ?? 'Guest';  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <title>FAQ - MindCare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body class="faq-page">
  <div class="d-flex">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar d-flex flex-column align-items-center p-3">
      <!-- Logo -->
      <div class="logo-wrapper mb-3">
        <img src="images/MindCare.png" alt="MindCare Logo" class="logo-img" style="max-width: 120px;" />
      </div>

      <!-- Resources Dropdown -->
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

      <!-- Navigation Links -->
      <nav class="nav flex-column w-100 text-center">
        <a class="nav-link fw-bold" href="assessment.php">Assessment</a>
        <a class="nav-link" href="recommendations.php">Recommendations</a>
        <a class="nav-link" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link" href="appointments.php">My Appointments</a>
        <a class="nav-link" href="profile.php">Profile</a>
        <a class="nav-link" href="faq.php">FAQ</a>
        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
      </nav>

      <!-- Theme Toggle -->
      <button id="themeToggle" class="btn btn-outline-light d-flex align-items-center gap-2 mt-4">
        <span id="themeIcon">🌞</span>
        <span id="themeLabel">Light Mode</span>
      </button>
    </div>

    <!-- Main Content -->
    <div class="container py-5 fade-in">
      <h2 class="fw-bold mb-4 text-center">❓ Frequently Asked Questions</h2>
      <div class="accordion" id="faqAccordion">
        <!-- Question 1 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1-heading">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true">
              How do I take a mental health assessment?
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Go to the <a href="assessment.php">Assessment</a> page and answer the questions honestly. Your results will be summarized and stored for future reference.
            </div>
          </div>
        </div>

        <!-- Question 2 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
              How do I book or reschedule an appointment?
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Visit the <a href="book_appointment.php">Book Appointment</a> page to schedule a session. To reschedule, go to <a href="appointments.php">My Appointments</a> and select "Reschedule".
            </div>
          </div>
        </div>

        <!-- Question 3 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq3-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
              What is dark mode and how do I enable it?
            </button>
          </h2>
          <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Dark mode reduces eye strain and saves battery. Click the 🌞/🌙 toggle in the sidebar to switch themes. Your preference is saved automatically.
            </div>
          </div>
        </div>

        <!-- Question 4 -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq4-heading">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
              Is my data private and secure?
            </button>
          </h2>
          <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
              Yes. Your data is stored securely and only accessible to authorized professionals. We follow strict confidentiality and data protection standards.
            </div>
          </div>
        </div>
      </div>

      <div class="text-center mt-5">
        <a href="index.php" class="btn btn-outline-primary">← Back to Dashboard</a>
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