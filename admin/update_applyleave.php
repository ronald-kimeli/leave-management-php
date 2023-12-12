<div class="container-fluid px-4">
  <h4 class="mt-4">Status</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Applied Leaves</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Update Status</h4>
        </div>
        <div class="card-body">
          <?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM apply_leave WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute(array("id" => $id));
    $data = $stmt->fetchAll();
    if ($data) {
        foreach ($data as $row) {
            ?>
          <form action="/admin/updateu" method="post">
            <input type="hidden" name="id" value="<?=$row['id'];?>">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Leave Status</label>
                <?php
?>
                <select name="leave_status" class="form-control">
                  <?php

            if ($row['leave_status'] === 0) {
                echo "<option selected selected value='0'>--Update status--</option>";
                echo '<option value="2">Rejected</option>';
                echo "<option value='1'>Accepted</option>";
            } elseif ($row['leave_status'] == 1) {
                echo "<option value='1' selected>Accepted</option>";
                echo '<option value="2">Rejected</option>';
            } else {
                echo '<option value="2" selected>Rejected</option>';
                echo "<option value='1'>Accepted</option>";
            }
            ?>
                </select>
                <?php
?>
              </div>
              <div class="col-md-6 mb-3 pt-4">
                <button type="submit" name="update_status" class="btn btn-primary align-center">Update</button>
                <a href="/admin/appliedleaves" class="btn btn-danger float-end">Back</a>
              </div>
            </div>
          </form>
          <?php
}
    } else {
        ?>
          <h4>No Record Found</h4>
          <?php
}
}
?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

require __DIR__ . "/includes/footer.php";