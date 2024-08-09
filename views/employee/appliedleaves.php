<?php $appliedleaves = $data ? $data->appliedleaves : null; ?>
<div class="container-fluid px-4">
  <h4 class="mt-4">User Dashboard</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Applied Leave</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div class="card">
        <div class="card-header">
          <h4>Leave Status
            <a href="/employee/applyleave" class="float-end"><i class="bi bi-plus-circle text-success"></i></a>
          </h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr class="table100-head">
                  <th class="column1">Id</th>
                  <th class="column1">Type</th>
                  <th class="column2">Description</th>
                  <th class="column3">From</th>
                  <th class="column4">To</th>
                  <th class="column5">Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($appliedleaves) {
                  $id = 1;
                  foreach ($appliedleaves as $row) {
                    ?>
                    <tr>
                      <td><?= $id++ ?></td>
                      <td><?= $row->leavetype->name; ?> </td>
                      <td><?= $row->description; ?> </td>
                      <td><?= $row->from_date; ?></td>
                      <td><?= $row->to_date; ?></td>
                      <td>
                        <?php if ($row->status == 'pending'): ?>
                          <div class="alert alert-warning d-flex align-items-center m-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.25rem;"></i>
                            <div>Pending</div>
                          </div>
                        <?php elseif ($row->status == 'accepted'): ?>
                          <div class="alert alert-success d-flex align-items-center m-0" role="alert">
                            <i class="bi bi-check-circle-fill me-2" style="font-size: 1.25rem;"></i>
                            <div>Accepted</div>
                          </div>
                        <?php elseif ($row->status == 'rejected'): ?>
                          <div class="alert alert-danger d-flex align-items-center m-0" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2" style="font-size: 1.25rem;"></i>
                            <div>Rejected</div>
                          </div>
                        <?php endif; ?>
                      </td>
                    </tr>
                    <?php
                  }
                } else {
                  ?>
                  <tr>
                    <td colspan="6">No application yet</td>
                  </tr>
                  <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>