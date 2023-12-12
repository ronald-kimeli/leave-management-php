<div class="container-fluid px-4">
  <h4 class="mt-4">Department</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Department</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?php include 'message.php';?>
      <div class="card">
        <div class="card-header">
          <h4 class="box-title">Department
            <button type="button" class="btn btn-primary float-end">
              <a class="text-white text-decoration-none" href="/admin/add-dept">ADD</a>
            </button>
          </h4>
        </div>
        <div class="card-body">
        <div class="table responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Department</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
$query = "SELECT * FROM  department";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();

if ($data) {
    foreach ($data as $row) {
        // lets divide php
        ?>
              <tr>
                <td>
                  <?=$row['id'];?>
                </td>
                <td>
                  <?=$row['dpname'];?>
                </td>
                <!-- sending fetched id -->
                <td>
                  <a href="/admin/update_department?id=<?=$row['id'];?>" class="btn btn-success">
                    Edit
                  </a>
                </td>
                <td>
                  <form action="/admin/updateu" method="post">
                    <button type="submit" name="delete_dept" value="<?=$row['id'];?>" class="btn btn-danger">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
              <?php
}
} else {
    ?>
              <tr>
                <td colspan="4"> No Record Found</td>
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

<?php

require __DIR__ . "/includes/footer.php";