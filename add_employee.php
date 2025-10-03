<?php
require('top.inc.php');

// Initialize variables
$id = 0;
$name = '';
$email = '';
$mobile = '';
$department_id = '';
$address = '';
$birthday = '';
$role_value = 2; // default user role

// Session-safe variables
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 0;

// Agar edit mode me aaye
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Agar user hai to sirf apna hi profile edit kar sakta hai
    if ($role == 2 && $user_id != $id) {
        die('Access denied');
    }

    $res = mysqli_query($con, "SELECT * FROM employee WHERE id='$id'");
    $row = mysqli_fetch_assoc($res);
    if ($row) {
        $name = $row['name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $department_id = $row['department_id'];
        $address = $row['address'];
        $birthday = $row['birthday'];
        $role_value = $row['role'];
    }
}

// Form submission
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $mobile = mysqli_real_escape_string($con, $_POST['mobile']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $department_id = mysqli_real_escape_string($con, $_POST['department_id']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $birthday = mysqli_real_escape_string($con, $_POST['birthday']);

    // Agar admin role change kar raha hai
    if ($role == 1 && isset($_POST['role'])) {
        $role_value = mysqli_real_escape_string($con, $_POST['role']);
    }

    if ($id > 0) {
        // Agar password diya gaya hai tabhi update karo
        if ($password != '') {
            $password_hashed = password_hash($password, PASSWORD_BCRYPT);
            $pass_sql = "password='$password_hashed',";
        } else {
            $pass_sql = "";
        }

        $sql = "UPDATE employee 
                SET name='$name', email='$email', mobile='$mobile', 
                    $pass_sql
                    department_id='$department_id', address='$address', birthday='$birthday', role='$role_value' 
                WHERE id='$id'";
    } else {
        // Naya user: password compulsory
        $password_hashed = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO employee(name,email,mobile,password,department_id,address,birthday,role) 
                VALUES('$name','$email','$mobile','$password_hashed','$department_id','$address','$birthday','$role_value')";
    }

    mysqli_query($con, $sql);
    header('Location: employee.php');
    die();
}
?>

<div class="content pb-0">
    <div class="animated fadeIn">
       <div class="row">
          <div class="col-lg-12">
             <div class="card">
                <div class="card-header"><strong>Employee</strong><small> Form</small></div>
                <div class="card-body card-block">
                   <form method="post">
                       <div class="form-group">
                            <label class="form-control-label">Name</label>
                            <input type="text" value="<?php echo $name ?>" name="name" placeholder="Enter employee name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Email</label>
                            <input type="email" value="<?php echo $email ?>" name="email" placeholder="Enter employee email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Mobile</label>
                            <input type="text" value="<?php echo $mobile ?>" name="mobile" placeholder="Enter employee mobile" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Password</label>
                            <input type="password" name="password" placeholder="Enter employee password" 
                                   class="form-control" <?php if ($id==0) echo "required"; ?>>
                            <?php if ($id > 0) { ?>
                                <small class="form-text text-muted">Leave blank to keep current password</small>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Department</label>
                            <select name="department_id" required class="form-control">
                                <option value="">Select Department</option>
                                <?php
                                $res = mysqli_query($con, "SELECT * FROM department ORDER BY department DESC");
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $selected = ($department_id == $row['id']) ? "selected" : "";
                                    echo "<option value=".$row['id']." $selected>".$row['department']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Address</label>
                            <input type="text" value="<?php echo $address ?>" name="address" placeholder="Enter employee address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label class="form-control-label">Birthday</label>
                            <input type="date" value="<?php echo $birthday ?>" name="birthday" class="form-control" required>
                        </div>

                        <?php if ($role == 1) { ?>
                        <div class="form-group">
                            <label class="form-control-label">Role</label>
                            <select name="role" class="form-control">
                                <option value="1" <?php if ($role_value==1) echo "selected"; ?>>Admin</option>
                                <option value="2" <?php if ($role_value==2) echo "selected"; ?>>User</option>
                            </select>
                        </div>
                        <?php } ?>

                        <button type="submit" name="submit" class="btn btn-lg btn-info btn-block">
                            <span id="payment-button-amount">Submit</span>
