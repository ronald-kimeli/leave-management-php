<!-- Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
  <h4 class="mt-4">Department</h4>
  <ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Dashboard</li>
    <li class="breadcrumb-item">Department</li>
  </ol>
  <div class="row">
    <div class="col-md-12">
      <?= app\messages\AlertMessage::display(); ?>
      <div id="alertMessage" class="alert alert-dismissible fade show" role="alert"
      style="display: none; transition: opacity 1s ease;"></div>
      <div class="card">
        <div class="card-body table-responsive" id="table_body">
          <!-- Search input and Add button -->
          <div class="search-container">
            <div class="left">
              <input type="text" id="searchInput" class="form-control" placeholder="Search...">
              <button type="button" id="searchButton" class="btn btn-primary">Search</button>
            </div>
            <div class="right">
              <a class="btn btn-primary" href="/admin/department/create">ADD</a>
            </div>
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
                <th>Description</th>
                <th>Actions</th>
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


<script src="/views/assets/frontend/js/jquery.min.js"></script>
<script src="/views/assets/js/departments_page.js"></script>

<script>
  PaginationTable.init('/departments', [
    { key: 'id', label: '#' },
    { key: 'name', label: 'Name' },
    { key: 'description', label: 'Description', truncate: true },
    { key: 'actions', label: 'Actions' }
], [
    {
        label: '<i class="bi bi-eye"></i>',
        class: 'btn btn-sm btn-info view',
        url: '/admin/department/show/',
    },
    {
        label: '<i class="bi bi-pencil-square"></i>',
        class: 'btn btn-sm btn-warning edit',
        url: '/admin/department/update/',
    },
    {
        label: '<i class="bi bi-trash"></i>',
        class: 'btn btn-sm btn-danger delete',
        action: 'delete',
        url: '/admin/department/delete/'  
    }
]);

</script>

<?php

require __DIR__ . "/../components/footer.php";



