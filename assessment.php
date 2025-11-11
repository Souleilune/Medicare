<?php
session_start();
include 'db.php';

// ✅ Prevent undefined session error
$user_id = $_SESSION['user']['id'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Take Assessment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8f9fa;
      transition: background-color 0.3s, color 0.3s;
    }

    body.dark-mode {
      background-color: #121212;
      color: #f1f1f1;
    }

    .sidebar {
      width: 260px;
      min-height: 100vh;
      background-color: #198754;
      color: white;
    }

    .nav-link {
      padding: 0.6rem;
      transition: background-color 0.3s;
    }

    .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
    }

    #themeToggle {
      margin-top: 1rem;
      width: 100%;
    }

    .accordion-button:not(.collapsed) {
      background-color: #d1e7dd;
      color: #0f5132;
    }

    body.dark-mode .accordion-button:not(.collapsed) {
      background-color: #14532d;
      color: #fff;
    }
  </style>
</head>

<body>
  <div class="d-flex">
    <!-- ✅ Sidebar -->
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
        <a class="nav-link text-white fw-bold" href="assessment.php">Assessment</a>
        <a class="nav-link text-white" href="recommendations.php">Recommendations</a>
        <a class="nav-link text-white" href="book_appointment.php">Book Appointment</a>
        <a class="nav-link text-white" href="appointments.php">My Appointments</a>
        <a class="nav-link text-white" href="profile.php">Profile</a>
        <a class="nav-link text-white" href="faq.php">FAQ</a>
        <a class="nav-link text-danger fw-bold" href="logout.php">Logout</a>
      </nav>

      <button id="themeToggle" class="btn btn-outline-light d-flex align-items-center gap-2 mt-4">
  <span id="themeIcon">🌞</span>
  <span id="themeLabel">Light Mode</span>
</button>
  </div>

    <!-- ✅ Main Content -->
    <div class="flex-grow-1 p-4">
      <h3 class="mb-4">Mental Health & Self-Awareness Assessment</h3>

      <form method="POST" action="save_assessment.php">
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

        <div class="accordion" id="assessmentAccordion">

          <!-- ✅ Section 1 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#sectionOne">
                Orientation and Awareness
              </button>
            </h2>
            <div id="sectionOne" class="accordion-collapse collapse show" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <input type="text" name="orientation_0" class="form-control mb-2" placeholder="Your full name" required>
                <input type="text" name="orientation_1" class="form-control mb-2" placeholder="Where are you right now?" required>
                <input type="text" name="orientation_2" class="form-control mb-2" placeholder="What time is it?" required>
                <input type="text" name="orientation_3" class="form-control mb-2" placeholder="Today's date or approximate date" required>
                <input type="text" name="orientation_4" class="form-control mb-2" placeholder="What brought you here today?" required>
              </div>
            </div>
          </div>

          <!-- ✅ Section 2 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionTwo">
                Emotional Well-Being
              </button>
            </h2>
            <div id="sectionTwo" class="accordion-collapse collapse" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <input type="text" name="emotions_0" class="form-control mb-2" placeholder="Describe your mood right now" required>
                <input type="text" name="emotions_1" class="form-control mb-2" placeholder="Most common feelings this week" required>
                <input type="text" name="emotions_2" class="form-control mb-2" placeholder="Something worrying or upsetting you" required>
                <input type="text" name="emotions_3" class="form-control mb-2" placeholder="When do you feel calm or anxious?" required>
                <input type="text" name="emotions_4" class="form-control mb-2" placeholder="Do you feel supported?" required>
              </div>
            </div>
          </div>

          <!-- ✅ Section 3 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionThree">
                Memory and Concentration
              </button>
            </h2>
            <div id="sectionThree" class="accordion-collapse collapse" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <input type="text" name="memory_initial" class="form-control mb-2" placeholder="Repeat: Leaf – Phone – Chair" required>
                <input type="text" name="memory_recall" class="form-control mb-2" placeholder="Recall the three words after 5 minutes" required>
              </div>
            </div>
          </div>

          <!-- ✅ Section 4 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionFour">
                Thought and Perception
              </button>
            </h2>
            <div id="sectionFour" class="accordion-collapse collapse" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <input type="text" name="thoughts_0" class="form-control mb-2" placeholder="Disturbing or hard-to-control thoughts?" required>
                <input type="text" name="thoughts_1" class="form-control mb-2" placeholder="Feeling others are against you?" required>
                <input type="text" name="thoughts_2" class="form-control mb-2" placeholder="Hearing or seeing things others don’t?" required>
                <input type="text" name="thoughts_3" class="form-control mb-2" placeholder="Feeling disconnected from others?" required>
              </div>
            </div>
          </div>

          <!-- ✅ Section 5 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingFive">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionFive">
                Decision-Making and Insight
              </button>
            </h2>
            <div id="sectionFive" class="accordion-collapse collapse" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <input type="text" name="decisions_0" class="form-control mb-2" placeholder="How would you help a crying friend?" required>
                <input type="text" name="decisions_1" class="form-control mb-2" placeholder="What does mental health care mean to you?" required>
                <input type="text" name="decisions_2" class="form-control mb-2" placeholder="Are you ready to make changes?" required>
              </div>
            </div>
          </div>

          <!-- ✅ Section 6 -->
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingSix">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sectionSix">
                Core Assessment
              </button>
            </h2>
            <div id="sectionSix" class="accordion-collapse collapse" data-bs-parent="#assessmentAccordion">
              <div class="accordion-body">
                <label>How often have you felt anxious this week?</label>
                <select name="q1" class="form-select mb-3">
                  <option value="0">Not at all</option>
                  <option value="1">Several days</option>
                  <option value="2">More than half the days</option>
                  <option value="3">Nearly every day</option>
                </select>

                <label>How often have you felt down or depressed?</label>
                <select name="q2" class="form-select mb-3">
                  <option value="0">Not at all</option>
                  <option value="1">Several days</option>
                  <option value="2">More than half the days</option>
                  <option value="3">Nearly every day</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn btn-primary mt-4">Submit Assessment</button>
      </form>
    </div>
  </div>

  <!-- ✅ Scripts -->
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
      icon.textContent = isDark ? '🌙' : '🌞';
      label.textContent = isDark ? 'Dark Mode' : 'Light Mode';
    });
  </script>
</body>
</html>