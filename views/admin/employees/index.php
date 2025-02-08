<?php require __DIR__ . "/../confirmation_modal.php"; ?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Employees</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Employees</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <?= app\messages\AlertMessage::display(); ?>
            <div class="card">
                <div class="card-body table-responsive" id="table_body">
                    <div class="search-container">
                        <div class="left">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                            <button type="button" id="searchButton" class="btn btn-primary">Search</button>
                        </div>
                        <div class="right">
                            <a class="btn btn-primary" href="/admin/employee/create">ADD</a>
                        </div>
                    </div>

                    <!-- Loading overlay -->
                    <div class="loading-overlay" id="overlay">
                        <div class="spinner"></div>
                    </div>

                    <table class="table table-bordered table-striped" id="employeeTable">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Role</th>
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
    PaginationTable.init('/admin/employees/index', [
        { key: 'id', label: 'ID' },
        { key1: 'first_name', key2: 'last_name', concat: true, label: 'First Name' },
        { key: 'department.name', label: 'Department' },
        { key: 'verify_status', label: 'Status' },
        { key: 'role.name', label: 'Role' },
        { key: 'actions', label: 'Actions' }
    ], [
        {
            label: '<i class="bi bi-eye"></i>',
            class: 'btn btn-sm btn-info view',
            url: '/admin/employee/show/',
        },
        {
            label: '<i class="bi bi-pencil-square"></i>',
            class: 'btn btn-sm btn-warning edit',
            url: '/admin/employee/update/',
        },
        {
            label: '<i class="bi bi-trash"></i>',
            class: 'btn btn-sm btn-danger delete',
            action: 'delete',
            url: '/admin/employee/delete/'
        }
    ]);
</script>

<?php require __DIR__ . "/../components/footer.php"; ?>