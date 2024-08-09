<?php
$department = $data ? $data->department[0] : null;
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Department</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Department</li>
    </ol>
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12">
            <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
                style="display: none; transition: opacity 1s ease;"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Details
                        <a class="text-white text-decoration-none btn btn-danger float-end" href="/admin/departments"><-
                                Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($department): ?>
                        <div class="mb-3">
                            <h5 class="font-weight-bold">Department Name:</h5>
                            <p><?= htmlspecialchars($department->name) ?></p>
                        </div>
                        <div class="mb-3">
                            <h5 class="font-weight-bold">Description:</h5>
                            <p><?= htmlspecialchars($department->description) ?></p>
                        </div>
                    <?php else: ?>
                        <h4>No Record Found</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>