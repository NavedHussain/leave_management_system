<?php
require('top.inc.php');

// Sirf admin ko access
if (!isset($_SESSION['role']) || $_SESSION['role'] != 1) {
    header('location:add_employee.php?id='.$_SESSION['user_id']);
    die();
}

// Department list
if (isset($_GET['type']) && $_GET['type'] == 'delete' && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    mysqli_query($con, "DELETE FROM department WHERE id='$id'");
}

// Department fetch
$res = mysqli_query($con, "SELECT * FROM department ORDER BY id DESC");

// Leave applications fetch
$query = "SELECT l.*, e.name 
          FROM `leave` l 
          JOIN employee e ON l.employee_id = e.id
          ORDER BY l.leave_from DESC";
$leaveResult = mysqli_query($con, $query);
?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Welcome Admin: <?php echo htmlspecialchars($_SESSION['user_name']); ?> </h4>
                  <p class="text-muted">All Employees Leave Applications</p>
               </div>
               <div class="card-body--">
                  <?php if(mysqli_num_rows($leaveResult) > 0) { ?>
                     <div class="table-stats order-table ov-h mb-4">
                        <table class="table">
                           <thead>
                              <tr>
                                 <th>Employee</th>
                                 <th>From</th>
                                 <th>To</th>
                                 <th>Description</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php while($row = mysqli_fetch_assoc($leaveResult)) { ?>
                                 <tr>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['leave_from']); ?></td>
                                    <td><?php echo htmlspecialchars($row['leave_to']); ?></td>
                                    <td><?php echo htmlspecialchars($row['leave_description']); ?></td>
                                 </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  <?php } else { ?>
                     <p class="alert alert-info">No leave applications found.</p>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>

      <!-- Department Master Section -->
      <div class="row mt-4">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Department Master </h4>
                  <h4 class="box_title_link"><a href="add_department.php">Add Department</a> </h4>
               </div>
               <div class="card-body--">
                  <div class="table-stats order-table ov-h">
                     <table class="table">
                        <thead>
                           <tr>
                              <th width="5%">S.No</th>
                              <th width="5%">ID</th>
                              <th width="70%">Department Name</th>
                              <th width="20%">Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php 
                           $i=1;
                           while($row=mysqli_fetch_assoc($res)){?>
                              <tr>
                                 <td><?php echo $i?></td>
                                 <td><?php echo $row['id']?></td>
                                 <td><?php echo $row['department']?></td>
                                 <td>
                                    <a href="add_department.php?id=<?php echo $row['id']?>">Edit</a> | 
                                    <a href="index.php?id=<?php echo $row['id']?>&type=delete">Delete</a>
                                 </td>
                              </tr>
                           <?php $i++; } ?>
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
