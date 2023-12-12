<div class="container-fluid px-4">
    <h4 class="mt-4">User Dashboard</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item ">Department</li>
    </ol>
    <div class="row">
        <div class="col-md-12">

            <?php include('message.php'); ?>

            <div class="card">
                <div class="card-header">
                    <!-- <h4>Registered Users</h4>
                        <a href="register_admin.php" class="btn btn-primary float-end">Add Admin</a> -->
                    <h4 class="box-title">Department</h4>
                </div>
                <div class="card-body table responsive">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $email = $_SESSION['auth_user']['user_email'];
                            $query = "SELECT department FROM users WHERE email = :email";
                            $stmt = $conn->prepare($query);
                            $stmt->execute(['email' => $email]);
                            $data = $stmt->fetch();

                            if ($data) {
                                ?>
                                <tr>
                                    <td>
                                        <?= count($data); ?>
                                    </td>
                                    <td>
                                        <?= $data['department']; ?>
                                    </td>
                                </tr>
                                <?php
                            } else {
                                ?>
                                <tr>
                                    <td colspan="2"> No Record Found</td>
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

    </div>
</div>

<?php

require __DIR__ . "/includes/footer.php";