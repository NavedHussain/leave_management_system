<?php
require('top.inc.php');

// Handle admin actions
if(isset($_GET['type']) && isset($_GET['id']) && $_SESSION['role'] == 1){
    $id = mysqli_real_escape_string($con,$_GET['id']);
    if($_GET['type'] == 'approve'){
        mysqli_query($con,"UPDATE `leave` SET leave_status=1 WHERE id='$id'");
    }
    if($_GET['type'] == 'reject'){
        mysqli_query($con,"UPDATE `leave` SET leave_status=2 WHERE id='$id'");
    }
}

// Fetch leaves
if($_SESSION['role'] == 1){
    $sql = "SELECT l.*, e.name, lt.leave_type 
            FROM `leave` l 
            JOIN employee e ON l.employee_id = e.id
            JOIN leave_type lt ON l.leave_id = lt.id
            ORDER BY l.id DESC";
} else {
    $eid = $_SESSION['user_id'];
    $sql = "SELECT l.*, lt.leave_type 
            FROM `leave` l 
            JOIN leave_type lt ON l.leave_id = lt.id
            WHERE l.employee_id='$eid'
            ORDER BY l.id DESC";
}
$res = mysqli_query($con,$sql);
?>

<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Leave Applications</h4>
                        <?php if($_SESSION['role'] == 2){ ?>
                        <h4 class="box_title_link"><a href="add_leave.php" style="color:lightgreen;text-decoration:none;" onmouseover="this.style.color='white'" onmouseout="this.style.color='lightgreen'">Apply for Leave</a></h4>

                        <?php } ?>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Leave Type</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Description</th>
                                        <th>Document</th>
                                        <th>Status</th>
                                        <?php if($_SESSION['role'] == 1){ echo "<th>Action</th>"; } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(mysqli_num_rows($res) > 0){
                                        while($row = mysqli_fetch_assoc($res)){
                                            $status_text = "Pending";
                                            if($row['leave_status'] == 1) $status_text = "Approved";
                                            if($row['leave_status'] == 2) $status_text = "Rejected";
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
                                        <td><?php echo $row['leave_from']; ?></td>
                                        <td><?php echo $row['leave_to']; ?></td>
                                        <td><?php echo htmlspecialchars($row['leave_description']); ?></td>
                                        <td>
                                            <?php 
                                            if(!empty($row['document'])){
                                                echo "<a href='uploads/".$row['document']."' target='_blank'>View</a>";
                                            } else {
                                                echo "-";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $status_text; ?></td>
                                        <?php if($_SESSION['role'] == 1){ ?>
                                        <td>
                                            <?php if($row['leave_status'] == 0){ ?>
                                            <a href="leave.php?id=<?php echo $row['id']; ?>&type=approve">Approve</a> | 
                                            <a href="leave.php?id=<?php echo $row['id']; ?>&type=reject">Reject</a>
                                            <?php } else { echo "-"; } ?>
                                        </td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                        }
                                    } else {
                                        echo "<tr><td colspan='8'>No leave applications found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require('footer.inc.php'); ?>
