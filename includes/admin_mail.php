<?php
// Include required files
include 'send_mail.php';
include 'config.php'; // Ensure $con (database connection) is available

/**
 * Send leave status notification to employee when admin approves or rejects.
 *
 * @param int $leave_id  Leave application ID
 * @param string $action  'approved' or 'rejected'
 * @return bool
 */
function notifyEmployeeOnLeaveAction($leave_id, $action) {
    global $con;

    // Fetch employee and leave details
    $sql = "
        SELECT 
            e.email, 
            e.name, 
            lt.leave_type, 
            l.leave_from, 
            l.leave_to, 
            l.leave_description
        FROM 
            `leave` AS l
        JOIN 
            employee AS e ON l.employee_id = e.id
        JOIN 
            leave_type AS lt ON l.leave_id = lt.id
        WHERE 
            l.id = '$leave_id'
        LIMIT 1
        ";

    $res = mysqli_query($con, $sql);

    if (!$res || mysqli_num_rows($res) === 0) {
        return false;
    }

    $row = mysqli_fetch_assoc($res);

    $employeeEmail = $row['email'];
    $employeeName = $row['name'];
    $leaveType = $row['leave_type'];
    $leaveFrom = $row['leave_from'];
    $leaveTo = $row['leave_to'];
    $leaveDescription = $row['leave_description'];

    // Admin email (sender)
    $adminRes = mysqli_query($con,"Select name,email from employee Where role=1 Limit 1");
    $adminRow = mysqli_fetch_assoc($adminRes);
    $adminEmail = $adminRow['email'];
    $adminName = $adminRow['name'];

    // Prepare mail to employee
    $subjectEmployee = "Leave Request " . ucfirst($action);
    $bodyEmployee = "
        <h3>Dear {$employeeName},</h3>
        <p>Your leave request has been <strong>{$action}</strong> by Admin.</p>
        <p><strong>Leave Type:</strong> {$leaveType}</p>
        <p><strong>From:</strong> {$leaveFrom}</p>
        <p><strong>To:</strong> {$leaveTo}</p>
        <p><strong>Description:</strong> {$leaveDescription}</p>
        <br>
        <p>Best regards,<br>{$adminName}</p>
    ";

    // Send email using sendMail function
    return sendMail($employeeEmail, $subjectEmployee, $bodyEmployee);
}
?>