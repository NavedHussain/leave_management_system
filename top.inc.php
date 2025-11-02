<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/includes/config.php';


// Ensure session keys exist
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 0;

$msg = '';

if (isset($_POST['login'])) {
    // login code if needed
}

include('header.inc.php'); // include after login check
?>

<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Dashboard Page</title>
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
<body>
   <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
         <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
               <li class="menu-title">Menu</li>
               <?php if($role==1){ ?>
               <li class="menu-item-has-children dropdown">
                  <a href="index.php" > Department Master</a>
               </li>
               <li class="menu-item-has-children dropdown">
                  <a href="employee_add.php" > Add employee's</a>
               </li>
               <li class="menu-item-has-children dropdown">
                  <a href="employee.php" > Employee Master</a>
               </li>
               <li class="menu-item-has-children dropdown">
                  <a href="leave_type.php"> Leave Type Master</a>
               </li>
               <?php } else { ?>
                  <li class="menu-item-has-children dropdown">
                     <a href="add_employee.php?id=<?php echo $user_id?>" > Profile</a>
                  </li>
                  <?php } ?>
                  <li class="menu-item-has-children dropdown">
                     <a href="leave.php" > Leave</a>
                  </li>
                 <?php if (isset($_SESSION['ROLE']) && $_SESSION['ROLE'] == 1) { ?>
   <a href="/LMS_php/dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
<?php } else { ?>
   <a href="employee.php" class="back-btn">⬅ Back to Dashboard</a>
<?php } ?>

               </ul>
         </div>
      </nav>
   </aside>
   <div id="right-panel" class="right-panel">
      <header id="header" class="header">
         <div class="top-left">
            <div class="navbar-header">
               <a class="navbar-brand" href="index.php"><img src="images/logo.png" alt="Logo"></a>
               <a class="navbar-brand hidden" href="index.php"><img src="images/logo2.png" alt="Logo"></a>
               <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
            </div>
         </div>
         <div class="top-right">
            <div class="header-menu">
               <div class="user-area dropdown float-right">
                  <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome
                   <?php echo $user_name ?></a>
                  <div class="user-menu dropdown-menu">
                     <a class="nav-link" href="logout.php"><i class="fa fa-power-off"></i>Logout</a>
                  </div>
               </div>
            </div>
         </div>
      </header>
