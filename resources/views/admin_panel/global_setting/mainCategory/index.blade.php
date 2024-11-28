<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Main-Category</li>
        </ol>
    </nav>


    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading"><b><i class="fa fa-list"></i> Main-Category</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <a href="" data-bs-toggle="modal" data-bs-target="#addMainCategory"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Add Category
                    </a>
                    <a href="{{ route('admin.global-setting.sub-category') }}"
                        class="btn btn-block mg-t-10 btn-outline-danger btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Sub-Category
                    </a>

                    <button type="button" class="btn btn-block btn-outline-dark mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-times"></i> Dashboard</button>
                    <a href="{{ route('admin.global-setting.show-sub-category') }}" type="button"
                        class="btn btn-block btn-outline-success mg-t-10 btn-sm rounded-pill px-4"><i class="fa fa-print"
                            aria-hidden="true"></i> Show-Sub</a>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="table-responsive">
                        <table id="mainCategorytable" class="table table-hover fs-10 w-100 text-center">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Category Name</th>
                                    <th class="fw-bold text-center">Remarks</th>
                                    <th class="fw-bold">Slug</th>
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

    {{-- main section start here --}}


    {{-- add modal start here --}}
    <!-- Modal -->
    <div class="modal fade" id="addMainCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Main Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="addMainCategoryForm" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="modal-body">
                        <fieldset class="form-fieldset">
                            <legend>Main Category Infformation</legend>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="category_name" class="form-control"
                                    placeholder="Enter Category Name...">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Remark<span
                                        class="text-danger">*</span></label>
                                <textarea name="remark" class="form-control" cols="2" rows="2" placeholder="Category Remark.."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Slug<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="category_slug" class="form-control"
                                    placeholder="Enter Category Slug...">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Icon<span
                                        class="text-danger">*</span></label>
                                <input type="file" name="category_icon" class="form-control"
                                    placeholder="Enter Category Icon...">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Status<span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-select" id="">
                                    <option value="yes" selected>Active</option>
                                    <option value="no">De-Active</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- add modal end here --}}



    {{-- add modal start here --}}
    <!-- Modal -->
    <div class="modal fade" id="editMainCategory" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Main Category</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editMainCategoryForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <fieldset class="form-fieldset">
                            <legend>Main Category Infformation</legend>
                            <input type="text" id="category_id" name="id" hidden class="form-control"
                                placeholder="Enter Category ID...">

                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="category_name" class="form-control"
                                    placeholder="Enter Category Name...">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Remark<span
                                        class="text-danger">*</span></label>
                                <textarea name="remark" class="form-control" cols="5" rows="5" placeholder="Category Remark.."></textarea>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Slug<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="category_slug" class="form-control"
                                    placeholder="Enter Category Slug...">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Icon<span
                                        class="text-danger">*</span></label>
                                <input type="file" name="category_icon" class="form-control"
                                    placeholder="Enter Category Icon...">
                                <span class="text-danger fw-bold">**Select if you want to be changed</span>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label fw-bold">Category Status<span
                                        class="text-danger">*</span></label>
                                <select name="status" class="form-select" id="">
                                    <option value="yes" selected>Active</option>
                                    <option value="no">De-Active</option>
                                </select>
                            </div>
                        </fieldset>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    {{-- add modal end here --}}
    {{-- delete script start here --}}
    <script type="text/javascript">
        $(document).ready(function() {
            // Handle Add Main Category Year Form Submission
            $('#addMainCategoryForm').on('submit', function(e) {
                e.preventDefault();

                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();

                let route = "{{ route('admin.global-setting.create-main-category') }}";
                let formData = new FormData(this); // Using FormData to handle file uploads

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Ensure correct headers
                    },
                    url: route,
                    type: "POST",
                    data: formData,
                    processData: false, // Important for file uploads
                    contentType: false, // Important for file uploads
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
                                $('#addMainCategoryForm')[0]
                                    .reset(); // Reset form fields
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
            $('#mainCategorytable').on('click','.editButton', function(e) {
                e.preventDefault();
                let categoryId = $(this).data('id');
                let route = "{{ route('admin.global-setting.edit-main-category', ':id') }}".replace(':id',
                    categoryId);

                $.ajax({
                    url: route,
                    type: 'GET',
                    success: function(response) {
                        console.log(response);
                        $('input[name="id"]').val(response.id);
                        $('input[name="category_slug"]').val(response.category_slug);
                        $('input[name="category_name"]').val(response.category_name);
                        $('textarea[name="remark"]').val(response.remark);
                        $('select[name="status"]').val(response.status);
                        $('#editMainCategory').modal('show'); // Show modal properly
                    },
                    error: function(xhr, status, error) {
                        console.log('Error:', error);
                    }
                });
            });
            // Handle Edit Financial Year Form Submission
            $('#editMainCategoryForm').on('submit', function(e) {
                e.preventDefault();

                let yearId = $('#category_id').val(); // Ensure category_id exists and has a value
                let route = "{{ route('admin.global-setting.edit-main-category', ':id') }}".replace(':id',
                    yearId);

                let formData = new FormData(this);

                // Spoof the PUT method for Laravel
                formData.append('_method', 'PUT');

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Make sure CSRF token is passed correctly
                    },
                    url: route,
                    type: "POST", // Use POST since we are spoofing the method
                    data: formData,
                    processData: false, // Important for file uploads
                    contentType: false, // Important for file uploads
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


            $('#mainCategorytable').on('click','.deletebutton', function(e) {
                e.preventDefault();
                let categoryId = $(this).data('id');
                let route = "{{ route('admin.global-setting.delete-main-category', ':id') }}".replace(
                    ':id',
                    categoryId);

                // Confirmation using Swal.fire
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with deletion
                        $('#ld').show();
                        $('#overlay').show();

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: route,
                            type: 'DELETE',
                            success: function(response) {
                                $('#ld').hide();
                                $('#overlay').hide();
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.success
                                    }).then(() => {
                                        window.location
                                            .reload(); // Reload the page after success
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.error
                                    });
                                }
                            },
                            error: function(xhr) {
                                $('#ld').hide();
                                $('#overlay').hide();
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong!'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
    {{-- delete script start here --}}

    {{-- /datatable initialization --}}
    <script type="text/javascript">
        $(document).ready(function() {
            let route = "{{ route('admin.common.datatable') }}";
            let csrf = "{{ csrf_token() }}";

            let columnsDefinition = [{
                    data: 'category_name',
                    name: 'category_name'
                },
                {
                    data: 'remark',
                    name: 'remark'
                },
                {
                    data: 'category_slug',
                    name: 'category_slug'
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
                tableId: 'mainCategorytable', // Assign the table ID
                dbtable: 'main_category' // Assign the database table name
            });
        });
    </script>
@endsection
