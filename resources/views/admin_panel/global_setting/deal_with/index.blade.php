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
            <li class="breadcrumb-item active" aria-current="page">Define-Dealler</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading"><b><i class="fa fa-list"></i> dealler List</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <button type="button" data-bs-toggle="modal" data-bs-target="#addModal"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-4">
                        <i class="fa fa-plus"></i> Add New Dealler
                    </button>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="table-responsive">
                        <table id="deallerTable" class="table table-hover w-100 fs-10">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Dealler Name</th>
                                    <th class="fw-bold">Status</th>
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

   
  
    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel"><i class="fa fa-plus" aria-hidden="true"></i> Add
                        New Dealler</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="addStatus" method="POST">
                        @csrf
                        <fieldset class="form-fieldset">
                            <legend>Dealler Information</legend>
                        <div class="gorm-group ">
                            <label for="" class="form-label">Dealler Name <span
                                    class="text-danger">*</span></label>
                                    <input name="dealler_name" type="text" class="form-control" required placeholder="dealler Name...">
                        </div>
                        <div class="gorm-group ">
                            <label for="" class="form-label">Status<span class="text-danger">*</span></label>
                           <select class="form-select" name="status" id="">
                            <option value="yes">Active</option>
                            <option value="no">De-Active</option>
                           </select>
                        </div>
                    <div class="row mt-3">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                    </fieldset>
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
                        Edit
                       Dealler</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form id="editStatus" method="POST">
                        @csrf
                        <fieldset class="form-fieldset">
                            <legend>Dealler Information</legend>
                            <div class="form-group">
                                <input type="text" hidden class="form-control" name="status_id" value="" id="status_id">
                            </div>
                        <div class="gorm-group ">
                            <label for="" class="form-label">dealler Name <span
                                    class="text-danger">*</span></label>
                                    <input name="dealler_name" type="text" class="form-control" required placeholder="dealler Name...">

                        </div>
                        <div class="gorm-group ">
                            <label for="" class="form-label">Status<span class="text-danger">*</span></label>
                           <select class="form-select" name="status" id="">
                            <option value="yes">Active</option>
                            <option value="no">De-Active</option>
                           </select>
                        </div>                     
                        <div class="row mt-3">
                            <div class="col d-flex justify-content-end">
                                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                        </fieldset>
                    </form>
                </div>
            </div>

        </div>
    </div>
    {{-- end here add modal --}}
    <script class="text/javascript">
        $(document).ready(function() {
            // Handle Add Financial Year Form Submission
            $('#addStatus').on('submit', function(e) {
                e.preventDefault();
                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();
                let route = "{{ route('admin.global-setting.create-dealler') }}";
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
                                $('#addStatus')[0].reset(); // Reset form fields
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
            $('#deallerTable').on('click','.editButton', function(e) {
                e.preventDefault();
                let statusId = $(this).data('id');
                let route = "{{ route('admin.global-setting.edit-dealler', ':id') }}".replace(':id',
                statusId);

                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('input[name="status_id"]').val(response.id);
                        $('input[name="dealler_name"]').val(response.dealler_name);
                        $('select[name="status"]').val(response.status);

                        $('#editModal').modal('show'); // Show modal properly
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });

            // Handle Edit Financial Year Form Submission
            $('#editStatus').on('submit', function(e) {
                e.preventDefault();
                let statusId = $('#status_id').val(); // Get the year ID again if needed
                let route = "{{ route('admin.global-setting.update-dealler', ':id') }}".replace(':id',
                statusId);
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
            $('#deallerTable').on('click','.deletebutton', function(e) {
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
                        let statusId = $(this).data('id');
                        route = "{{ route('admin.global-setting.destroy-dealler', ':id') }}"
                            .replace(':id', statusId);
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
    
                let columnsDefinition = [{
                        data: 'dealler_name',
                        name: 'dealler_name'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    tableId: 'deallerTable', // Assign the table ID
                    dbtable: 'deal_with' // Assign the database table name
                });
            });
        </script>
            
        
@endsection
