<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'supabase.php';

$email = $_POST['email'];
$password = $_POST['password'];

// Get user by email
$users = supabaseSelect('users', ['email' => $email]);

if (empty($users)) {
  header("Location: login.php?error=Email not found");
  exit;
}

$user = $users[0];

if (!password_verify($password, $user['password'])) {
  header("Location: login.php?error=Incorrect password");
  exit;
}

$_SESSION['user'] = [
  'id' => $user['id'],
  'fullname' => $user['fullname'],
  'email' => $user['email'],
  'gender' => $user['gender'],
  'role' => $user['role'],
  'created_at' => $user['created_at']
];

if ($user['role'] === 'Admin') {
  header("Location: admin_appointments.php");
} elseif ($user['role'] === 'Specialist') {
  header("Location: specialist_dashboard.php");
} else {
  header("Location: index.php");
}
exit;