<?php
require('top.inc.php');

// Agar login na ho to redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Employee ke leaves nikalna
$query = "SELECT * FROM `leave` WHERE employee_id='$userId' ORDER BY leave_from DESC";
$res = mysqli_query($con, $query);
?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">Welcome <?php echo htmlspecialchars($userName); ?> 👋</h4>
                  <p class="text-muted">Here are your leave applications</p>
               </div>
               <div class="card-body--">
                  <?php if(mysqli_num_rows($res) > 0) { ?>
                     <div class="table-stats order-table ov-h">
                        <table class="table">
                           <thead>
                              <tr>
                                 <th>From</th>
                                 <th>To</th>
                                 <th>Description</th>
                                 <th>Status</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php while($row = mysqli_fetch_assoc($res)) { ?>
                                 <tr>
                                    <td><?php echo htmlspecialchars($row['leave_from']); ?></td>
                                    <td><?php echo htmlspecialchars($row['leave_to']); ?></td>
                                    <td><?php echo htmlspecialchars($row['leave_description']); ?></td>
                                    <td>
                                       <?php 
                                          if($row['leave_status'] == 1) {
                                             echo "<span class='badge badge-success'>Approved</span>";
                                          } elseif($row['leave_status'] == 2) {
                                             echo "<span class='badge badge-danger'>Rejected</span>";
                                          } else {
                                             echo "<span class='badge badge-warning'>Pending</span>";
                                          }
                                       ?>
                                    </td>
                                 </tr>
                              <?php } ?>
                           </tbody>
                        </table>
                     </div>
                  <?php } else { ?>
                     <p class="alert alert-info">You haven’t applied for any leave yet.</p>
                  <?php } ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
require('footer.inc.php');
?>
