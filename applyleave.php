<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
?>



<div class="py-5">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7 offset-3">

                <?php include('message.php'); ?>

                <div class="card">
                    <div class="card-header bg-secondary">
                        <center>
                            <h4>Leave Application Form</h4>
                        </center>
                        <a href="index.php" class="btn btn-danger float-end mx-1">Cancel</a>
                    </div>
                    <div class="card-body bg-success">
                        <form action="allcode.php" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3 visually-hidden">
                                    <label for="">Full Name</label>
                                    <input type="text" name="fullname" class="form-control" value="<?= $_SESSION['auth_user']['user_name']  ?>" required readonly>
                                </div>

                                <div class="col-md-6 mb-3 visually-hidden">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= $_SESSION['auth_user']['user_email']  ?>" required readonly>
                                </div>
                                <div class="col-md-6 mb-3 visually-hidden">
                                    <label for="">Gender</label>
                                    <input type="text" name="gender" class="form-control" value="<?= $_SESSION['auth_user']['user_gender']  ?>" required readonly>
                                </div>


                                <div class="col-md-6 mb-3">
                                    <label for="">Leave Type</label>
                                    <select name="leave_type" required class="form-control">
                                        <option value="">--Select Leave_type--</option>
                                        <?php
                                        include('admin/config/dbcon.php');

                                        $query = "select * from leave_type order by leave_type desc";
                                        $query_run = mysqli_query($con, $query);
                                        while ($row = mysqli_fetch_assoc($query_run)) {
                                            echo "<option value=" . $row['leave_type'] . ">" . $row['leave_type'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3 visually-hidden">
                                    <label for="">Department</label>
                                    <input type="text" name="department" class="form-control" value="<?= $_SESSION['auth_user']['user_department']  ?>" required readonly>
                                </div>
                                <!-- Message input -->
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="">Description</label>
                                    <textarea type="text" name="description" class="form-control" rows="3" placeholder="Applying this Leave for the reason,,," required></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Leave From:</label>
                                    <input type="date" name="leave_from" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="">Leave To:</label>
                                    <input type="date" name="leave_to" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3 ">
                                    <button type="submit" name="apply_leave" class="btn btn-primary">Apply Now!</button>
                                </div>
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