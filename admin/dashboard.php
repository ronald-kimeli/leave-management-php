<div class="container-fluid px-4">
  <h1 class="mt-4">ADMIN PANEL</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <?php include 'message.php'?>
  <div class="row">
    <div class="col-xl-3 col-md-6">
      <div class="card bg-success text-white mb-4">
        <div class="card-body">Total Employees</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
            <?php
$query = "SELECT * FROM users ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();

if ($data) {
    echo '<h1>' . count($data) . '</h1>';
} else {
    echo '<h1>' . 0 . '</h1>';
}
?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-primary text-white mb-4">
        <div class="card-body">Total Departments</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
            <?php
$query = "SELECT id FROM department ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();

if ($data) {
    echo '<h1>' . count($data) . '</h1>';
} else {
    echo '<h1>' . 0 . '</h1>';
}
?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-purple text-white mb-4">
        <div class="card-body">Total Applied leave</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
            <?php
$query = "SELECT * FROM apply_leave ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();

if ($data) {
    echo '<h1>' . count($data) . '</h1>';
} else {
    echo '<h1>' . 0 . '</h1>';
}
?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-6">
      <div class="card bg-blue text-light mb-4">
        <div class="card-body">Total Leave Types</div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          <h1>
            <?php
$query = "SELECT id FROM leave_type ORDER BY id";
$stmt = $conn->prepare($query);
$stmt->execute();
$data = $stmt->fetchAll();

if ($data) {
    echo '<h1>' . count($data) . '</h1>';
} else {
    echo '<h1>' . 0 . '</h1>';
}
?>
          </h1>
          <div class="small text-white"></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

require __DIR__ . "/includes/footer.php";