<?php
session_start();

if (isset($_SESSION['auth'])) // prevents showing login page while loggedd in
{
    $_SESSION['message'] = "You are already Logged In";
    header("Location:index.php"); //..to home page
    exit(0);
}


include('includes/header.php');
include('includes/navbar.php');
?>

<div class="py-5">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">

                <?php include('message.php'); ?>

                <div class="card">
                    <div class="card-header">
                        <h4>Register</h4>
                    </div>
                    <div class="card-body">
                        <form action="registercode.php" method="post">
                            <div class="form-group mb-3">
                                <label>First Name</label>
                                <input required type="text" name="fname" placeholder="Enter First Name" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label>Last Name</label>
                                <input required type="text" name="lname" placeholder="Enter Last Name" class="form-control">
                            </div>
                            <!-- Gender as addition -->
                            <div class="form-group mb-3">
                                <label>Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">--Select Gender--</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <!-- department as second addition -->
                            <div class="form-group mb-3">
                                <label for="">Department</label>
                                <select name="department" required class="form-control">
                                    <option value="">--Select Department--</option>
                                    <?php
                                    include('admin/config/dbcon.php');

                                    $query = "select * from department order by dpname desc";
                                    $query_run = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                        echo "<option value=" . $row['dpname'] . ">" . $row['dpname'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label>Email address</label>
                                <input type="email" name="email" placeholder="Enter Email Adress" class="form-control" required>
                            </div>

                            <div class="form-group mb-3">
                                <label>Password</label>
                                <input type="password" name="password" placeholder="Enter Password" class="form-control" required>
                            </div> 
                             <div class="form-group mb-3">
                                <label>Confirm Password</label>
                                <input type="password" name="cpassword" placeholder="Enter Confirm Password" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <button type="submit" name="submit" class="btn btn-primary">Register Now</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('includes/footer.php');
?>