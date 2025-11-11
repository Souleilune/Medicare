<?php
include 'db.php';

$user_id = $_POST['user_id'];
$specialist_id = $_POST['specialist'];
$date = $_POST['date'];
$time = $_POST['time'];

// Checks existing appointment
$check = $conn->prepare("SELECT * FROM appointments WHERE specialist_id = ? AND appointment_date = ? AND appointment_time = ?");
$check->bind_param("iss", $specialist_id, $date, $time);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {
  echo "<script>alert('This time slot is already booked. Please choose another.'); window.history.back();</script>";
  exit;
}

// ✅ Insert the appointment
$stmt = $conn->prepare("
  INSERT INTO appointments (user_id, specialist_id, appointment_date, appointment_time, status)
  VALUES (?, ?, ?, ?, 'Confirmed')
");
$stmt->bind_param("iiss", $user_id, $specialist_id, $date, $time);
$stmt->execute();

// ✅ Redirect after saving
header("Location: appointments.php");
exit;
?>