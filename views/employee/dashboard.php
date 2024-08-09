<?php 
$apply_leave = $data ? $data->apply_leave : 0;
$leave_type = $data ? $data->leave_type : 0;
$departments = $data ? $data->departments : 0;
?>
<div class="container-fluid px-4">
    <h1 class="mt-4">User Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Employee Dashboard</li>
    </ol>
    <?= app\messages\AlertMessage::display(); ?>
    <div class="row">
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Applied leaves</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?= '<h1>' . $apply_leave. '</h1>' ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-info text-primary mb-4">
                <div class="card-body">Leave Types</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?= '<h1>' . $leave_type . '</h1>' ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">Departments</div>
                <div class="card-footer d-flex align-items-center justify-content-start">
                    <h1>
                        <?= '<h1>' . $departments . '</h1>' ?>
                    </h1>
                    <div class="small text-white"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . "/components/footer.php"; ?>