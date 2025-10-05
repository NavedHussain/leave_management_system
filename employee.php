<?php
require('top.inc.php');

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId   = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];
$userRole = $_SESSION['role'];

// Database connection
require('includes/config.php');
?>

<div class="content pb-0">
   <div class="orders">
      <div class="row">
         <div class="col-xl-12">
            <div class="card">
               <div class="card-body">
                  <h4 class="box-title">
                     Welcome <?php echo htmlspecialchars($userName); ?> 👋
                  </h4>

                  <?php if($userRole == 1) { ?>
                     <p class="text-muted">Here is the list of all employees in your organization.</p>

                     <?php
                        $query = "SELECT e.id, e.name, e.email, e.role, d.department AS department_name 
                                  FROM employee e 
                                  LEFT JOIN department d ON e.department_id = d.id
                                  ORDER BY e.id ASC";
                        $res = mysqli_query($con, $query);
                     ?>

                     <?php if(mysqli_num_rows($res) > 0) { ?>
                        <div class="table-stats order-table ov-h mt-3">
                           <table class="table">
                              <thead>
                                 <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Department</th>
                                    <th>Role</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php while($row = mysqli_fetch_assoc($res)) { ?>
                                    <tr>
                                       <td><?php echo $row['id']; ?></td>
                                       <td><?php echo htmlspecialchars($row['name']); ?></td>
                                       <td><?php echo htmlspecialchars($row['email']); ?></td>
                                       <td><?php echo htmlspecialchars($row['department_name'] ?? 'Not Assigned'); ?></td>
                                       <td>
                                          <?php echo ($row['role'] == 1) ? "<span class='badge badge-success'>Admin</span>" : "<span class='badge badge-info'>Employee</span>"; ?>
                                       </td>
                                    </tr>
                                 <?php } ?>
                              </tbody>
                           </table>
                        </div>
                     <?php } else { ?>
                        <p class="alert alert-info mt-3">No employees found.</p>
                     <?php } ?>

                  <?php } else { ?>
                     <p class="text-muted">Here are your details:</p>

                     <?php
                        $query = "SELECT e.*, d.department AS department_name 
                                  FROM employee e 
                                  LEFT JOIN department d ON e.department_id = d.id 
                                  WHERE e.id = '$userId'";
                        $res = mysqli_query($con, $query);
                        $row = mysqli_fetch_assoc($res);
                     ?>

                     <table class="table table-bordered mt-3">
                        <tr><th>Name</th><td><?php echo htmlspecialchars($row['name']); ?></td></tr>
                        <tr><th>Email</th><td><?php echo htmlspecialchars($row['email']); ?></td></tr>
                        <tr><th>Department</th><td><?php echo htmlspecialchars($row['department_name'] ?? 'Not Assigned'); ?></td></tr>
                        <tr><th>Role</th><td><?php echo ($row['role'] == 1) ? 'Admin' : 'Employee'; ?></td></tr>
                     </table>
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
