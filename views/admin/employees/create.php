<?php
$departments = $data ? $data->departments : null;
$roles = $data ? $data->roles : null;
?>

<div class="container-fluid px-4">
  <h4 class="mt-4">Employee</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Employee</li>
  </ol>
  <div class="row mt-4">
    <div class="col-lg-12 col-xl-12 col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
                style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Create Employee
            <a href="/admin/employees" class="btn btn-danger float-end"><- Back</a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/admin/employee/create" method="post">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="">First Name</label>
                <input type="text" name="first_name" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter Email Adress" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="department">Department</label>
                <select name="department_id" id="department" required class="form-control">
                  <option value="">Select Department</option>
                  <?php
                  if (isset($departments)) {
                    foreach ($departments as $department) {
                      echo "<option value=" . htmlspecialchars($department->id) . ">" . $department->name . '</option>';
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Role</label>
                <select name="role_id" required class="form-control">
                  <option value="">Select Role</option>
                  <?php
                  if (isset($roles)) {
                    foreach ($roles as $role) {
                      echo "<option value=" . htmlspecialchars($role->id) . ">" . $role->name . '</option>';
                    }
                  } ?>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Verification Status</label>
                <select name="verify_status" class="form-control" required>
                  <option value="">Select verification status</option>
                  <option value="verified">Verified</option>
                  <option value="Female">Pending</option>
                </select>
              </div>

              <div class="col-md-6 mb-3">
                <label for="statusToggle">Status</label>
                <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="statusToggle" name="status">
                  <label class="custom-control-label" for="statusToggle">Active</label>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
              </div>
              <div class="col-lg-12 col-xl-12 col-md-12 mb-3">
                <input type="submit" name="add_admin" value="Save" class="btn btn-success float-right" />
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

require __DIR__ . "/../components/footer.php";