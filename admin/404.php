<div class="container-fluid px-4">
  <h1 class="mt-4">ADMIN PANEL</h1>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <?php include 'message.php'?>
  <div class="row">
    <div class="col-xl-12 col-md-6 col-sm-4">
      <div class="card bg-info text-white mb-4">
        <div class="card-header">Requested resource not found
          <a id="iconLink1" href="/admin/dashboard" class="float-right"><i
              class="bi bi-cloud-arrow-down bg-dark"></i>Back
          </a>
        </div>
        <div class="card-footer d-flex align-items-center justify-content-start">
          404 Not Found
        </div>
      </div>
    </div>
  </div>
</div>
<?php

require __DIR__ . "/includes/footer.php";