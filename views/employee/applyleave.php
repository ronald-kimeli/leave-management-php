<?php
$leave_type = $data ? $data->leave_type : null;
$user_id = $data ? $data->user_id : null;
?>

<div class="container-fluid px-4">
  <h4 class="mt-4">User Dashboard</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Leave Type</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div class="card">
        <div class="card-header">
          <h4>Application Form
            <a href="/employee/appliedleaves" class="float-end mx-1"><i class="bi bi-arrow-left-circle-fill"></i></a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/employee/applyleave" method="post">
            <div class="row">
              <div class="col-md-6 mb-3 visually-hidden">
                <label for="">applied_by</label>
                <input type="text" name="applied_by" class="form-control" value="<?= $user_id ?>" required readonly>
              </div>
              <div class="col-md-12 mb-3">
                <label for="">Leave Type</label>
                <select name="leavetype_id" required class="form-control">
                  <option value="">Select Leave Type</option>
                  <?php
                  if ($leave_type) {
                    foreach ($leave_type as $row) {
                      echo "<option value=" . $row->id . ">" . $row->name . "</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label" for="">Description</label>
                <textarea type="text" name="description" class="form-control" rows="3"
                  placeholder="Applying this Leave for the reason,,," required></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Leave From:</label>
                <input type="date" name="from_date" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Leave To:</label>
                <input type="date" name="to_date" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
              </div>
              <div class="col-md-12 mb-3 ">
                <input type="submit" name="apply_leave" value="Submit" class="btn btn-primary float-end">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>