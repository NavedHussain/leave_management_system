<?php
require('top.inc.php');

// Allow only admin
if(!isset($_SESSION['role']) || $_SESSION['role'] != 1){
    header('location:index.php');
    exit();
}

$department = '';
$id = '';
$msg = '';

// If editing department
if(isset($_GET['id']) && $_GET['id'] != ''){
    $id = mysqli_real_escape_string($con, $_GET['id']);
    $res = mysqli_query($con, "SELECT * FROM department WHERE id='$id'");
    if(mysqli_num_rows($res) > 0){
        $row = mysqli_fetch_assoc($res);
        $department = $row['department'];
    } else {
        $msg = "Department not found.";
    }
}

// Handle form submission
if(isset($_POST['department'])){
    $department = mysqli_real_escape_string($con, $_POST['department']);

    if($id != ''){
        // Update
        $sql = "UPDATE department SET department='$department' WHERE id='$id'";
        $msg = "Department updated successfully!";
    } else {
        // Insert new
        $sql = "INSERT INTO department (department) VALUES ('$department')";
        $msg = "New department added successfully!";
    }

    if(mysqli_query($con, $sql)){
        echo "<script>
                alert('$msg');
                window.location.href='index.php';
              </script>";
        exit();
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
                        <strong><?php echo ($id != '') ? "Edit Department" : "Add Department"; ?></strong>
                        <small> Form</small>
                    </div>
                    <div class="card-body card-block">
                        <form method="post">
                            <div class="form-group">
                                <label for="department" class="form-control-label">Department Name</label>
                                <input type="text" value="<?php echo htmlspecialchars($department); ?>" 
                                       name="department" 
                                       placeholder="Enter department name (e.g. HR, Sales, PR)" 
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
