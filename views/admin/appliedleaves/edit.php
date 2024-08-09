<?php
// Your PHP code to initialize $appliedleave and $total_days
$appliedleave = $data ? $data->appliedleave[0] : null;
$from_date = $appliedleave ? $appliedleave->from_date : '';
$to_date = $appliedleave ? $appliedleave->to_date : '';

$total_days = '';
$warning_message = '';

if ($from_date && $to_date) {
    $date1 = new DateTime($from_date);
    $date2 = new DateTime($to_date);
    $interval = $date1->diff($date2);
    $total_days = $interval->days + 1; // +1 to include the end date

    // Check if the selected dates are in the past
    $today = new DateTime();
    if ($appliedleave->status === 'pending' && $today > $date2) {
        $warning_message = 'The selected dates have passed and cannot be updated.';
    }
}
?>

<div class="container-fluid px-4">
  <h4 class="mt-4">Applied Leave</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Update Leave</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
        style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Update
            <a href="/admin/appliedleaves" class="btn btn-danger float-end"><i
                class="bi bi-arrow-left-circle-fill"></i></a>
          </h4>
        </div>
        <div class="card-body">
          <?php if ($appliedleave): ?>
            <form action="/admin/appliedleave/update/<?= $appliedleave->id; ?>" method="post">
              <input type="hidden" name="_method" value="PUT">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="">Applied By</label>
                  <input type="text" class="form-control"
                    value="<?= htmlspecialchars($appliedleave->applied_by()->first_name . ' ' . $appliedleave->applied_by()->last_name); ?>"
                    disabled>
                  <input type="hidden" name="applied_by" value="<?= htmlspecialchars($appliedleave->applied_by->id); ?>">
                </div>
                <div class="col-md-6 mb-3">
                  <label for="">Leave Type</label>
                  <input type="text" class="form-control"
                    value="<?= htmlspecialchars($appliedleave->leavetype()->name); ?>" disabled>
                  <input type="hidden" name="leavetype_id" value="<?= htmlspecialchars($appliedleave->leavetype_id); ?>">
                </div>
                <div class="col-md-12 mb-3">
                  <label class="form-label" for="description">Description</label>
                  <textarea name="description" class="form-control" rows="3"
                    placeholder="Applying this Leave for the reason,,,"
                    disabled><?= htmlspecialchars($appliedleave->description); ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="from_date">Leave From:</label>
                  <input type="date" id="from_date" name="from_date" class="form-control"
                    value="<?= htmlspecialchars($from_date); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="to_date">Leave To:</label>
                  <input type="date" id="to_date" name="to_date" class="form-control"
                    value="<?= htmlspecialchars($to_date); ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="total_days">Total Days:</label>
                  <input type="text" id="total_days" name="total_days" class="form-control"
                    value="<?= htmlspecialchars($total_days); ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                  <label>Status</label>
                  <select name="status" class="form-control">
                    <option value="pending" <?= ($appliedleave->status == 'pending') ? 'selected' : ''; ?>>Update status
                    </option>
                    <option value="accepted" <?= ($appliedleave->status == 'accepted') ? 'selected' : ''; ?>>Accepted
                    </option>
                    <option value="rejected" <?= ($appliedleave->status == 'rejected') ? 'selected' : ''; ?>>Rejected
                    </option>
                  </select>
                </div>
                <?php if ($warning_message): ?>
                  <div class="col-md-12 mb-3">
                    <div class="alert alert-warning" role="alert">
                      <?= htmlspecialchars($warning_message); ?>
                    </div>
                  </div>
                <?php endif; ?>
                <div class="col-md-12 mb-3">
                  <button type="submit" name="update_leave" class="btn btn-warning float-end">Update</button>
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

<script>
  function calculateDays() {
    const fromDate = document.getElementById('from_date').value;
    const toDate = document.getElementById('to_date').value;

    if (fromDate && toDate) {
      const date1 = new Date(fromDate);
      const date2 = new Date(toDate);
      const timeDifference = date2 - date1;
      const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)) + 1; 
      document.getElementById('total_days').value = daysDifference;
    } else {
      document.getElementById('total_days').value = '';
    }
  }
  
  document.getElementById('from_date').addEventListener('change', calculateDays);
  document.getElementById('to_date').addEventListener('change', calculateDays);

  calculateDays();
</script>

<?php
require __DIR__ . "/../components/footer.php";
?>
