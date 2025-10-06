<?php
require('top.inc.php');

// Only admin access
if(!isset($_SESSION['role']) || $_SESSION['role'] != 1){
    header('location:leave_type.php');
    die();
}

$leave_type = '';
$id = '';
$msg = '';

// Check if editing an existing leave type
if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM leave_type WHERE id='$id'");
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        $leave_type = $row['leave_type'];
    } else {
        $msg = "Invalid leave type ID!";
    }
}

// Handle form submission
if(isset($_POST['leave_type'])){
    $leave_type = mysqli_real_escape_string($con, $_POST['leave_type']);

    if($id != ''){
        // Update existing
        $sql = "UPDATE leave_type SET leave_type='$leave_type' WHERE id='$id'";
        $msg = "Leave type updated successfully!";
    } else {
        // Insert new
        $sql = "INSERT INTO leave_type(leave_type) VALUES('$leave_type')";
        $msg = "New leave type added successfully!";
    }

    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('$msg');
                window.location.href='leave_type.php';
              </script>";
        exit;
    } else {
        $msg = "Database Error: " . mysqli_error($con);
    }
}
?>
<div class="content pb-0">
   <div class="animated fadeIn">
      <div class="row">
         <div class="col-lg-12">
            <div class="card">
               <div class="card-header">
                  <strong><?php echo ($id != '') ? "Edit Leave Type" : "Add Leave Type"; ?></strong>
                  <small> Form</small>
               </div>
               <div class="card-body card-block">
                  <form method="post">
                     <div class="form-group">
                        <label for="leave_type" class="form-control-label">Leave Type</label>
                        <input type="text" value="<?php echo htmlspecialchars($leave_type); ?>" 
                               name="leave_type" 
                               placeholder="Enter your leave type" 
                               class="form-control" required>
                     </div>
                     <button type="submit" class="btn btn-lg btn-info btn-block">
                        <span id="payment-button-amount">Submit</span>
                     </button>
                  </form>
                  <?php if($msg != '') { ?>
                     <div style="color:red; margin-top:10px;"><?php echo $msg; ?></div>
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
