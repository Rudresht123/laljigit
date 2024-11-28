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
            <li class="breadcrumb-item active" aria-current="page">Remarks</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading"><b><i class="fa fa-list"></i> Remarks List</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Add Remarks
                    </button>

                    <button type="button" class="btn btn-block btn-outline-dark mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-times"></i> Dashboard</button>
                    <button type="button" class="btn btn-block btn-outline-success mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-print" aria-hidden="true"></i> Print PDF</button>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="table-responsive">
                        <table id="remarksTable" class="table table-hover w-100  fs-10 ">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Remarks</th>
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
                        New Remarks</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-fieldset">
                        <legend>Remarks Information</legend>
                        <form id="addNewRemarks" method="POST">
                            @csrf


                            <div class="gorm-group ">
                                <label for="" class="form-label">Remarks<span class="text-danger">*</span></label>
                                <textarea name="remarks" required class="form-control" id="" cols="5" rows="5 "></textarea>
                            </div>
                            <div class="gorm-group ">
                                <label for="" class="form-label">Is-Active<span class="text-danger">*</span></label>
                                <select name="is_active" required class="form-control" id="">
                                    <option value="yes">Active</option>
                                    <option value="no">De-Active</option>
                                </select>
                            </div>
                            <div class="row mt-3">
                                <div class="col  d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-1 px-2 p-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary px-2 p-1">Save</button>
                                </div>
                            </div>

                        </form>
                    </fieldset>
                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus" aria-hidden="true"></i>
                        Edit
                        Remarks</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <fieldset class="form-fieldset">
                        <legend>Remarks Information</legend>
                        <form id="editRemarks" method="POST">
                            @csrf
                            <div class="gorm-group " hidden>
                                <label for="" class="form-label">Remarks ID<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="remarks_id" id="remarks_id" required class="form-control">
                            </div>
                            <div class="gorm-group ">
                                <label for="" class="form-label">Remarks<span
                                        class="text-danger">*</span></label>
                                <textarea name="remarks" required class="form-control" id="" cols="5" rows="5 "></textarea>
                            </div>
                            <div class="gorm-group ">
                                <label for="" class="form-label">Is-Active<span
                                        class="text-danger">*</span></label>
                                <select name="is_active" required class="form-control" id="">
                                    <option value="yes">Active</option>
                                    <option value="no">De-Active</option>
                                </select>
                            </div>
                            <div class="row mt-3">
                                <div class="col  d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-1 px-2 p-1"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary px-2 p-1">Save</button>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>

        </div>
    </div>
    {{-- end here add modal --}}
    <script class="text/javascript">
        $(document).ready(function() {
            // Handle Add Financial Year Form Submission
            $('#addNewRemarks').on('submit', function(e) {
                e.preventDefault();
                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();
                let route = "{{ route('admin.global-setting.create-remarks') }}";
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
                            text: response.success,
                            icon: 'success',
                            confirmButtonText: 'Okay'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#addNewRemarks')[0].reset(); // Reset form fields
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
            $('#remarksTable').on('click','.editButton', function(e) {
                e.preventDefault();
                let remarksId = $(this).data('id');
                let route = "{{ route('admin.global-setting.edit-remarks', ':id') }}".replace(':id',
                    remarksId);

                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('input[name="remarks_id"]').val(response.id);
                        $('textarea[name="remarks"]').val(response.remarks);
                        $('select[name="is_active"]').val(response.is_active);

                        // Set checkbox status
                        $('#editModal').modal('show'); // Show modal properly
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Handle Edit Financial Year Form Submission
            $('#editRemarks').on('submit', function(e) {
                e.preventDefault();
                let remarkId = $('#remarks_id').val(); // Get the year ID again if needed
                let route = "{{ route('admin.global-setting.edit-remarks', ':id') }}".replace(':id',
                    remarkId);
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
                            text: response.success,
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
            $('#remarksTable').on('click','.deletebutton', function(e) {
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
                        route = "{{ route('admin.global-setting.delete-remarks', ':id') }}"
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


 {{-- /datatable initialization --}}
 <script type="text/javascript">
    $(document).ready(function() {
        let route = "{{ route('admin.common.datatable') }}";
        let csrf = "{{ csrf_token() }}";

        let columnsDefinition = [
            {
                data: 'remarks',
                name: 'remarks'
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
            tableId: 'remarksTable', // Assign the table ID
            dbtable: 'remarks' // Assign the database table name
        });
    });
</script>
@endsection
