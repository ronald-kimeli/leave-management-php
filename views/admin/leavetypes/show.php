<?php
$leavetype = $data ? $data->leavetype[0] : null;
?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Leave Type</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Leave Type</li>
    </ol>
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-md-12">
            <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
                style="display: none; transition: opacity 1s ease;"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Leave Type Details
                        <a href="/admin/leavetypes" class="btn btn-info float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($leavetype): ?>
                        <div class="row">
                            <!-- Define each detail in a col-12 for a full-width row -->
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Leave Type:</strong>
                                    <span><?= htmlspecialchars($leavetype->name); ?></span>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="d-flex justify-content-between">
                                    <strong>Description:</strong>
                                    <span><?= htmlspecialchars($leavetype->description); ?></span>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <h4>No Record Found</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . "/../components/footer.php"; ?>
