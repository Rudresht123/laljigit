<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item " aria-current="page">Global Setting</li>
            <li class="breadcrumb-item " aria-current="page"><a
                    href="{{ route('admin.global-setting.status') }}">Main-Status</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub-Status</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b><i class="fa fa-list"></i> Sub-Category</b>
                {{-- <a href="{{route('admin/global-setting.main-category')}}" class="btn btn-primary">Main-Category</a> --}}
            </div>

            <div class="panel-body p-1 p-md-3 pd-b-0"> <!-- Flexbox for lg and md screens, stack on small screens -->
                <div class="row d-flex flex-lg-row flex-md-row flex-sm-column">
                    <div class="col-lg-6 mx-auto col-md-3 mb-3">
                        <label for="" class="form-label">Main Status</label>
                        <select name="main_category_id" id="main_category_id" class="form-select select2" id="">
                            <option value="">**Select Main Status</option>
                            @foreach ($mainStatus as $mstatus)
                                <option value="{{ $mstatus->id ? $mstatus->id : '' }}">
                                    {{ $mstatus->status_name ? $mstatus->status_name : '' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 mb-3">
                        <label for="" class="form-label">Search Here</label>
                        <input type="text" class="form-control" placeholder="Search Input..."
                            onkeyup="filterTableData('subCategoryTable',this.value)">
                    </div>
                </div>

            </div>


            {{-- table section start here --}}
            <div class="row">
                <div class="col-lg-12">
                    <table id="subCategoryTable" class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th class="border fw-bold">Sr.No</th>
                                <th class="border fw-bold">Sub-Status Name</th>
                                <th class="border fw-bold">Remark Status</th>
                                <th class="border fw-bold">Status</th>
                                <th class="border fw-bold">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            {{-- table section start here --}}
        </div>

        {{-- java script code start --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('#main_category_id').change(function(e) {
                    e.preventDefault(); // Corrected method
                    let mainCategoryId = $(this).val();

                    console.log("main Status Id",mainCategoryId);
                    let route = "{{ route('admin.global-setting.show-sub-status', ':id') }}".replace(':id',
                        mainCategoryId);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: route,
                        type: 'GET',
                        success: function(response) {
                            let tablebody = $('#subCategoryTable tbody'); // Corrected the selector
                            tablebody.empty(); // Clear existing rows
                            let counter = 0;
                            // Check if data exists
                            if (response.data && response.data.length > 0) {
                                response.data.forEach(substatus => {
                                    let statusText = substatus.status === 'yes' ?
                                        '<span class="bg-success text-light rounded px-1">Active</span>' :
                                        '<span class="bg-danger text-light rounded px-1">De-Active</span>';
                                    let row = `
                                        <tr class="text-center">
                                            <td class="border">${++counter}</td>
                                            <td class="border">${substatus.substatus_name}</td>
                                            <td class="border">${substatus.substatus_remarks}</td>
                                            <td class="border">${statusText}</td>
                                            <td class="d-flex border justify-content-center">
                                              <a href="{{ route('admin.global-setting.edit-sub-status', '') }}/${substatus.id}" class="editButton text-primary p-1 rounded fw-bold" data-id="${substatus.id}">
    <i class="far fa-edit"></i>
</a>

                                                <a href="" class="deleteButton text-danger p-1 rounded fw-bold" data-id="${substatus.id}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    `;
                                    tablebody.append(
                                        row); // Append each row to the table body
                                });
                            } else {
                                // No data available row
                                let noDataRow = `
                                    <tr>
                                        <td colspan="5" class="text-center">No Data Available</td>
                                    </tr>
                                `;
                                tablebody.append(noDataRow);
                            }
                        },
                        error: function(xhr) {
                            console.error(xhr); // Optional: Log the error for debugging
                            // alert('An error occurred while fetching subcategories.'); // Inform user about error
                        }
                    });
                });

            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                // Use event delegation to handle clicks on dynamically created delete buttons
                $('#subCategoryTable').on('click', '.deleteButton', function(e) { // Corrected this line
                    e.preventDefault(); // Prevent the default action

                    // Confirmation alert before deletion
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
                            $('#ld').show(); // Show loading indicator
                            $('#overlay').show(); // Show overlay

                            let subCategoryId = $(this).data('id'); // Get subcategory ID
                            // Prepare the route for deletion
                            let route = "{{ route('admin.global-setting.delete.sub-category', ':id') }}"
                                .replace(':id', subCategoryId);

                            // AJAX request to delete the subcategory
                            $.ajax({
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // CSRF token for security
                                },
                                url: route,
                                type: 'DELETE',
                                success: function(response) {
                                    $('#ld').hide(); // Hide loading indicator
                                    $('#overlay').hide(); // Hide overlay

                                    if (response.success) {
                                        // Show success message and refresh if confirmed
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Success',
                                            text: response.success,
                                        }).then(($result) => {
                                            if ($result.isConfirmed) {
                                                window.location
                                            .reload(); // Reload the page
                                            }
                                        });
                                    } else {
                                        // Show error message if deletion failed
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Error',
                                            text: response.error,
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    $('#ld').hide(); // Hide loading indicator
                                    $('#overlay').hide(); // Hide overlay

                                    // Log the error details for debugging
                                    console.log("Error Status: " + status);
                                    console.log("Error Thrown: " + error);
                                    console.log("Response Text: " + xhr.responseText);

                                    // Show generic error message
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


        {{-- java script code end --}}
        {{-- main section end here --}}
    @endsection
    {{-- main section end here --}}
