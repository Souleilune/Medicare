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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    /* Poppins font for consistency */
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');

    :root{
      --teal-1: #5ad0be;
      --teal-2: #1aa592;
      --teal-3: #0a6a74;
      --line: #e9edf5;
      --field-bg: #f6f7fb;
      --field-text: #2b2f38;
      --muted: #7a828e;
      --btn-from: #38c7a3;
      --btn-to: #2fb29c;
    }

    body {
      font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
      color: var(--field-text);
      min-height: 100vh;
      overflow: hidden;
      background: #fff;
    }

    /* Split layout */
    .register-page {
      min-height: 100vh;
      overflow: hidden;
      background: #fff;
    }
    .register-page .row {
      min-height: 100vh;
    }

    /* Left panel (Logo + Pre-Assessment) - matching login.php */
    .info-side {
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: flex-start;
      text-align: left;
      padding: 0 72px;
      color: #fff;
      background:
        radial-gradient(900px 500px at -10% 115%, rgba(255,255,255,.15) 0%, transparent 60%),
        linear-gradient(135deg, var(--teal-1) 0%, var(--teal-2) 48%, var(--teal-3) 100%);
      border-right: 1px solid var(--line);
      overflow: hidden;
    }

    /* Rounded ornament arcs */
    .info-side::before,
    .info-side::after {
      content: '';
      position: absolute;
      bottom: -180px;
      left: -180px;
      border-radius: 50%;
      border: 1px solid rgba(255,255,255,.25);
      pointer-events: none;
    }
    .info-side::before {
      width: 520px; 
      height: 520px;
    }
    .info-side::after {
      width: 700px; 
      height: 700px;
      border-color: rgba(255,255,255,.15);
    }

    /* Logo and copy */
    .info-side img {
      height: 140px;
      width: auto;
      margin: 0 0 24px 0;
    }
    .info-side h4 {
      font-size: 40px;
      line-height: 1.1;
      font-weight: 700;
      margin: 8px 0 10px;
      color: #fff;
    }
    .info-side p {
      font-size: 16px;
      color: rgba(255,255,255,.9);
      margin-bottom: 18px;
    }
    .info-side .text-muted {
      color: rgba(255,255,255,.85) !important;
      font-weight: 500;
    }

    /* CTA button */
    .info-side a.btn-outline-primary {
      background: rgba(255,255,255,.20);
      color: #fff;
      border: none;
      padding: 12px 20px;
      border-radius: 999px;
      font-weight: 600;
      box-shadow: inset 0 0 0 1px rgba(255,255,255,.25);
      transition: transform .15s ease, background .2s ease;
    }
    .info-side a.btn-outline-primary:hover {
      background: rgba(255,255,255,.28);
      transform: translateY(-1px);
    }

    /* Right panel (Register form) */
    .register-form-side {
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 32px;
    }

    .register-container {
      background: transparent;
      box-shadow: none;
      border-radius: 0;
      width: 380px;
      max-width: 90%;
      padding: 0;
      text-align: left;
    }

    /* Titles */
    .register-container h3 {
      font-size: 28px;
      font-weight: 700;
      color: var(--field-text);
      margin-bottom: 6px;
    }
    .register-container .subtitle,
    .register-container small {
      color: var(--muted);
    }

    /* Alerts */
    .register-container .alert {
      border: none;
      border-radius: 10px;
      background: #ffe6e8;
      color: #9b1c1f;
      margin-bottom: 20px;
    }
    .register-container .alert-success {
      background: #d4edda;
      color: #155724;
    }

    /* Input fields with icons */
    .register-container input[type="text"],
    .register-container input[type="email"],
    .register-container input[type="password"],
    .register-container select {
      background-color: var(--field-bg);
      border: none;
      height: 52px;
      border-radius: 999px;
      padding: 12px 18px;
      font-size: 15px;
      color: var(--field-text);
      box-shadow: 0 1px 0 rgba(0,0,0,0.02), 0 8px 24px rgba(18,38,63,0.03);
      transition: box-shadow .2s ease, background-color .2s ease;
    }

    /* Icons via padding */
    .register-container input.fullname-input { padding-left: 52px; }
    .register-container input[type="email"] { padding-left: 52px; }
    .register-container select { padding-left: 52px; }
    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] { 
      padding-left: 52px; 
      padding-right: 48px; 
    }

    /* Icon backgrounds using inline SVG */
    .register-container input.fullname-input {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2399A3AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2'/%3E%3Ccircle cx='12' cy='7' r='4'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 18px 50%;
    }

    .register-container input[type="email"]{
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2399A3AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Crect x='3' y='5' width='18' height='14' rx='2' ry='2'/%3E%3Cpolyline points='22,7 12,13 2,7'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 18px 50%;
    }

    .register-container select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%2399A3AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2'/%3E%3Ccircle cx='9' cy='7' r='4'/%3E%3Cpath d='M23 21v-2a4 4 0 0 0-3-3.87'/%3E%3Cpath d='M16 3.13a4 4 0 0 1 0 7.75'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: 18px 50%;
      appearance: none;
      cursor: pointer;
    }

    /* Password inputs should NOT have background images - icon comes from ::before pseudo-element */
    .password-wrapper input[type="password"],
    .password-wrapper input[type="text"] {
      background-image: none !important;
    }

    /* Password icon wrapper */
    .password-wrapper { 
      position: relative; 
    }
    .password-wrapper::before{
      content: "\f023";
      font-family: "Font Awesome 6 Free";
      font-weight: 900;
      font-size: 16px;
      color: #99A3AE;
      position: absolute;
      left: 18px;
      top: 50%;
      transform: translateY(-50%);
      z-index: 1;
      pointer-events: none;
    }

    /* Show/Hide toggle icon */
    .toggle-password {
      position: absolute;
      right: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #99A3AE;
      cursor: pointer;
      z-index: 2;
    }

    /* Focus states */
    .register-container input:focus,
    .register-container select:focus {
      background-color: #fff;
      box-shadow: 0 0 0 3px rgba(56,199,163,0.18);
      outline: none;
    }

    /* Register button with gradient */
    .register-container button,
    .register-container .btn-primary {
      background: linear-gradient(135deg, var(--btn-from) 0%, var(--btn-to) 100%);
      border: none;
      height: 56px;
      border-radius: 999px;
      font-weight: 600;
      font-size: 16px;
      letter-spacing: .2px;
      color: #fff;
      width: 100%;
      box-shadow: 0 10px 24px rgba(48,170,153,.35);
      transition: transform .15s ease, box-shadow .2s ease, opacity .2s ease;
    }
    .register-container button:hover {
      transform: translateY(-1px);
      box-shadow: 0 12px 28px rgba(48,170,153,.42);
    }

    /* Link styles */
    .register-container a {
      color: #7c8a99;
      text-decoration: none;
      font-weight: 500;
    }
    .register-container a:hover { 
      color: #5d6a78; 
      text-decoration: underline; 
    }
    .register-container a.text-primary {
      color: var(--teal-2) !important;
      font-weight: 600;
    }

    /* Fade animation */
    .fade-in {
      animation: fadeInUp .9s ease both;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(12px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive tweaks */
    @media (max-width: 992px) {
      .info-side { padding: 48px 40px; }
      .info-side img { height: 110px; }
    }
    @media (max-width: 768px) {
      .info-side {
        min-height: 44vh;
        border-right: none;
        padding: 40px 24px;
      }
      .register-form-side {
        min-height: 56vh;
        padding: 24px;
      }
      .register-container { width: 100%; max-width: 440px; }
    }
  </style>
</head>

<body class="register-page">
  <div class="container-fluid p-0">
    <div class="row g-0 min-vh-100">

      <!-- Left Side: Logo + Pre-Assessment -->
      <div class="col-md-6 info-side">
        <img src="images/MindCare.png" alt="MindCare Logo" class="img-fluid" />
        <h4>Join MindCare</h4>
        <p class="text-muted fst-italic">Start your mental wellness journey today.</p>
        <p>Already have an account?</p>
        <a href="login.php" class="btn btn-outline-primary">Sign In Here</a>
      </div>

      <!-- Right Side: Register Form -->
      <div class="col-md-6 register-form-side">
        <div class="register-container fade-in">
          <h3 class="mb-1">Create Account</h3>
          <small class="text-muted d-block mb-4">Please fill in your details</small>

          <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']) ?></div>
          <?php elseif (isset($_GET['success'])): ?>
            <div class="alert alert-success">
              Registration successful! You can now <a href="login.php" class="text-primary fw-semibold">log in</a>.
            </div>
          <?php endif; ?>

          <form method="POST" action="register-handler.php">
            <div class="mb-3">
              <input type="text" name="fullname" class="form-control fullname-input" placeholder="Full Name" required />
            </div>

            <div class="mb-3">
              <input type="email" name="email" class="form-control" placeholder="Email Address" required />
            </div>

            <div class="mb-3 password-wrapper">
              <input type="password" name="password" id="password" class="form-control" placeholder="Password" required />
              <span class="toggle-password" onclick="togglePassword()">
                <i id="toggleIcon" class="fa-solid fa-eye"></i>
              </span>
            </div>

            <div class="mb-3">
              <select name="gender" class="form-select" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
            </div>

            <button type="submit" class="btn btn-primary w-100">Create Account</button>
          </form>

          <div class="mt-3 text-center">
            <small>Already have an account?</small>
            <a href="login.php" class="text-primary fw-semibold small">Sign in!</a>
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