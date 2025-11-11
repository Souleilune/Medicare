<?php
session_start();
include 'db.php';

$user_id = $_POST['user_id'];
$q1 = (int)$_POST['q1'];
$q2 = (int)$_POST['q2'];
$score = $q1 + $q2;

// Interpret score
if ($score <= 2) {
  $summary = "Mild symptoms";
} elseif ($score <= 4) {
  $summary = "Moderate symptoms";
} else {
  $summary = "Severe symptoms";
}

// Save to database
$stmt = $conn->prepare("INSERT INTO assessments (user_id, score, summary) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $score, $summary);
$success = $stmt->execute();

// Add notification
if ($success) {
  $message = "Your new mental health assessment has been submitted.";
  $notify = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (?, ?)");
  $notify->bind_param("is", $user_id, $message);
  $notify->execute();
}

header("Location: recommendations.php");
exit;
?>