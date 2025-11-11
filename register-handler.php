<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'db.php';

$fullname = trim($_POST['fullname']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$gender = $_POST['gender']; 

// Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
  header("Location: register.php?error=Email already registered");
  exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert new user with gender
$stmt = $conn->prepare("INSERT INTO users (fullname, email, password, gender) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $fullname, $email, $hashed_password, $gender);

if ($stmt->execute()) {
  header("Location: register.php?success=1");
} else {
  header("Location: register.php?error=Registration failed");
}
exit;