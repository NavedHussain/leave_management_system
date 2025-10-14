<?php
include 'includes/send_mail.php';
$employeeEmail = "employee@example.com";       
$adminEmail = "navedhussain1803@gmail.com";  
$action = "approved"; 
$subjectEmployee = "Leave Request " . ucfirst($action);
$bodyEmployee = "<h3>Your leave request has been $action by Admin.</h3>";
sendMail($employeeEmail, $subjectEmployee, $bodyEmployee);
$subjectAdmin = "You have $action a leave request";
$bodyAdmin = "<h3>Leave request has been $action successfully.</h3>";
sendMail($adminEmail, $subjectAdmin, $bodyAdmin);
echo "✅ Admin action done. Employee notified and Admin confirmed.";
?>
