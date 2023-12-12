<div class="container-fluid px-4">
  <h4 class="mt-4">User Dashboard</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Leave Type</li>
  </ol>
  <div class="row">
    <div class="col-md-12">

      <?php include 'message.php'; ?>

      <div class="card">
        <div class="card-header">
          <h4>Application Form
            <a href="/employee/appliedleaves" class="float-end mx-1"><i class="bi bi-arrow-left-circle-fill"></i></a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/employee/leave_controller" method="post">
            <div class="row">
              <div class="col-md-6 mb-3 visually-hidden">
                <label for="">Full Name</label>
                <input type="text" name="fullname" class="form-control" value="<?= $_SESSION['auth_user']['user_name'] ?>"
                  required readonly>
              </div>

              <div class="col-md-6 mb-3 visually-hidden">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" value="<?= $_SESSION['auth_user']['user_email'] ?>"
                  required readonly>
              </div>
              <div class="col-md-6 mb-3 visually-hidden">
                <label for="">Gender</label>
                <input type="text" name="gender" class="form-control" value="<?= $_SESSION['auth_user']['user_gender'] ?>"
                  required readonly>
              </div>

              <div class="col-md-12 mb-3">
                <label for="">Leave Type</label>
                <select name="leave_type" required class="form-control">
                  <option value="">--Select Leave_type--</option>
                  <?php
                  $query = "SELECT * FROM leave_type ORDER BY leave_type desc";
                  $stmt = $conn->prepare($query);
                  $stmt->execute();
                  $data = $stmt->fetchAll();
                  if($data) {
                    foreach($data as $row) {
                      echo "<option value=".$row['leave_type'].">".$row['leave_type']."</option>";
                    }
                  }
                  ?>
                </select>
              </div>
              <div class="col-md-6 mb-3 visually-hidden">
                <label for="">Department</label>
                <input type="text" name="department" class="form-control"
                  value="<?= $_SESSION['auth_user']['user_department'] ?>" required readonly>
              </div>
              <!-- Message input -->
              <div class="col-md-12 mb-3">
                <label class="form-label" for="">Description</label>
                <textarea type="text" name="description" class="form-control" rows="3"
                  placeholder="Applying this Leave for the reason,,," required></textarea>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Leave From:</label>
                <input type="date" name="leave_from" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Leave To:</label>
                <input type="date" name="leave_to" min=<?php echo date('Y-m-d'); ?> class="form-control" required>
              </div>
              <div class="col-md-12 mb-3 ">
                <button type="submit" name="apply_leave" class="btn btn-primary float-end">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>


<?php

require __DIR__."/includes/footer.php";