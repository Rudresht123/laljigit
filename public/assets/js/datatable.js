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
function initializeDataTableGetCLients(route, csrftoken) {
    // Destroy existing DataTable if it exists
    if ($.fn.dataTable.isDataTable('#example2')) {
        $('#example2').DataTable().clear().destroy();
    }

    // Initialize DataTable with updated filters
    $('#example2').DataTable({
        responsive: true,
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
            lengthMenu: '_MENU_ items/page',
        },
        ajax: {
            url: route,
            type: "POST",
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
            headers: csrftoken,
            error: function(xhr, error, thrown) {
                console.error("Ajax error:", xhr.responseText || "Unknown error occurred");
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true },
            { data: 'application_no', name:'application_no' },
            { data: 'file_name', name: 'file_name' },
            { data: 'trademark_name', name: 'trademark_name' },
            { data: 'phone_no', name: 'phone_no' },
            { data: 'email_id', name: 'email_id' },
            { data: 'filed_by', name: 'filed_by' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ],
        order: [[0, 'asc']],
        lengthMenu: [10, 25, 50, 100, 200, 500, 1000, 2000],
    });
}

