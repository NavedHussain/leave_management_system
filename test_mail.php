<?php
include 'includes/send_mail.php';  

$employeeEmail = "employee@example.com";      
$adminEmail = "navedhussain1803@gmail.com";    
$subjectEmployee = "Leave Request Submitted";
$bodyEmployee = "<h3>Your leave request has been submitted successfully.</h3>";
$subjectAdmin = "New Leave Request Submitted";
$bodyAdmin = "<h3>A new leave request has been submitted by Employee.</h3>";
sendMail($employeeEmail, $subjectEmployee, $bodyEmployee);
sendMail($adminEmail, $subjectAdmin, $bodyAdmin);

echo "✅ Leave request emails sent to Employee and Admin.";
?>
