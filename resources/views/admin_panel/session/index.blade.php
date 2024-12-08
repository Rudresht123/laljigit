<!-- exteinding master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- exteinding master layout here -->


@section('main-content')
    {{-- main section start here --}}

    {{-- table section satrt here --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Financial Year</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading"><b><i class="fa fa-list"></i> Financial Year List</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Add Session
                    </button>

                    <button type="button" class="btn btn-block btn-outline-dark mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-times"></i> Dashboard</button>
                    <button type="button" class="btn btn-block btn-outline-success mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-print" aria-hidden="true"></i> Print PDF</button>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="table-responsive">
                        <table id="sessionTable" class="table table-hover w-100  fs-10 ">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Financial Year</th>
                                    <th class="fw-bold">Start Date</th>
                                    <th class="fw-bold">End Date</th>
                                    <th class="fw-bold">Is-Active</th>
                                    <th class="fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>


    </div>

    {{-- table section satrt here --}}



    {{-- new financial moda add --}}
    <!-- Button trigger modal -->

    <!-- Modal -->
    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Add
                        New Financial Year</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addFinancialYear" method="POST">
                        @csrf
                        <div class="gorm-group ">
                            <label for="" class="form-label">Financial Year <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="financial_session" autocomplete="off" class="form-control input-sm"
                                required placeholder="Enter Financial Year Like : 2019-2020">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" class="form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" name="start_date" autocomplete="off" class="form-control input-sm"
                                    required placeholder="Enter Satrt Date like : dd-mm-yyyy ">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="" class="form-label">End Date<span class="text-danger">*</span></label>
                                <input type="date" name="end_date" required autocomplete="off"
                                    class="form-control date input-sm hasDatepicker"
                                    placeholder="Enter End Date (dd-mm-yyyy)">
                            </div>
                            <div class="mb-3">
                                <b>Default Active : </b> <input type="checkbox" name="is_active">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus" aria-hidden="true"></i>
                        Add
                        New Financial Year</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="editFinancialYear" method="POST">
                        @csrf
                        <div class="gorm-group hidden">
                            <label for="" class="form-label">Financial ID <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="financial_session_id" readonly name="financial_session_id"
                                autocomplete="off" class="form-control input-sm" required
                                placeholder="Enter Financial Year Like : 2019-2020">
                        </div>
                        <div class="gorm-group ">
                            <label for="" class="form-label">Financial Year <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="financial_session" name="financial_session" autocomplete="off"
                                class="form-control input-sm" required
                                placeholder="Enter Financial Year Like : 2019-2020">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label for="" class="form-label">Start Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" id="financial_session" name="start_date" autocomplete="off"
                                    class="form-control input-sm" required
                                    placeholder="Enter Satrt Date like : dd-mm-yyyy ">
                            </div>
                            <div class="col-sm-6 form-group">
                                <label for="" class="form-label">End Date<span
                                        class="text-danger">*</span></label>
                                <input type="date" id="end_date" name="end_date" required autocomplete="off"
                                    class="form-control date input-sm hasDatepicker"
                                    placeholder="Enter End Date (dd-mm-yyyy)">
                            </div>
                            <div class="mb-3">
                                <b>Default Active : </b> <input type="checkbox" name="is_active">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    {{-- end here add modal --}}
    <script class="text/javascript">
        $(document).ready(function() {
            // Handle Add Financial Year Form Submission
            $('#addFinancialYear').on('submit', function(e) {
                e.preventDefault();
                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();
                let route = "{{ route('admin.global-setting.financialYear') }}";
                let formData = $(this).serialize();

                $.ajax({
                    headrs: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: route,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        $('#ld').hide(); // Hide loader
                        $('#overlay').hide(); // Hide overlay
                        Swal.fire({
                            title: 'Success!',
                            text: 'Data saved successfully!',
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addFinancialYear')[0].reset(); // Reset form fields
                                window.location.reload(); // Reload the page
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#ld').hide(); // Hide loader on error
                        $('#overlay').hide(); // Hide overlay on error
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            for (const field in errors) {
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }
                            Swal.fire({
                                title: 'Validation Errors',
                                html: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                            console.error(xhr); // Optional: Log the error for debugging
                        }
                    }
                });
            });

            // Handle Edit Button Click
            $('#sessionTable').on('click', '.editButton', function(e) {
                e.preventDefault();
                let yearId = $(this).data('id');
                let route = "{{ route('admin.global-setting.edit.financialYear', ':id') }}".replace(':id',
                    yearId);

                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('input[name="financial_session_id"]').val(response.id);
                        $('input[name="financial_session"]').val(response.financial_session);
                        $('input[name="start_date"]').val(response.start_date);
                        $('input[name="end_date"]').val(response.end_date);
                        $('input[name="is_active"]').prop('checked', response.is_active ===
                            'yes'); // Set checkbox status
                        $('#editModal').modal('show'); // Show modal properly
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Handle Edit Financial Year Form Submission
            $('#editFinancialYear').on('submit', function(e) {
                e.preventDefault();
                let yearId = $('#financial_session_id').val(); // Get the year ID again if needed
                let route = "{{ route('admin.global-setting.edit.financialYear', ':id') }}".replace(':id',
                    yearId);
                let formData = $(this).serialize();

                $.ajax({
                    headrs: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: route,
                    type: "PUT",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Financial Year updated successfully!',
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload(); // Reload the page
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '';
                            for (const field in errors) {
                                errorMessages += errors[field].join('<br>') + '<br>';
                            }
                            Swal.fire({
                                title: 'Validation Errors',
                                html: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'An error occurred: ' + xhr.responseText,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        }
                    }
                });
            });
            $('#sessionTable').on('click', '.deletebutton', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Code to perform the action (e.g., delete)
                        let yearId = $(this).data('id');
                        route = "{{ route('admin.global-setting.delete.financialYear', ':id') }}"
                            .replace(':id', yearId);
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: route,
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.success,
                                    }).then(($result) => {
                                        if ($result.isConfirmed) {
                                            window.location.reload();
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.error,
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("Error Status: " + status);
                                console.log("Error Thrown: " + error);
                                console.log("Response Text: " + xhr.responseText);
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'An error occurred: ' + xhr
                                        .responseText,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            }
                        });
                    }
                });

            });
        });
    </script>
    {{-- datatable initialization --}}
    <script type="text/javascript">
        $(document).ready(function() {
            let route = "{{ route('admin.common.datatable') }}";
            let csrf = "{{ csrf_token() }}";

            let columnsDefinition = [{
                    data: 'financial_session',
                    name: 'financial_session'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                },
                {
                    data: 'is_active',
                    name: 'is_active'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                }
            ];

            intializeCustomDatatable({
                route: route, // Correctly assign the route
                csrf: csrf, // Correctly assign the CSRF token
                columnsDefinition: columnsDefinition, // Assign columnsDefinition
                tableId: 'sessionTable', // Assign the table ID
                dbtable: 'financial_year' // Assign the database table name
            });

            // block unbloc code hereunBlockButton
             // block unbloc code here
             $('#sessionTable').on('click', '.blockButton', function(e) 
        {
    e.preventDefault();
    let itemId = $(this).data('id'); 
    let csrf = "{{ csrf_token() }}"; 
    let route = "{{ route('admin.block-data') }}"; 
    let dbtable = "financial_year"; 
    let columnname = "is_active";
    showConfirmAlert(route, csrf, dbtable, columnname, itemId);
});
    $('#sessionTable').on('click', '.blockButton', function(e) 
        {
    e.preventDefault();
    let itemId = $(this).data('id'); 
    let csrf = "{{ csrf_token() }}"; 
    let route = "{{ route('admin.block-data') }}"; 
    let dbtable = "financial_year"; 
    let columnname = "is_active";
    showConfirmAlert(route, csrf, dbtable, columnname, itemId);
});
         
         
        });
    </script>
@endsection
