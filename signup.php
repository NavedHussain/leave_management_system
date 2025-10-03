<?php
include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup | LMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      
  background: #000; 
  height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;


    }
    .card {
      width: 400px;
      padding: 25px;
      border-radius: 15px;
      box-shadow: 0px 8px 20px rgba(0,0,0,0.2);
      animation: slideIn 1s ease;
    }
    @keyframes slideIn {
      from { transform: translateY(-50px); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }
    .btn-custom {
      background: #28a745;
      border: none;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background: #218838;
      transform: scale(1.05);
    }
  </style>
</head>
<body>
  <div class="card">
    <h3 class="text-center mb-3">Signup</h3>
    <form action="signup.php" method="post">
      <div class="mb-3">
        <label class="form-label">name</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <!-- <button type="submit" class="btn btn-custom w-100">Signup</button> -->
      <button type="submit" name="signup" class="btn btn-custom w-100">Signup</button>
      <p class="text-center mt-3">Already have an account? <a href="login.php">Login</a></p>
    </form>
  </div>
</body>
</html>

<?php
session_start();
include __DIR__ . '/includes/config.php'; // make sure $con is defined here

if (isset($_POST['signup'])) {
    // Collect form inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format'); window.location='signup.php';</script>";
        exit;
    }

    // Escape email to avoid SQL injection
    $email = mysqli_real_escape_string($con, $email);

    // Check if email already exists
    $check_query = "SELECT id FROM employee WHERE email = '$email'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Email already registered! Please login.'); window.location='login.php';</script>";
        exit;
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Default values
    $mobile = '';
    $department_id = 3;
    $address = '';
    $birthday = '0000-00-00';
    $role = 2;

    // Escape all other inputs
    $name = mysqli_real_escape_string($con, $name);

    // Insert user
    $insert_query = "INSERT INTO employee (name, email, mobile, password, department_id, address, birthday, role) 
                     VALUES ('$name', '$email', '$mobile', '$hashed_password', '$department_id', '$address', '$birthday', '$role')";

    if (mysqli_query($con, $insert_query)) {
        echo "<script>alert('Signup successful! Please login.'); window.location='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('Signup failed. Try again.'); window.location='signup.php';</script>";
        exit;
    }
}
?>