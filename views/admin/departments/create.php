<div class="container-fluid px-4">
  <h4 class="mt-4">Department</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Department</li>
  </ol>
  <div class="row mt-4">
  <div class="col-md-12 col-lg-12 col-xl-12">
  <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
      style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Create Department
            <a href="/admin/departments" class="btn btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/admin/department/create" id="addDepartment" method="post">
            <div class="row">
              <div id="dpname-group" class="form-group mb-3">
                <label for="department_name">Department</label>
                <input type="text" class="form-control" id="department_name" name="department_name" placeholder="Department Name" />
              </div>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="3" placeholder="Description.."
                  required></textarea>
              </div>
              <div class="form-group text-right">
                <button type="submit" name="add_dept" class="btn btn-success float-end">Save</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . "/../components/footer.php"; ?>