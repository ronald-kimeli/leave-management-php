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
          <h4>Details
            <a class="text-white text-decoration-none btn btn-danger float-end" href="/admin/employees"><- Back</a>
          </h4>
        </div>
        <div class="card-body">
          <?php
          if (isset($data)) {
            $employee = $data->employee[0];
            ?>
            <div class="row">
              <!-- Define each detail in a col-12 for a full-width row -->
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>First Name:</strong>
                  <span><?= htmlspecialchars($employee->first_name); ?></span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Last Name:</strong>
                  <span><?= htmlspecialchars($employee->last_name); ?></span>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Email:</strong>
                  <span><?= htmlspecialchars($employee->email); ?></span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Department:</strong>
                  <span>
                    <?php
                    foreach ($data->departments as $department) {
                      if ($employee->department_id == $department->id) {
                        echo htmlspecialchars($department->name);
                        break;
                      }
                    }
                    ?>
                  </span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Role:</strong>
                  <span>
                    <?php
                    foreach ($data->roles as $role) {
                      if ($employee->role_id == $role->id) {
                        echo htmlspecialchars($role->name);
                        break;
                      }
                    }
                    ?>
                  </span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Gender:</strong>
                  <span><?= htmlspecialchars($employee->gender); ?></span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Verification Status:</strong>
                  <span>
                    <?php
                    $statuses = ['verified' => 'Verified', 'pending' => 'Pending'];
                    echo htmlspecialchars($statuses[$employee->verify_status] ?? 'Unknown');
                    ?>
                  </span>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Status:</strong>
                  <span><?= $employee->status === 'active' ? 'Active' : 'Inactive'; ?></span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex justify-content-between">
                  <strong>Password:</strong>
                  <span>**********</span>
                </div>
              </div>
            </div>
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
<?php require __DIR__ . "/../components/footer.php"; ?>
