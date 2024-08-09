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
                    <h4>Update Department
                        <a href="/admin/departments" class="btn btn-danger float-right">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($department): ?>
                        <form id="department-form" action="/admin/department/update/<?= $department->id ?>" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="form-group">
                                <label for="name">Department Name</label>
                                <input type="text" id="name" name="dname" value="<?= $department->name ?>"
                                    class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="3"
                                    placeholder="Description.." required><?= $department->description ?></textarea>
                            </div>
                            <div class="form-group text-right">
                                <input type="submit" name="update_dept" value="Update" class="btn btn-primary">
                            </div>
                        </form>
                    <?php else: ?>
                        <h4>No Record Found</h4>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . "/../components/footer.php"; ?>