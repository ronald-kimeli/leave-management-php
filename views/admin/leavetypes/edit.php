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
        <div class="col-xl-12 col-lg-12 col-md-12">
        <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
        style="display: none; transition: opacity 1s ease;"></div>
            <div class="card">
                <div class="card-header">
                    <h4>Update LType
                        <a href="/admin/leavetypes" class="btn btn-info float-end">Back</a>
                    </h4>
                </div>
                <div class="card-body">
                    <?php if ($leavetype): ?>
                        <form action="/admin/leavetype/update/<?= $leavetype->id ?>" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="row">
                                <div class="form-group">
                                    <label for="">Leave Type</label>
                                    <input type="text" name="leave_type_name" value="<?= $leavetype->name ?>"
                                        class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea id="description" name="description" class="form-control" rows="3"
                                        placeholder="Description.." required><?= $leavetype->description ?></textarea>
                                </div>
                                <div class="form-group text-right">
                                    <input type="submit" name="update_dept" value="Update" class="btn btn-primary">
                                </div>
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