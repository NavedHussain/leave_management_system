<?php
require('top.inc.php');

// Admin check
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('location:add_employee.php?id=' . $_SESSION['user_id']);
    die();
}

// Stats
$totalDepartments = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM department"))['total'];
$totalEmployees = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM employee"))['total'];
$pendingLeaves = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM `leave` WHERE leave_status=0"))['total'];
$approvedLeaves = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(*) AS total FROM `leave` WHERE leave_status=1"))['total'];
?>

<style>
body {
    background-color: #0f1117;
    overflow-x: hidden;
}
.content {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 90vh;
    padding: 0;
}
.dashboard-container {
    text-align: center;
    background: #1c1f26;
    border-radius: 15px;
    padding: 50px 60px;
    box-shadow: 0px 8px 25px rgba(0,0,0,0.4);
    margin: 0 auto;
    max-width: 1000px;
}
.dashboard-title {
    font-size: 32px;
    font-weight: 700;
    color: #f8f9fa;
    margin-bottom: 35px;
}
.dashboard-row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}
.dashboard-card {
    width: 230px;
    height: 140px;
    border-radius: 12px;
    color: #fff;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.dashboard-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 22px rgba(0,0,0,0.3);
}
.blue { background-color: #007bff; }
.green { background-color: #28a745; }
.yellow { background-color: #ffc107; color: #000; }
.cyan { background-color: #17a2b8; }
.dashboard-card h4 {
    margin: 0;
    font-size: 18px;
    letter-spacing: 0.5px;
}
.dashboard-card h2 {
    margin-top: 10px;
    font-size: 36px;
    font-weight: bold;
}
.back-btn {
    display: inline-block;
    margin-top: 30px;
    background: #ffffff;
    color: #222;
    border-radius: 8px;
    padding: 10px 25px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}
.back-btn:hover {
    background: #f1f1f1;
}
</style>

<div class="content pb-0">
    <div class="dashboard-container">
        <h2 class="dashboard-title">Admin Dashboard</h2>

        <div class="dashboard-row">
            <div class="dashboard-card blue">
                <h4>Total Departments</h4>
                <h2><?php echo $totalDepartments; ?></h2>
            </div>
            <div class="dashboard-card green">
                <h4>Total Employees</h4>
                <h2><?php echo $totalEmployees; ?></h2>
            </div>
            <div class="dashboard-card yellow">
                <h4>Pending Leaves</h4>
                <h2><?php echo $pendingLeaves; ?></h2>
            </div>
            <div class="dashboard-card cyan">
                <h4>Approved Leaves</h4>
                <h2><?php echo $approvedLeaves; ?></h2>     
                       <!-- ketne Leave Approved hai uske number -->
            </div>
        </div>

        <!-- <a href="index.php" class="back-btn">⬅ Back to Dashboard</a> -->
    </div>
</div>

<?php
require('footer.inc.php');
?>