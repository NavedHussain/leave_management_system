<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 2) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <div class="container mt-5">
    <h2>Welcome User: <?php echo htmlspecialchars($_SESSION['user_name']); ?></h2>
    <p>This is your dashboard. You can navigate to:</p>
    <ul>
      <li><a href="leave.php">Apply Leave</a></li>
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
  </div>
</body>
</html>
