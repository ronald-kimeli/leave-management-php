<div class="container-fluid px-4">
  <h4 class="mt-4">Applied Leave</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Applied Leave</li>
  </ol>
  <div class="row">
  <div class="col-md-12 col-lg-12 col-xl-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div class="card">
        <div class="card-body table-responsive" id="table_body">
          <!-- Search input and Add button -->
          <div class="search-container">
            <div class="left">
              <input type="text" id="searchInput" class="form-control" placeholder="Search...">
              <button type="button" id="searchButton" class="btn btn-primary">Search</button>
            </div>
            <!-- <div class="right">
              <a class="btn btn-primary" href="/admin/department/create">ADD</a>
            </div> -->
          </div>

          <!-- Loading overlay -->
          <div class="loading-overlay" id="overlay">
            <div class="spinner"></div>
          </div>
          <!-- Table -->
          <table class="table table-bordered table-striped" id="dynamicTable">
            <thead class="thead-light">
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Leave</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="dynamicTableBody">
              <!-- Table rows will be populated dynamically -->
            </tbody>
          </table>

          <!-- Pagination -->
          <div class="pagination" id="paginationSection">
            <p id="paginationInfo" class="m-0">
              <!-- Pagination info will be appended dynamically -->
            </p>
            <div class="pagination-links">
              <!-- Pagination links will be appended dynamically -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Include jQuery and any necessary libraries -->
<script src="/views/assets/frontend/js/jquery.min.js"></script>
<script src="/views/assets/js/PaginationTable.js"></script>

<script>
  PaginationTable.init('/admin/appliedleave', [
    { key: 'id', label: 'ID' },
    { key1: 'applied_by.first_name', key2: 'applied_by.last_name', concat: true, label: 'Applied By' },
    { key: 'leavetype.name', label: 'Leave_Type' },
    { key: 'description', label: 'Description', truncate: true },
    { key: 'status', label: 'Status' },
    { key: 'actions', label: 'Actions' }
  ], [
    {
      label: '<i class="bi bi-eye"></i>',
      class: 'btn btn-sm btn-info view',
      url: '/admin/appliedleave/show/',
    },
    {
      label: '<i class="bi bi-pencil-square"></i>',
      class: 'btn btn-sm btn-warning edit',
      url: '/admin/appliedleave/update/',
    }
  ]);
</script>

<?php
require __DIR__ . "/../components/footer.php";
?>