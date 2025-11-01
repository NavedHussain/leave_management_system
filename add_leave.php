<?php
require('top.inc.php');
include 'includes/send_mail.php';

if(isset($_POST['submit'])){
    $leave_id = mysqli_real_escape_string($con,$_POST['leave_id']);
    $leave_from = mysqli_real_escape_string($con,$_POST['leave_from']);
    $leave_to = mysqli_real_escape_string($con,$_POST['leave_to']);
    $employee_id = $_SESSION['user_id'];
    $leave_description = mysqli_real_escape_string($con,$_POST['leave_description']);
    $document = null;
    if(isset($_FILES['document']) && $_FILES['document']['name'] != ''){
        $allowed_types = ['image/png','image/jpg','image/jpeg','application/pdf'];
        $max_size = 5*1024*1024;
        if(in_array($_FILES['document']['type'],$allowed_types) && $_FILES['document']['size'] <= $max_size){
            $ext = pathinfo($_FILES['document']['name'], PATHINFO_EXTENSION);
            $document = time().'_'.rand(1000,9999).'.'.$ext;
            if(!is_dir('uploads')) mkdir('uploads',0777,true);
            move_uploaded_file($_FILES['document']['tmp_name'],'uploads/'.$document);
        } else {
            echo "<script>alert('Invalid file type or file too large');</script>";
            $document = null;
        }
    }

    mysqli_query($con,"INSERT INTO `leave`(leave_id, leave_from, leave_to, employee_id, leave_description, leave_status)
                      VALUES('$leave_id','$leave_from','$leave_to','$employee_id','$leave_description',0)");
                    
    $adminRes = mysqli_query($con,"Select email from employee Where role=1 Limit 1");
    $adminRow = mysqli_fetch_assoc($adminRes);
    $adminEmail = $adminRow['email'];

    // Get employee name

$empRes = mysqli_query($con, "SELECT name FROM employee

WHERE id='$employee_id' LIMIT 1");

$empRow = mysqli_fetch_assoc($empRes);

$employeeName = $empRow ? $empRow['name']: 'Employee';

// Get leave type

$leaveTypeRes = mysqli_query($con, "SELECT leave_type FROM

leave_type WHERE id='$leave_id' LIMIT 1");

$leaveTypeRow = mysqli_fetch_assoc($leaveTypeRes);

$leaveType = $leaveTypeRow ? $leaveTypeRow['leave_type']:'Leave';

    if($adminEmail){

        $subject = "New Leave Application Submitted";

        $body = "<h3>New Leave Application</h3>

        <p><strong>Employee:</strong> (SemployeeName}</p>

        <p><strong>Leave Type:</strong> ($leaveType}</p>

        <p><strong>From:</strong> ($leave_from)</p>

        <p><strong>To:</strong> ($leave_to)</p>

        <p><strong>Description:</strong>

        (Sleave_description}</p>";

        sendMail($adminEmail, $subject, $body);
            header('Location: leave.php');
            die();
        }
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><strong>Apply Leave</strong><small> Form</small></div>
                    <div class="card-body card-block">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select name="leave_id" class="form-control" required>
                                    <option value="">Select Leave</option>
                                    <?php
                                    $res=mysqli_query($con,"SELECT * FROM leave_type ORDER BY leave_type DESC");
                                    while($row=mysqli_fetch_assoc($res)){
                                        echo "<option value='".$row['id']."'>".$row['leave_type']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>From Date</label>
                                <input type="date" name="leave_from" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>To Date</label>
                                <input type="date" name="leave_to" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Leave Description</label>
                                <input type="text" name="leave_description" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Upload Document (Optional, PNG/JPG/PDF, Max 5MB)</label>
                                <input type="file" name="document" class="form-control" accept=".png,.jpg,.jpeg,.pdf">
                            </div>
                            <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('footer.inc.php'); ?>