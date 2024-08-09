<?php $department = $data ? $data->department : null; ?>

<div class="container-fluid px-4">
    <h4 class="mt-4">User Dashboard</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item ">Department</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?= app\messages\AlertMessage::display(); ?>
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
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($department): ?>
                                    <tr>
                                        <td>
                                            <?= 1; ?>
                                        </td>
                                        <td>
                                            <?= $department->name; ?>
                                        </td>
                                        <td>
                                            <?= $department->description; ?>
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <tr>No Record Found</tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>