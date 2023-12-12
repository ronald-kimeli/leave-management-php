<div class="container-fluid px-4">
  <h4 class="mt-4">Leave Type</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item ">Leave Type</li>
  </ol>
  <div class="row">
    <div class="col-md-12">

      <?php include 'message.php';?>

      <div class="card">
        <div class="card-header">
          <!-- <h4>Registered Users</h4>
                        <a href="register_admin.php" class="btn btn-primary float-end">Add Admin</a> -->
          <h4 class="box-title">Leave Type
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary float-end">
              <a class="text-white text-decoration-none" href="/admin/add-ltype">ADD</a>
            </button>
          </h4>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>ID</th>
                <th>Leave Type</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              <?php
$query = "SELECT * FROM leave_type";
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
                  <?=$row['leave_type'];?>
                </td>
                <!-- sending fetched id -->
                <td>
                  <a href="/admin/update_createltype?id=<?=$row['id'];?>" class="btn btn-success">
                    Edit
                  </a>
                </td>
                <td>
                  <form action="/admin/updateu" method="post">
                    <button type="submit" name="delete_ltype" value="<?=$row['id'];?>" class="btn btn-danger">
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

<?php

require __DIR__ . "/includes/footer.php";