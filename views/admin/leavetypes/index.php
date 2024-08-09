<?php require __DIR__ . "/../confirmation_modal.php"; ?>

<div class="container-fluid px-4">
    <h4 class="mt-4">Leave Type</h4>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Leave Type</li>
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
                            <a class="btn btn-primary" href="/admin/leavetype/create">ADD</a>
                        </div>
                    </div>

                    <!-- Loading overlay -->
                    <div class="loading-overlay" id="overlay">
                        <div class="spinner"></div>
                    </div>

                    <table class="table table-bordered table-striped" id="leaveTypeTable">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
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
<script src="/views/assets/js/departments_page.js"></script>

<script>
    PaginationTable.init('/admin/leavetypes/index', [
        { key: 'id', label: 'ID' },
        { key: 'name', label: 'Leave Type' },
        { key: 'description', label: 'Description', truncate: true },
        { key: 'actions', label: 'Actions' }
    ], [
        {
            label: '<i class="bi bi-eye"></i>',
            class: 'btn btn-sm btn-info',
            url: '/admin/leavetype/show/',
        },
        {
            label: '<i class="bi bi-pencil-square"></i>',
            class: 'btn btn-sm btn-warning edit',
            url: '/admin/leavetype/update/',
        },
        {
        label: '<i class="bi bi-trash"></i>',
        class: 'btn btn-sm btn-danger delete',
        action: 'delete',
        url: '/admin/leavetype/delete/'  
    }
    ]);
</script>

<?php require __DIR__ . "/../components/footer.php"; ?>