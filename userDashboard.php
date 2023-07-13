<?php
session_start();
include('includes/header.php');
// include('includes/navbar.php');
?>

<section id="nav-bar">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="assets/images/leave2-logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown dropstart">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="avatar avatar-online"><img style="height: 32px; width: 36px; border: 5px" src="assets/IMG_20200320_145521_697.png" alt="avatar" /></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <?= $_SESSION['auth_user']['user_name']  ?>
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="bi bi-person-gear"></i> Profile</a></li>
                                <li>
                                    <form action="allcode.php" method="post">
                                        <button class="dropdown-item" name="logout_btn" type="submit"> <i class="bi bi-power"></i> Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
            </div>
        </div>
    </nav>
</section>

<?php include('message.php'); ?>

<section class="wrapper" id="wrapper">
    <div class="container py-5" id="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php include('message.php'); ?>
                <div class="card shadow rounded">
                    <div class="card-header">
                            <h4>Leave Application Status</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Leave Type</th>
                                    <th>Leave From:</th>
                                    <th>Leave To:</th>
                                    <th>Applied At</th>
                                    <th>Leave Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include('admin/config/dbcon.php');

                                $currentuser = $_SESSION['auth_user']['user_name'];
                                $query = "SELECT * FROM apply_leave WHERE fullname= '$currentuser'";
                                $query_run = mysqli_query($con, $query);
                                // lets check if data available
                                if (mysqli_num_rows($query_run) > 0) {
                                    foreach ($query_run as $row) {
                                        // lets divide php
                                ?>
                                        <tr>
                                            <td><?= $row['fullname']; ?></td>
                                            <td><?= $row['leave_type']; ?></td>
                                            <td><?= $row['leave_from']; ?></td>
                                            <td><?= $row['leave_to']; ?></td>
                                            <td><?= $row['applied_at']; ?></td>
                                            <td>
                                                <?php
                                                if ($row['leave_status'] == '0') {
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                       <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                           <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                       </symbol>
                                       <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                           <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                       </symbol>
                                       <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                           <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                       </symbol>
                                       </svg>
                                       <div class="alert alert-primary d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Info:"><use xlink:href="#info-fill"/></svg>
                                        <div>
                                        <b>Pending</b>
                                        </div>
                                        </div>';
                                                }
                                                if ($row['leave_status'] == '1') {
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </symbol>
                                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                        </symbol>
                                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                        </svg>
                                        <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                                        <div>
                                        <b>Accepted</b>
                                        </div>
                                        </div>';
                                                }
                                                if ($row['leave_status'] == '2') {
                                                    echo '<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                                        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </symbol>
                                        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                        </symbol>
                                        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                                        </symbol>
                                        </svg>
                                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                                        <div>
                                         <b>Rejected</b>
                                        </div>
                                        </div>';
                                                }
                                                ?>
                                            </td>
                                            <!-- sending fetched id -->
                                        </tr>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="6">No application yet</td>

                                    </tr>
                                <?php
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row justify-content-center">
            <div class="col-md-10">
                <?php include('message.php'); ?>
                <div class="card shadow rounded">
                    <div class="card-header">
                            <h4>Leave Application Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="allcode.php" method="post">

                            <div class="mb-3 row visually-hidden">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Full Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="fullname" class="form-control" value="<?= $_SESSION['auth_user']['user_name']  ?>" required readonly>
                                </div>
                            </div>

                            <div class="mb-3 row visually-hidden">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Email:</label>
                                <div class="col-sm-10">
                                    <input type="email" name="email" class="form-control" value="<?= $_SESSION['auth_user']['user_email']  ?>" required readonly>
                                </div>
                            </div>

                            <div class="mb-3 row visually-hidden">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Gender:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="gender" class="form-control" value="<?= $_SESSION['auth_user']['user_gender']  ?>" required readonly>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave Type:</label>
                                <div class="col-sm-10">
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
                            </div>

                            <div class="mb-3 row visually-hidden">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Department:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="department" class="form-control" value="<?= $_SESSION['auth_user']['user_department']  ?>" required readonly>
                                </div>
                            </div>
                            <!-- Message input -->
                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Description:</label>
                                <div class="col-sm-10">
                                    <textarea type="text" name="description" class="form-control" rows="3" placeholder="reason for the  applying this Leave,,," required></textarea>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave From:</label>
                                <div class="col-sm-10">
                                    <input type="date" name="leave_from" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Leave To:</label>
                                <div class="col-sm-10">
                                    <input type="date" name="leave_to" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="apply_leave" class="btn btn-primary">Apply Now!</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php
include('includes/footer.php');
?>