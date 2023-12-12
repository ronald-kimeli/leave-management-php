<div class="container-fluid px-4">
    <h4 class="mt-4">User Dashboard</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item ">Leave Type</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?php include('message.php'); ?>
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Leave Type</h4>
                </div>
                <div class="card-body table-responsive">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Leave_Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $count = 1;
                            $query = "SELECT * FROM leave_type";
                            $stmt = $conn->prepare($query);
                            $stmt->execute();
                            $data = $stmt->fetchAll();
                            if ($data) {
                                foreach ($data as $row) {
                                    // lets divide php
                                    $row = (object) $row;
                                    ?>
                                    <tr>
                                        <td>
                                            <?= $count++; ?>
                                        </td>
                                        <td>
                                            <?= $row->leave_type; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
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