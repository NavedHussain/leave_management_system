<?php
require('top.inc.php');

if($_SESSION['role']!=1){
    header('location:add_employee.php?id='.$_SESSION['USER_ID']);
    die();
}

// Delete leave type
if(isset($_GET['type']) && $_GET['type']=='delete' && isset($_GET['id'])){
    $id=mysqli_real_escape_string($con,$_GET['id']);
    mysqli_query($con,"DELETE FROM leave_type WHERE id='$id'");
}

// Fetch leave types + count how many times each type used
$res=mysqli_query($con,"
   SELECT lt.*, COUNT(l.id) AS applied_count
   FROM leave_type lt
   LEFT JOIN `leave` l ON lt.id = l.leave_id
   GROUP BY lt.id
   ORDER BY lt.id DESC
");
?>
<div class="content pb-0">
    <div class="orders">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="box-title">Leave Type Master</h4>
                        <h4 class="box_title_link"><a href="add_leave_type.php">Add Leave Type</a></h4>
                    </div>
                    <div class="card-body--">
                        <div class="table-stats order-table ov-h">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th width="5%">S.No</th>
                                        <th width="5%">ID</th>
                                        <th width="50%">Leave Type</th>
                                        <th width="20%">Applied Count</th>
                                        <th width="20%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i=1;
                                    while($row=mysqli_fetch_assoc($res)){ ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo $row['id'] ?></td>
                                        <td><?php echo htmlspecialchars($row['leave_type']); ?></td>
                                        <td><?php echo $row['applied_count']; ?></td>
                                        <td>
                                            <a href="add_leave_type.php?id=<?php echo $row['id']?>">Edit</a> | 
                                            <a href="leave_type.php?id=<?php echo $row['id']?>&type=delete" onclick="return confirm('Are you sure you want to delete this leave type?')">Delete</a>
                                        </td>
                                    </tr>
                                    <?php 
                                    $i++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require('footer.inc.php');
?>
