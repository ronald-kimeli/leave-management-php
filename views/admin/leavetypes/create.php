<div class="container-fluid px-4">
  <h4 class="mt-4">Leave Type</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Leave Type</li>
  </ol>
  <div class="row mt-4">
    <div class="col-md-12 col-lg-12 col-xl-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
        style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Add Leave Type
            <a href="/admin/leavetypes" class="btn btn-info float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
          <form id="leaveTypeForm" action="/admin/leavetype/create" method="post">
            <div class="row">
              <div id="dpname-group" class="form-group mb-3">
                <label for="leave_type_name">Leave Type</label>
                <input type="text" id="leave_type_name" name="leave_type_name" class="form-control"
                  placeholder="Leave Type Name" required>
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description.."
                  required></textarea>
              </div>
              <div class="form-group text-right">
                <button type="submit" name="add_ltype" class="btn btn-primary float-end">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/../components/footer.php"; ?>