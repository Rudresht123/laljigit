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

                        <li class="breadcrumb-item active" aria-current="page">Clients-Reports-Attorney-Chart-Status-Wise</li>
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
                <!--<button id="exportClientsData" class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><svg-->
                <!--        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"-->
                <!--        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"-->
                <!--        class="feather feather-printer wd-10 mg-r-5">-->
                <!--        <polyline points="6 9 6 2 18 2 18 9"></polyline>-->
                <!--        <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>-->
                <!--        <rect x="6" y="14" width="12" height="8"></rect>-->
                <!--    </svg> Export Data</button>-->
        </div>
    </div>


    {{-- form section --}}
   




    {{-- form section end here --}}
    {{-- message code here --}}

    <div class="custom-card col-lg-12 mx-auto mb-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row mb-4 border-bottom pb-2">
                    <div class="col-sm-8">
                        <b><i class="fa fa-list"></i> Trademark Clients List </b> <b class="text-primary">[Attorney : {{ $attorney->attorneys_name ?? ''}}] - [Status : {{ $status->status_name ?? ''}}]</b>
                    </div>
                </div>
            </div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr">
                    <div class="table-responsive">
                        <table id="clientTableCharCount" class="table w-100 fs-10 ">
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



   

    {{-- import excel data modal end here --}}
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
    $(document).ready(function(){
        let category = 'trademark';
        let status = @json($status->id ?? '');
        let attorneyId = @json($attorney->id ?? '');
        let data = {
            category_slug: category,
            status: status,
            attorneyId: attorneyId
        };

        let route = "{{ route('admin.getData-for-attoernychart-count') }}";
        let csrftoken = { 'X-CSRF-TOKEN': '{{ csrf_token() }}' };

        initializeDataTableGetClientsAttorneyChartCountStatusWise(route,csrftoken, data);
    });
    
function initializeDataTableGetClientsAttorneyChartCountStatusWise(route, csrftoken, data) {
 

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

</script>

@endsection
