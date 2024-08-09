<div class="container-fluid px-4">
  <h4 class="mt-4">Employee</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Employee</li>
  </ol>
  <div class="row">
    <div class="col-lg-12 col-xl-12 col-md-12">
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
        style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Update Employee
            <a class="text-white text-decoration-none btn btn-danger float-end" href="/admin/employees"><- Back</a>
          </h4>
        </div>
        <div class="card-body">
          <?php
          if (isset($data)) {
            ?>
            <form action="/admin/employee/update/<?= $data->employee[0]->id; ?>" method="post">
              <input type="hidden" name="_method" value="PUT">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="">First Name</label>
                  <input type="text" name="first_name" value="<?= $data->employee[0]->first_name; ?>"
                    class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="">Last Name</label>
                  <input type="text" name="last_name" value="<?= $data->employee[0]->last_name; ?>" class="form-control">
                </div>

                <div class="col-md-6 mb-3">
                  <label for="">Email</label>
                  <input type="email" name="email" value="<?= $data->employee[0]->email; ?>" class="form-control"
                    readonly>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="department_id">Department</label>
                  <select name="department_id" id="department_id" required class="form-control">
                    <option value="">Select Department</option>
                    <?php foreach ($data->departments as $department): ?>
                      <option value="<?= $department->id ?>" <?= $data->employee[0]->department_id == $department->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($department->name) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="role_id">Role</label>
                  <select name="role_id" id="role_id" required class="form-control">
                    <option value="">--Select Role--</option>
                    <?php foreach ($data->roles as $role): ?>
                      <option value="<?= $role->id ?>" <?= $data->employee[0]->role_id == $role->id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($role->name) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="gender">Gender</label>
                  <select name="gender" id="gender" required class="form-control">
                    <option value="">Select Gender</option>
                    <?php
                    $genders = ['Male', 'Female'];
                    $currentGender = $data->employee[0]->gender ?? '';
                    foreach ($genders as $gender):
                      ?>
                      <option value="<?= htmlspecialchars($gender) ?>" <?= $currentGender === $gender ? 'selected' : '' ?>>
                        <?= htmlspecialchars($gender) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="verify_status">Verification Status</label>
                  <select name="verify_status" id="verify_status" required class="form-control">
                    <option value="">Select verification status</option>
                    <?php
                    $statuses = ['verified' => 'Verified', 'pending' => 'Pending'];
                    $currentStatus = $data->employee[0]->verify_status ?? '';
                    foreach ($statuses as $value => $label):
                      ?>
                      <option value="<?= htmlspecialchars($value) ?>" <?= $currentStatus === $value ? 'selected' : '' ?>>
                        <?= htmlspecialchars($label) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="">Status</label>
                  <input type="checkbox" name="status" <?= $data->employee[0]->status === 'active' ? 'checked' : '' ?>
                    width="70px" height="70px">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="">Password</label>
                  <input type="password" name="password" value="<?= $data->employee[0]->password; ?>"
                    class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                  <button type="submit" name="update_employee" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
            <?php
          } else {
            ?>
            <h4>No Record Found</h4>
            <?php
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require __DIR__ . "/../components/footer.php";