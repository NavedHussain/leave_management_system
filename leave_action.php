<?php
require('top.inc.php');

if($_SESSION['role']!=1){
    die("Access Denied");
}

if(isset($_GET['id']) && isset($_GET['action'])){
    $id = mysqli_real_escape_string($con,$_GET['id']);
    $action = $_GET['action'];
    
    if($action=="approve"){
        $status = 1;
    } elseif($action=="reject"){
        $status = 2;
    } else {
        die("Invalid Action");
    }

    mysqli_query($con,"UPDATE `leave` SET leave_status='$status' WHERE id='$id'");
}

header('Location: leave.php');
die();


