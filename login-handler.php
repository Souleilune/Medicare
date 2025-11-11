<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT id, fullname, email, password, gender, role, created_at FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  header("Location: login.php?error=Email not found");
  exit;
}

$user = $result->fetch_assoc();

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