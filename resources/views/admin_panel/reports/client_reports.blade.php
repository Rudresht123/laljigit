<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}
    <div class="contain-fluid px-3">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>

                        <li class="breadcrumb-item active" aria-current="page">Clients-Reports</li>
                    </ol>
                </nav>
            </div>
            <div class="d-none d-md-block">
                <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-mail wd-10 mg-r-5">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg> Email</button>
                <button id="exportClientsData" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><svg
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-printer wd-10 mg-r-5">
                        <polyline points="6 9 6 2 18 2 18 9"></polyline>
                        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
                        <rect x="6" y="14" width="12" height="8"></rect>
                    </svg> Export Data</button>
                <button data-bs-toggle="modal" data-bs-target="#importdata"
                    class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><svg xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-file wd-10 mg-r-5">
                        <path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path>
                        <polyline points="13 2 13 9 20 9"></polyline>
                    </svg> Import Data</button>
            </div>
        </div>
    </div>


    {{-- form section --}}
    <div class="custom-card col-lg-12 mx-auto mb-4">
        <div class="panel panel-default">
            <div class="panel-heading border-bottom">
                <b><i class="fa fa-filter"></i> Filter</b>
            </div>
        </div>
        <div class="panel-body pd-b-0 row">
            <div class="col-lg-12 vhr py-4">
                <form id="fillterFormData" method="POST"> <!-- Set correct action -->
                    @csrf
                    <fieldset class="form-fieldset">
                        <legend>Filter Data</legend>
                        <div class="row">
                            <!-- Attorney Selection -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Select Attorney</label>
                                    <div class="custom-select">
                                        <button type="button" class="dropdown-btn">Select options</button>
                                        <div class="select-items">
                                            <label><input type="checkbox" class="select-all"> Select All</label>
                                            @foreach ($attorneys as $attorney)
                                                <label>
                                                    <input type="checkbox" name="attorney_id[]" value="{{ $attorney->id }}"
                                                        class="option-checkbox">
                                                    {{ $attorney->attorneys_name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Main Category Selection -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Select Main Category</label>
                                    <div class="custom-select">
                                        <button type="button" class="dropdown-btn">Select options</button>
                                        <div class="select-items">
                                            <label><input type="checkbox" class="select-all"> Select All</label>
                                            @foreach ($mcategories as $mcate)
                                                <label>
                                                    <input type="checkbox" name="maincategory[]" value="{{ $mcate->id }}"
                                                        class="option-checkbox">
                                                    {{ $mcate->category_name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Selection -->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Select Status</label>
                                    <div class="custom-select">
                                        <button type="button" class="dropdown-btn">Select options</button>
                                        <div class="select-items">
                                            <label><input type="checkbox" class="select-all"> Select All</label>
                                            @foreach ($statuss as $status)
                                                <label>
                                                    <input type="checkbox" name="status[]" value="{{ $status->id }}"
                                                        class="option-checkbox">
                                                    {{ $status->status_name }}
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Unique Date Fields -->
                            <div class="col-sm-4">
                                <label class="form-label">Start Date</label>
                                <input type="text" name="start" value="{{ old('start') }}"
                                    class="form-control datepicker" placeholder="Start Date">
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">End Date</label>
                                <input type="text" name="from" value="{{ old('from') }}"
                                    class="form-control datepicker" placeholder="End Date">
                            </div>

                            <!-- Submit Button -->
                            <div class="col-sm-4 mt-3">
                                <input type="submit" class="btn btn-primary float-center px-4" value="Filter Data">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>




    {{-- form section end here --}}
    {{-- message code here --}}

    <div class="custom-card col-lg-12 mx-auto mb-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row mb-4 border-bottom pb-2">
                    <div class="col-sm-8">
                        <b><i class="fa fa-list"></i> Trademark Clients List</b>
                        {{-- <div class="btn btn-success" onclick="exportTableToExcel('clientTable')">Export Data</div> --}}
                    </div>
                </div>
            </div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr">
                    <div class="table-responsive">
                        <table id="clientTable" class="table w-100 fs-10 ">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Sr. No</th>
                                    <th class="fw-bold">Application No</th>
                                    <th class="fw-bold">File Name</th>
                                    <th class="fw-bold">Trademark Name</th>
                                    <th class="fw-bold">Phone No</th>
                                    <th class="fw-bold">Email</th>
                                    <th class="fw-bold">Field By</th>
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


    {{-- edit sattus modal start here --}}
    <!-- Button trigger modal -->
    {{-- edit status modal start here --}}
    <!-- Modal -->
    <div class="modal fade" id="editStatusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Client Status</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editSubstatusFormForClients" method="POST">
                        @csrf
                        <fieldset class="form-fieldset">
                            <legend id="clientFileName"></legend>
                            <div class="form-group">
                                <label for="" class="form-label">ClientId</label>
                                <input type="text" name="clientId" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Main Category Slug</label>
                                <input type="text" name="main_category_slug" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Category</label>
                                <select name="updateStatusMainCategory" id="" class="form-select">
                                    @foreach ($mcategories as $mcat)
                                        <option value="{{ $mcat->id }}">{{ $mcat->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Categry Status</label>
                                <select name="clientstatus" id="" class="form-select">
                                    @foreach ($subcategory as $subcat)
                                        <option value="{{ $subcat->id }}">{{ $subcat->subcategory }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="row">
                                <div class="col d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary me-2"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- edit status modal end here --}}

    <!-- Modal -->
    <div class="modal fade" id="importdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Excel File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="ClientsIomport" enctype="multipart/form-data">
                        @csrf
                        <fieldset class="form-fieldset">
                            <legend>Import Clients Data</legend>

                            <div class="form-group">
                                <label for="mcategory" class="form-label">Select Category<span
                                        class="text-danger">*</span></label>
                                <select name="category_slug" required id="category_slug" class="form-select">
                                    <option value="">Select a category</option> <!-- Placeholder option -->
                                    @foreach ($mcategories as $mcategory)
                                        <!-- Ensure $mcategories is passed to the view -->
                                        <option value="{{ $mcategory->category_slug }}">{{ $mcategory->category_name }}
                                        </option>
                                        <!-- Adjust property as necessary -->
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="excel" class="form-label">Excel File<span
                                        class="text-danger">*</span></label>
                                <input type="file" required name="excel_file" id="excel" class="form-control"
                                    accept=".xls,.xlsx"> <!-- Added accept attribute for Excel files -->
                            </div>

                            <div class="row d-flex justify-content-between">

                                <div class="col-sm-8 d-flex justify-content-between">
                                    <div class="form-group fw-bold text-primary"><a target="_blank"
                                            href="{{ asset('assets/excels_formates/trademark_clients.xlsx') }}"><i
                                                class="fa fa-file-excel" aria-hidden="true"></i> Trademark</a></div>
                                    <div class="form-group fw-bold text-primary"><a target="_blank"
                                            href="javascript:void(0)"><i class="fa fa-file-excel" aria-hidden="true"></i>
                                            Copyright</a></div>
                                    <div class="form-group fw-bold text-primary"><a target="_blank"
                                            href="javascript:void(0)"><i class="fa fa-file-excel" aria-hidden="true"></i>
                                            Design</a></div>
                                </div>
                                <div class="col-sm-4 d-flex justify-content-end"> <button type="button"
                                        class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Import</button>
                                </div>
                                <!-- Changed to type="submit" -->
                            </div>
                </div>
            </div>
        </div>
        </fieldset>
        </form>

    </div>

    {{-- import excel data modal end here --}}

    <script type="text/javascript">
        $(document).ready(function() {
            // Handle Clients Import Form Submission
            $('#ClientsIomport').on('submit', function(e) {
                e.preventDefault();
                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();
                let route = "{{ route('admin.excels-import.clients-import') }}";
                let formData = new FormData(this);

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: route,
                    type: "POST",
                    data: formData,
                    contentType: false, // Important for file uploads
                    processData: false, // Important for file uploads
                    cache: false,
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
                                $('#ClientsIomport')[0].reset(); // Reset form fields

                            }
                        });
                    },
                    error: function(xhr) {
                        $('#ld').hide(); // Hide loader on error
                        $('#overlay').hide(); // Hide overlay on error
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '<ul>'; // Start the unordered list
                            for (const field in errors) {
                                errorMessages += '<li>' + errors[field][0] +
                                    '</li>'; // Show only the first error message for each field
                            }
                            errorMessages += '</ul>'; // Close the unordered list
                            Swal.fire({
                                title: 'Validation Errors',
                                html: errorMessages, // Display errors as a list
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
         });
    </script>
    {{-- edit status start here --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#clientTable').on('click', '.editStatus', function(e) {
                e.preventDefault();

                // Get client ID, category ID, and category slug from data attributes
                let clientId = $(this).data('id');
                let cattId = $(this).data('category-id');
                let category_slug = $(this).data('category-slug');

                // Prepare form data as an object
                let formData = {
                    clientId: clientId,
                    categoryId: cattId,
                    categorySlug: category_slug,
                    _token: "{{ csrf_token() }}" // Include CSRF token for security
                };

                console.log(formData); // Check if data is being prepared correctly

                // Get the route URL using Laravel's route helper
                let route = "{{ route('admin.getClientDataForUpdate') }}";

                // Make AJAX POST request
                $.ajax({
                    url: route,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        console.log(response); // Log the entire response to see its structure

                        // Check if clientDetails exists in the response
                        if (response.clientDetails) {
                            // Set form values based on response
                            $('input[name="clientId"]').val(response.clientDetails.id);
                            $('input[name="main_category_slug"]').val(response.clientDetails.main_category
                                .category_slug);

                            $('select[name="updateStatusMainCategory"]').val(response
                                .clientDetails.category_id);
                            if (response.clientDetails.sub_category) {
                                $('select[name="clientstatus"]').val(response.clientDetails
                                    .sub_category);
                            }
                            $('#clientFileName').text(response.clientDetails
                            .)
                            $('#editStatusModal').modal(
                            'show'); // Show modal after populating the form
                        } else {
                            console.error('Unexpected response structure:', response);
                        }
                    },
                    error: function(xhr) {
                        $('#ld').hide(); // Hide loader on error
                        $('#overlay').hide(); // Hide overlay on error
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessages = '<ul>'; // Start the unordered list
                            for (const field in errors) {
                                errorMessages += '<li>' + errors[field][0] +
                                '</li>'; // Show first error message for each field
                            }
                            errorMessages += '</ul>'; // Close the unordered list
                            Swal.fire({
                                title: 'Validation Errors',
                                html: errorMessages, // Display errors as a list
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
        });
    </script>


    {{-- export data code start here --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#exportClientsData').on('click', function(e) {
                e.preventDefault();
                $('#ld').show();
                $('#overlay').show();

                let formData = $('#fillterFormData').serialize();

                $.ajax({
                    url: "{{ route('admin.excels-import.clients-export') }}",
                    type: "POST",
                    data: formData,
                    xhrFields: {
                        responseType: 'blob' // Important for downloading a file
                    },
                    success: function(response, status, xhr) {

                        // Get the filename from Content-Disposition header
                        let filename = "";
                        let disposition = xhr.getResponseHeader('Content-Disposition');
                        if (disposition && disposition.indexOf('attachment') !== -1) {
                            let matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                disposition);
                            if (matches != null && matches[1]) {
                                filename = matches[1].replace(/['"]/g, '');
                            }
                        }

                        // Create a link element for download
                        let link = document.createElement('a');
                        let url = window.URL.createObjectURL(response);
                        link.href = url;
                        link.download = filename ? filename :
                            'exported_data.xlsx'; // Fallback filename
                        document.body.appendChild(link);
                        link.click();
                        window.URL.revokeObjectURL(url);
                        link.remove();
                        $('#ld').hide();
                        $('#overlay').hide();
                        // Show SweetAlert success message
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your Excel file has been downloaded.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    },
                    error: function() {
                        $('#ld').hide();
                        $('#overlay').hide();
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong during the export.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

        });
    </script>

    <script type="text/javascript">
    $('#fillterFormData').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        let route = "{{ route('admin.getFiellterClientsData') }}";
        let csrftoken = { 'X-CSRF-TOKEN': '{{ csrf_token() }}' };
        initializeDataTableGetCLients(route, csrftoken); // Reinitialize DataTable with updated filters
    });
    </script>
@endsection
