<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit;
}
include 'db.php';

$user_id = $_SESSION['user']['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fullname = trim($_POST['fullname']);
  $gender = $_POST['gender'];
  $role = $_POST['role'];

  $stmt = $conn->prepare("UPDATE users SET fullname = ?, gender = ?, role = ? WHERE id = ?");
  $stmt->bind_param("sssi", $fullname, $gender, $role, $user_id);

  if ($stmt->execute()) {
    $_SESSION['user']['fullname'] = $fullname;
    $_SESSION['user']['gender'] = $gender;
    $_SESSION['user']['role'] = $role;

    header("Location: profile.php?success=Profile updated");
    exit;
  } else {
    $error = "Failed to update profile.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css" />
</head>
<body class="container mt-5">
  <h2>Edit Profile</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="fullname" class="form-label">Full Name</label>
      <input type="text" name="fullname" class="form-control" value="<?= htmlspecialchars($_SESSION['user']['fullname']) ?>" required />
    </div>

    <div class="mb-3">
      <label for="gender" class="form-label">Gender</label>
      <select name="gender" class="form-select" required>
        <option value="Male" <?= $_SESSION['user']['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $_SESSION['user']['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= $_SESSION['user']['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="role" class="form-label">Role</label>
      <select name="role" class="form-select" required>
        <option value="Patient" <?= $_SESSION['user']['role'] === 'Patient' ? 'selected' : '' ?>>Patient</option>
        <option value="Specialist" <?= $_SESSION['user']['role'] === 'Specialist' ? 'selected' : '' ?>>Specialist</option>
      </select>
    </div>

    <button type="submit" class="btn btn-primary">Save Changes</button>
    <a href="profile.php" class="btn btn-secondary">Cancel</a>
  </form>
</body>
</html>