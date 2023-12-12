<div class="container-fluid px-4">
  <div class="row mt-4">
    <div class="col-md-12">
      <?php include 'message.php';?>
      <div class="card">
        <div class="card-header">
          <h4>Add Admin/User
            <a href="/admin/employees" class="btn btn-danger float-end">BACK</a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/admin/codeu" method="post">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="">First Name</label>
                <input type="text" name="fname" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Last Name</label>
                <input type="text" name="lname" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label>Gender</label>
                <select name="gender" class="form-control" required>
                  <option value="">--Select Gender--</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Department</label>
                <select name="department" required class="form-control">
                  <option value="">--Select Department--</option>
                  <?php
$query = "select * from department order by dpname desc";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();
foreach ($data as $row) {
    echo "<option value=" . $row['dpname'] . ">" . $row['dpname'] . "</option>";
}
?>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label>Email address</label>
                <input type="email" name="email" placeholder="Enter Email Adress" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Confirm Password</label>
                <input type="password" name="cpassword" class="form-control" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Role</label>
                <select name="role_as" required class="form-control">
                  <option value="">--Select Role--</option>
                  <option value="1">Admin</option>
                  <option value="0">User</option>
                </select>
              </div>
              <div class="col-md-6 mb-3">
                <label for="">Status</label>
                <input type="checkbox" name="status" width="70px" height="70px">
              </div>
              <div class="col-md-6 mb-3">
                <button type="submit" name="add_admin" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

require __DIR__ . "/includes/footer.php";