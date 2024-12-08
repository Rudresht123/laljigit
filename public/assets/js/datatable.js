function customDataTable(csrf, route, tableId, dbtable, columnsdefinition) {
    $('#'+tableId).DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: route,
            type: 'POST',
            data: {
                _token: csrf,
                columnsdefinition: columnsdefinition,
                dbtable: dbtable
            },
            dataSrc: function (json) {
                return json.data; 
            }
        },
        columns: [
            ...columnsdefinition.map(function (column) {
                return { data: column };
            })
        ],
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        order: [[0, 'asc']],  // Default sort order by the first column
    });
}



// common datatable
function intializeCustomDatatable({ route, csrf, columnsDefinition, tableId, dbtable }) {
    if ($.fn.dataTable.isDataTable(`#${tableId}`)) {
        $(`#${tableId}`).DataTable().clear().destroy();
    }

    // Initialize the DataTable
    $(`#${tableId}`).DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        sPaginationType: 'full_numbers',
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
            emptyTable: "No data available",
            processing: "Processing..."
        },
        ajax: {
            url: route,
            type: "POST",
            data: {
                'db_table': dbtable
            },
            headers: {
                'X-CSRF-TOKEN': csrf
            },
            error: function(xhr, error, thrown) {
                console.error("Ajax error:", xhr.responseText || "Unknown error occurred");
                alert("An error occurred while fetching data. Please try again.");
            }
        },
        columns: columnsDefinition,
        order: [[0, 'asc']], // Update default sorting index as per your data
        lengthMenu: [10, 25, 50, 100, 200, 500, 1000, 2000]
    });
}





// datatable for client reports



function initializeDataTableGetClientsAttorneyChartCountStatusWise(route, csrftoken, data) {
    // Destroy existing DataTable if it exists
  
    if ($.fn.dataTable.isDataTable('#clientTableCharCount')) {
        $('#clientTableCharCount').DataTable().destroy();
    }

    // Initialize DataTable with updated filters
    $('#clientTableCharCount').DataTable({
        processing: true,
        serverSide: true,
        responsive: true, 
        lengthMenu: [50, 100, 200, 500, 1000, 2000],
        lengthChange: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        ajax: {
            url: route,
            type: "POST",
            data: data, // Send data to the backend
            headers: csrftoken,
            error: function(xhr, error, thrown) {
                console.error("Ajax error:", xhr.responseText || "Unknown error occurred");
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
            { data: 'application_no', name: 'application_no' },
            { data: 'file_name', name: 'file_name' },
            { data: 'trademark_name', name: 'trademark_name' },
            { data: 'phone_no', name: 'phone_no' },
            { data: 'email_id', name: 'email_id' },
            { data: 'filed_by', name: 'filed_by' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']],
    });
}

 // datatable for client reports
function clientData(route, csrftoken) {
    // Destroy existing DataTable if it exists
    if ($.fn.dataTable.isDataTable('#clientTable')) {
        $('#clientTable').DataTable().destroy();
        $('#clientTable').empty(); // Clear table content
        $('#clientTable').html('<thead></thead><tbody></tbody>'); // Re-add thead and tbody
    }

    // Retrieve selected columns
    var selectedColumns = $('input[name="column[]"]:checked').map(function() {
        return this.value;
    }).get();

    // Default columns configuration
    var columnsConfig = [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false },
    ];

    // Ensure at least one column is selected
    if (selectedColumns.length === 0) {
        alert('Please select at least one column to display.');
        return;
    }

    // Dynamically update table headings and columns configuration
    var tableHeadings = ['#']; // For the index column
    selectedColumns.forEach(function(column) {
        columnsConfig.push({ data: column, name: column });
        tableHeadings.push(column.charAt(0).toUpperCase() + column.slice(1)); // Capitalize headings
    });

    // Add Actions column
    columnsConfig.push({
        data: 'actions',
        name: 'actions',
        orderable: false,
        searchable: false
    });
    tableHeadings.push('Actions');

    // Update <thead> with new headings
    var theadHtml = '<tr>';
    tableHeadings.forEach(function(heading) {
        theadHtml += `<th class="fw-bold bg-light">${heading}</th>`;
    });
    theadHtml += '</tr>';
    $('#clientTable thead').html(theadHtml);

    // Initialize DataTable
    $('#clientTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        lengthMenu: [10, 25, 50, 100, 200, 500, 1000, 2000],
        lengthChange: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        ajax: {
            url: route,
            type: "POST",
            headers: csrftoken,
            data: function(d) {
                d.attorney_id = $('input[name="attorney_id[]"]:checked').map(function() {
                    return this.value;
                }).get();
                d.maincategory = $('input[name="maincategory[]"]:checked').map(function() {
                    return this.value;
                }).get();
                d.status = $('input[name="status[]"]:checked').map(function() {
                    return this.value;
                }).get();
                d.start_date = $('input[name="start_date"]').val() || null;
                d.end_date = $('input[name="end_date"]').val() || null;
            },
            error: function(xhr, error, thrown) {
                console.error("Ajax error:", xhr.responseText || "Unknown error occurred");
            }
        },
        columns: columnsConfig,
        order: [[1, 'asc']],
    });
}


// block data
function blockData(route,csrf,dbtable,columnname,itemId) {
    $.ajax({
        url: route, // Replace with your actual route
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrf
        },
        data: {
           dbtable:dbtable,
           columnname:columnname,
           itemId:itemId
        },
        success: function (response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                }).then(() => {
                    location.reload(); // Reload the page to reflect changes
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to block the item. Please try again.',
                });
            }
        },
        error: function () {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'An error occurred. Please try again.',
            });
        }
    });
}
function showConfirmAlert(route,csrf,dbtable,columnname,itemId){
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Are you sure!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            
            blockData(route,csrf,dbtable,columnname,itemId);
        }
    });
}



