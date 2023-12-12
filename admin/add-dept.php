<div class="container-fluid px-4">
  <div class="row mt-4">
    <div class="col-md-12">
      <?php include 'message.php';?>
      <div class="card">
        <div class="card-header">
          <h4>Add Department
            <a href="/admin/departments" class="btn btn-danger float-end">Back</a>
          </h4>
        </div>
        <div class="card-body">
          <form action="/admin/updateu" id="addDepartment" method="post">
            <div class="row">
              <div id="dpname-group" class="form-group col-md-6 mb-3">
                <label for="dpname">Department</label>
                <input type="text" class="form-control" id="dpname" name="dpname" placeholder="Department Name" />
              </div>
              <div class="col-md-6 mb-3 pt-4">
                <button type="submit" name="add_dept" class="btn btn-primary float-end">Submit</button>
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