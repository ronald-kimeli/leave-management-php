var PaginationTable = (function () {
    var apiUrl;
    var tableColumns;
    var currentPage = 1;
    var paginationInfo = {};
    var actions = [];

    function init(apiUrlParam, columnsParam, actionsParam) {
        apiUrl = apiUrlParam;
        tableColumns = columnsParam;
        actions = actionsParam;

        // Load saved state
        var savedPage = localStorage.getItem('currentPage');
        var savedSearchQuery = localStorage.getItem('searchQuery');
        
        if (savedPage) {
            currentPage = parseInt(savedPage, 10);
        }
        
        if (savedSearchQuery) {
            $('#searchInput').val(savedSearchQuery);
        }

        fetchData(currentPage, savedSearchQuery || '');
        setupEventHandlers();
    }

    function fetchData(page, search = '') {
        showLoadingOverlay();

        $.ajax({
            url: apiUrl,
            method: 'GET',
            dataType: 'json',
            data: {
                page: page,
                search: search
            },
            success: function (response) {
                paginationInfo = response.pagination;
                populateTable(response.data, page);
                renderPaginationInfo();
                renderPaginationLinks();

                // Save current state to localStorage
                localStorage.setItem('currentPage', page);
                localStorage.setItem('searchQuery', search);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
                $('#dynamicTableBody').html('<tr><td colspan="' + tableColumns.length + '">Error fetching data. Please try again.</td></tr>');
            },
            complete: function () {
                hideLoadingOverlay();
            }
        });
    }

    function populateTable(data, page) {
        var tableBody = $('#dynamicTableBody');
        tableBody.empty();
        var startId = (page - 1) * paginationInfo.items_per_page + 1;

        if (data.length < 1) {
            tableBody.html('<tr><td colspan="' + tableColumns.length + '">No records found.</td></tr>');
            $('#paginationInfo').html('Showing 0 entries');
            $('.pagination-links').empty();
        } else {
            data.forEach(function (item, index) {
                var row = '<tr>';
                tableColumns.forEach(function (column) {
                    if (column.key === 'actions') {
                        row += '<td class="action-icons">';
                        actions.forEach(function (action) {
                            var button;
                            if (action.action === 'delete') {
                                button = '<button class="' + action.class + '" data-id="' + item.id + '" data-url="' + action.url + '">' + action.label + '</button> ';
                            } else {
                                var url = action.url + item.id; // Construct URL with dynamicTable ID
                                button = '<a href="' + url + '" class="' + action.class + '">' + action.label + '</a> ';
                            }
                            row += button;
                        });
                        row += '</td>';
                    } else {
                        var cellContent = item;
                        if (column.key) {
                            var keys = column.key.split('.');
                            keys.forEach(function (key) {
                                if (cellContent && cellContent.hasOwnProperty(key)) {
                                    cellContent = cellContent[key];
                                } else {
                                    cellContent = ''; // Set to empty if property doesn't exist
                                }
                            });
                        } else if (column.key1 && column.key2 && column.concat) {
                            // Handle dynamic concatenation
                            var value1 = getValueFromNestedKey(item, column.key1);
                            var value2 = getValueFromNestedKey(item, column.key2);
                            cellContent = value1 + ' ' + value2;
                        }

                        if (column.key === 'id') {
                            cellContent = startId + index;
                        } else if (column.key === 'description' && column.truncate) {
                            cellContent = truncateString(cellContent);
                        }

                        row += '<td>' + cellContent + '</td>';
                    }
                });
                row += '</tr>';
                tableBody.append(row);
            });

            // Unbind previous click handlers to avoid multiple bindings
            $(document).off('click', '.delete');

            // Add event handlers for the delete buttons
            $(document).on('click', '.delete', function () {
                var id = $(this).data('id');
                var url = $(this).data('url') + id; // Construct URL with dynamicTable ID

                // Store the URL in a data attribute for the confirmation button
                $('#confirmDeleteButton').data('url', url);

                // Show the confirmation modal
                $('#deleteConfirmationModal').modal('show');
            });

            // Add event handler for the confirmation button
            $('#deleteConfirmationModal').off('click', '#confirmDeleteButton'); // Unbind previous handler
            $('#deleteConfirmationModal').on('click', '#confirmDeleteButton', function () {
                var url = $(this).data('url'); // Get the URL from the data attribute
                deleteItem(url); // Call the delete function with the URL
                $('#deleteConfirmationModal').modal('hide'); // Hide the modal after deletion
            });

            // Add event handler for the cancel button
            $('#deleteConfirmationModal').off('click', '.btn-secondary'); // Unbind previous handler
            $('#deleteConfirmationModal').on('click', '.btn-secondary', function () {
                // Hide the modal when cancel is clicked
                $('#deleteConfirmationModal').modal('hide');
            });
        }
    }

    function getValueFromNestedKey(obj, key) {
        if (!obj || !key) return ''; // Check if obj or key is undefined or null

        var keys = key.split('.');
        var value = obj;

        keys.forEach(function (k) {
            if (value && value.hasOwnProperty(k)) {
                value = value[k];
            } else {
                value = ''; // Set to empty if property doesn't exist
            }
        });

        return value;
    }

    function truncateString(string, width = 50) {
        if (string.length > width) {
            return string.substring(0, width) + '...';
        } else {
            return string;
        }
    }

    function renderPaginationInfo() {
        const { total_items, current_page, items_per_page } = paginationInfo;
        const startItem = (current_page - 1) * items_per_page + 1;
        const endItem = Math.min(current_page * items_per_page, total_items);

        $('#paginationInfo').html(`Showing ${startItem} to ${endItem} of ${total_items} entries`);
    }

    function renderPaginationLinks() {
        var paginationSection = $('.pagination-links');
        paginationSection.empty();

        const { total_pages, current_page, next_page, previous_page } = paginationInfo;
        const links = [];

        const addNumericPageButton = (page) => {
            links.push(
                $('<button>')
                    .text(page)
                    .toggleClass('active', current_page === page)
                    .on('click', function () {
                        if (current_page !== page) {
                            fetchData(page, $('#searchInput').val());
                        }
                    })
            );
        };

        links.push(
            $('<button>')
                .text('First')
                .prop('disabled', current_page === 1)
                .on('click', function () {
                    if (current_page > 1) {
                        fetchData(1, $('#searchInput').val());
                    }
                })
        );

        links.push(
            $('<button>')
                .html('&laquo;')
                .prop('disabled', current_page === 1)
                .on('click', function () {
                    if (previous_page) {
                        fetchData(previous_page, $('#searchInput').val());
                    }
                })
        );

        const maxButtonCount = 3;
        let startPage, endPage;

        if (total_pages < 3) {
            startPage = 1;
            endPage = total_pages;
        } else {
            startPage = Math.max(1, current_page - Math.floor(maxButtonCount / 2));
            endPage = Math.min(total_pages, startPage + maxButtonCount - 1);

            if (current_page > total_pages - Math.floor(maxButtonCount / 2)) {
                startPage = total_pages - maxButtonCount + 1;
                endPage = total_pages;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            addNumericPageButton(i);
        }

        links.push(
            $('<button>')
                .html('&raquo;')
                .prop('disabled', current_page === total_pages)
                .on('click', function () {
                    if (next_page) {
                        fetchData(next_page, $('#searchInput').val());
                    }
                })
        );

        links.push(
            $('<button>')
                .text('Last')
                .prop('disabled', current_page === total_pages)
                .on('click', function () {
                    if (current_page < total_pages) {
                        fetchData(total_pages, $('#searchInput').val());
                    }
                })
        );

        paginationSection.append(links);
    }

    function showLoadingOverlay() {
        var overlay = $('<div class="loading-overlay"><div class="spinner"></div></div>');
        $('body').append(overlay);
        $('.loading-overlay').show();
    }

    function hideLoadingOverlay() {
        $('.loading-overlay').remove();
    }

    function setupEventHandlers() {
        $('#searchButton').on('click', function () {
            var searchQuery = $('#searchInput').val().trim();
            fetchData(1, searchQuery);
        });
        
        $('#logoutButton').on('click', function () {
            localStorage.removeItem('currentPage');
            localStorage.removeItem('searchQuery');
        });
    }

    function deleteItem(url) {
        var $deleteButton = $('#confirmDeleteButton');
        $deleteButton.prop('disabled', true);

        $.ajax({
            url: url,
            method: 'DELETE',
            success: function (response) {
                console.log('Server Response:', response);
                fetchData(currentPage, $('#searchInput').val()); 
            },
            error: function (xhr, status, error) {
                console.error('Error deleting item:', error);
                console.error('Response:', xhr.responseText);
            },
            complete: function () {
                $deleteButton.prop('disabled', false);
                $('#deleteConfirmationModal').modal('hide'); 
            }
        });
    }

    return {
        init: init
    };
})();








