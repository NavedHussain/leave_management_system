<?php
session_start();
include __DIR__ . '/includes/config.php';

$msg = '';

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];

    // Query user by email
    $query = "SELECT id, name, password, role FROM employee WHERE email = '$email'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
      //   echo "<pre>";
      //   print_r($row);
        // Verify password
      //   echo("hello");
        print_r(password_verify($password, $row['password']));
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 1) {
                header("Location: dashboard.php");
            } else {
                header("Location: employee.php");
            }
            exit;
        } else {
            $msg = "Invalid password";
        }
    } else {
        $msg = "No account found with this email";
    }
}
?>



<!doctype html>
<html class="no-js" lang="">
   <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Login Page</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="assets/css/normalize.css">
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/css/themify-icons.css">
      <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
      <link rel="stylesheet" href="assets/css/flag-icon.min.css">
      <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
      <link rel="stylesheet" href="assets/css/style.css">
      <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
   </head>
   <body class="bg-dark">
      <div class="sufee-login d-flex align-content-center flex-wrap">
         <div class="container">
            <div class="login-content">
               <div class="login-form mt-150">
                  <form method="post">
                     <div class="form-group">
                        <label>Email address</label>
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                     </div>
                     <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                     </div>
                     <!-- <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Login</button> -->
                     <button type="submit" name="login" class="btn btn-success btn-flat m-b-30 m-t-30">Login</button>
                     <p class="text-center mt-3">Don't have an account? <a href="signup.php">Signup</a></p>
					 <div class="result_msg"><?php echo $msg?></div>
					</form>
               </div>
            </div>
         </div>
      </div>
      <script src="assets/js/vendor/jquery-2.1.4.min.js" type="text/javascript"></script>
      <script src="assets/js/popper.min.js" type="text/javascript"></script>
      <script src="assets/js/plugins.js" type="text/javascript"></script>
      <script src="assets/js/main.js" type="text/javascript"></script>
   </body>
</html>