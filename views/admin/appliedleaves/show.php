<?php
$appliedleave = $data ? $data->appliedleave[0] : null;
$from_date = $appliedleave ? $appliedleave->from_date : '';
$to_date = $appliedleave ? $appliedleave->to_date : '';

$total_days = '';
$remaining_days = '';
$expired = false;

if ($from_date && $to_date) {
    $date1 = new DateTime($from_date);
    $date2 = new DateTime($to_date);
    $interval = $date1->diff($date2);
    $total_days = $interval->days + 1;

    // Calculate remaining days
    $today = new DateTime();
    $to_date_dt = new DateTime($to_date);
    $remaining_interval = $today->diff($to_date_dt);
    $remaining_days = $remaining_interval->days;

    // Check if the leave has expired
    if ($today > $to_date_dt) {
        $expired = true;
    }
}
?>

<div class="container-fluid px-4">
  <h4 class="mt-4">Applied Leave</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">View Applied Leave</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
        style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-header">
          <h4>Details
            <a href="/admin/appliedleaves" class="btn btn-danger float-end"><i
                class="bi bi-arrow-left-circle-fill"></i></a>
          </h4>
        </div>
        <div class="card-body">
          <?php if ($appliedleave): ?>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="">Applied By</label>
                <input type="text" class="form-control" 
                  value="<?= htmlspecialchars($appliedleave->applied_by()->first_name . ' ' . $appliedleave->applied_by()->last_name); ?>" 
                  disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Leave Type</label>
                <input type="text" class="form-control" 
                  value="<?= htmlspecialchars($appliedleave->leavetype()->name); ?>" 
                  disabled>
              </div>
              <div class="col-md-12 mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" rows="3" 
                  disabled><?= htmlspecialchars($appliedleave->description); ?></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="from_date">Leave From:</label>
                <input type="text" id="from_date" class="form-control" 
                  value="<?= htmlspecialchars($from_date); ?>" 
                  disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label for="to_date">Leave To:</label>
                <input type="text" id="to_date" class="form-control" 
                  value="<?= htmlspecialchars($to_date); ?>" 
                  disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label for="total_days">Total Days:</label>
                <input type="text" id="total_days" class="form-control" 
                  value="<?= htmlspecialchars($total_days); ?>" 
                  disabled>
              </div>
              <div class="col-md-6 mb-3">
                <label>Status</label>
                <input type="text" class="form-control" 
                  value="<?= htmlspecialchars(ucfirst($appliedleave->status)); ?>" 
                  disabled>
              </div>
              <?php if ($appliedleave->status === 'accepted'): ?>
                <?php if ($expired): ?>
                  <div class="col-md-6 mb-3">
                    <div class="alert alert-danger" role="alert">
                      Expired!
                    </div>
                  </div>
                <?php else: ?>
                  <div class="col-md-6 mb-3">
                    <div class="alert alert-success" role="alert">
                      <?= htmlspecialchars($remaining_days); ?> day<?= $remaining_days > 1 ? 's' : ''; ?> remaining
                    </div>
                  </div>
                <?php endif; ?>
              <?php endif; ?>
            </div>
          <?php else: ?>
            <h4>No Record Found</h4>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require __DIR__ . "/../components/footer.php";
?>
