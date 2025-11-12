<?php
session_start();
if (isset($_SESSION['user']))
  header("Location: dashboard.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>MindCare Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="login-page">
   <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

      <!-- Left Side: Logo + Pre-Assessment -->
      <div class="col-md-6 info-side">
        <!-- <img src="images/Mindcare.png" alt="MindCare Logo" class="img-fluid" style="height: 400px;" /> -->
        <p class="text-muted text-center fst-italic">Where healing meets understanding.</p>
        <p>Take a Quick Pre-Assessment</p>
        <a href="pre_assessment.php" class="btn btn-outline-primary">Start Here</a>
      </div>

      <!-- Right Side: Login Form -->
      <div class="col-md-6 login-form-side">
        <div class="login-container fade-in text-center">
          <h3 class="mb-1 fw-bold text-start to left-align">Hello Again!</h3>
          <small class="text-muted d-block mb-4 text-start to left-align">Welcome Back</small>
          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
          <?php endif; ?>
          <form method="POST" action="login-handler.php">
            <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
            <div class="mb-3 password-wrapper">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
              <span class="toggle-password" onclick="togglePassword()">
                <i id="toggleIcon" class="fa-solid fa-eye"></i>
              </span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <div class="mt-3">
            <a href="forgot-password.php">Forgot Password?</a>
            <div class="mt-2">
              <small>No account yet?</small>
              <a href="register.php" class="text-primary fw-semibold small">Sign up!</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script>
    function togglePassword() {
      const passwordField = document.getElementById("password");
      const toggleIcon = document.getElementById("toggleIcon");
      if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.remove("fa-eye");
        toggleIcon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        toggleIcon.classList.remove("fa-eye-slash");
        toggleIcon.classList.add("fa-eye");
      }
    }
  </script>
</body>
</html>