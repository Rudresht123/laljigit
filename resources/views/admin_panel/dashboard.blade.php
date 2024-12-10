{{-- extending master layout here --}}
@extends('admin_panel.comman.masterLayout')
{{-- extending master layout here --}}


{{-- main content section start here --}}
@section('main-content')
    <div class="container-fluid pd-x-0 pd-lg-x-10 pd-xl-x-0">
        <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Attorney Dashboard</li>
                    </ol>
                </nav>
                <h4 class="mg-b-0 tx-spacing--1">Welcome to Dashboard</h4>
            </div>
            <div class="d-none d-md-flex col-sm-8  align-items-center justify-content-end">
                <form action="{{ route('get.searchClent-detail-dashboard') }}" method="POST" class="d-flex w-100">
                    @csrf
                    <div class="form-group mb-0 w-75">
                        <div class="search-form">
                           
                            <input id="search-box" name="client_id" type="text" class="form-control" placeholder="Search here...">

                            <button class="btn" type="submit"><i data-feather="search"></i></button>
                          </div>
                    </div>
                </form>
                <a href="{{ route('admin.reports.clients-reports') }}"
                    class="btn btn-sm pd-x-15 btn-primary btn-uppercase w-25 ms-2">
                    <i data-feather="file" class="wd-10 me-1"></i> Generate Report
                </a>
            </div>


        </div>

        <div class="row row-xs">
            @foreach ($attoernyes as $attoerny)
                <div class="col-sm-6 col-lg-4 mb-2">
                    <a href="{{ route('admin.attorney.show-category', $attoerny->id) }}">
                        <div class="atorney-card card card-body">
                            <div class="d-flex align-items-center">
                                @if ($attoerny->gender === 'Male')
                                    <img src="{{ asset('assets/img/icons/atorney.png') }}"
                                        class="border rounded-50 p-1 me-2" style="height:50px;width:50px;" alt="not found">
                                @else
                                    <img src="{{ asset('assets/img/icons/f_attorney.png') }}"
                                        class="border rounded-50 p-1 me-2" style="height:50px;width:50px;" alt="not found">
                                @endif
                                <span
                                    class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 fw-bold fs-6 text-dark">{{ ucwords($attoerny->attorneys_name) }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div><!-- container-fluid -->

    </div>

    {{-- report section --}}

    <div class="row d-flex mt-3" style="box-sizing:border-box;">
        <div class="col-lg-6 mb-3 mb-md-0">
            <div class="custom-card">
                <div class="panel  m-0 p-0  panel-default">
                    <div class="panel-heading border-bottom mb-2">
                        <h6 class="tx-14 m-0 p-0"><b class="d-flex"><i class="far fa-address-book me-1"></i> Attorneys Wise
                                Clients Summary</b></h6>
                    </div>
                    <div class="panel-body  pt-0">
                        <div class="row m-0 p-0">
                            <div id="class-section-attendance-absent-summary" class="col-lg-12 m-0 p-0"
                                style="max-height: 300px; min-height: 300px; overflow-y: scroll;">
                                <!-- class-section-attendance-absent-summary -->
                                <div class="row m-0 p-0">

                                    @foreach ($attoernyes as $attoerny)
                                        @php
                                            $counter = 0;
                                        @endphp
                                        <div class="col-lg-12 p-1 cursor-pointer bg-light accordion-btn mt-1"
                                            onclick="toggleDetails(this)">
                                            <div class="row d-felx">
                                                <div class="col-9 pl-4">
                                                    <b
                                                        class="fs-10">{{ $attoerny->attorneys_name ? $attoerny->attorneys_name : '' }}</b>
                                                </div>
                                                <div class="col-3 text-center">
                                                    <!-- Assuming 'students' is the relationship -->
                                                </div>
                                            </div>
                                            <!-- Ensure proper condition -->
                                            <div class="row m-0 p-0 mt-2 absent-data" style="display: none;">
                                                <input type="hidden" class="btn-action" value="close">
                                                <div class="col-lg-12 m-0 p-0">
                                                    <table cellspacing="0" cellpadding="0"
                                                        class="table tx-11 mt-1 m-0 p-0 bg-white table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-bold"><b>Application No.</b></th>
                                                                <th class="text-bold"><b>File Name</b></th>
                                                                <th class="text-bold"><b>Trademark Name</b></th>
                                                                <th class="text-bold"><b>Phone No.</b></th>
                                                                <th class="text-bold"><b>Status</b></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                            @foreach ($groupedData as $groupdata)
                                                                @if ($attoerny->id === $groupdata->attorney_id)
                                                                    @php
                                                                        ++$counter;
                                                                    @endphp
                                                                    <tr class="fs-10">
                                                                        <td>
                                                                            <a
                                                                                href="{{ route('admin.attorney.clientDetails', ['category_slug' => $groupdata->mainCategory->category_slug, 'id' => $groupdata->id]) }}">
                                                                                {{ $groupdata->application_no ?? '' }}
                                                                            </a>
                                                                        </td>
                                                                        <!-- Placeholder for profile image -->
                                                                        <td>{{ $groupdata->file_name ?? '' }}</td>
                                                                        <td style="word-wrap:nowrap;">
                                                                            {{ $groupdata->trademark_name ?? '' }}</td>
                                                                        <td>{{ $groupdata->phone_no ?? '' }}</td>
                                                                        <td>{{ $groupdata->statusMain->status_name ?? '' }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        </tbody>


                                                    </table>

                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 d-flex justify-content-end">
                                                    <span class="badge text-bg-danger"
                                                        style="font-size: 8px;position: relative;end:0;top:-10px;">{{ $counter }}</span>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="custom-card">
                <div class="panel m-0 p-0  panel-default">
                    <div class="panel-heading  border-bottom mb-2">
                        <h6 class="tx-14 m-0 p-0"><b class="d-flex"><i class="far fa-address-book me-1"></i> Upcoming
                                Last Date</b></h6>
                    </div>
                    <div class="panel-body  pt-0">
                        <div class="row m-0 p-0" >
                            <div id="class-section-attendance-absent-summary" class="col-lg-12 m-0 p-0"
                                style="max-height: 300px; min-height: 300px; overflow-y: scroll;">
                                <!-- class-section-attendance-absent-summary -->
                                <div class="row m-0 p-0">
                                    @php
                                        $elementKey="";
                                    @endphp
                                    @foreach ($upcommingdates as $key=>$upcommingdate)
                                    @php
                                    $counter=0;
                                    $elementKey=$key;
                                    @endphp
                                    <div class="col-lg-12 p-1 cursor-pointer bg-light accordion-btn mt-1"
                                        onclick="toggleDetails(this)">
                                        <div class="row d-felx">
                                            <div class="col-9 pl-4">
                                                <b class="fs-10">{{ $key ?? '' }}</b>
                                            </div>
                                            <div class="col-3 text-center">
                                                <!-- Assuming 'students' is the relationship -->
                                            </div>
                                        </div>
                                        <!-- Ensure proper condition -->
                                        <div class="row m-0 p-0 mt-2 absent-data" style="display: none;">
                                            <input type="hidden" class="btn-action" value="close">
                                            <div class="col-lg-12 m-0 p-0">
                                                <table cellspacing="0" cellpadding="0"
                                                    class="table tx-11 mt-1 m-0 p-0 bg-white table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-bold"><b>Application No.</b></th>
                                                            <th class="text-bold"><b>File Name</b></th>
                                                            <th class="text-bold"><b>Trademark Name</b></th>
                                                            <th class="text-bold"><b>Phone No.</b></th>
                                                            <th class="text-bold"><b>Valid Upto</b></th>
                                                            <th class="text-bold"><b>Status</b></th>
                                                            <th class="text-bold"><b>Opposition Hearing Date</b></th>
                                                            <th class="text-bold"><b>Hearing Date</b></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($upcommingdate as $upcommingdate)
                                                        @if ($key === $elementKey)
                                                        @php
                                                        ++$counter;
                                                        @endphp
                                                        <tr class="fs-10">
                                                            <td>
                                                                <a href="{{ route('admin.attorney.clientDetails', ['category_slug' => $groupdata->mainCategory->category_slug, 'id' => $groupdata->id]) }}">
                                                                    {{ $upcommingdate->application_no  ?? ''}}
                                                                </a>
                                                            </td>
                                                            <!-- Placeholder for profile image -->
                                                            <td>{{ $upcommingdate->file_name ?? '' }}</td>
                                                            <td style="word-wrap:nowrap;">{{ $upcommingdate->trademark_name  ?? ''}}</td>
                                                            <td>{{ $upcommingdate->phone_no ?? '' }}</td>
                                                            <td>{{ $upcommingdate->statusMain->status_name ?? '' }}</td>
                                                            <td>{{ $upcommingdate->mainCategory->category_name ?? '' }}</td>
                                                            <td>{{ $upcommingdate->valid_up_to ?? '' }}</td>
                                                            <td>{{ $upcommingdate->opposition_hearing_date ?? '' }}</td>
                                                            <td>{{ $upcommingdate->hearing_date ?? '' }}</td>
                                                        </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>


                                                </table>

                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 d-flex justify-content-end">
                                                <span class="badge text-bg-danger" style="font-size: 8px;position: relative;end:0;top:-10px;">{{$counter}}</span>
                                            </div>
                                        </div>

                                    </div>

                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- report section end here --}}



    {{-- /chart section start here --}}
    <div class="row mt-3 d-flex" style="box-sizing:border-box;">
        <!-- First Column -->
        <div class="col-sm-6 mb-3"> <!-- Added mb-3 to give margin bottom -->
            <div class="custom-card">
                <div class="panel m-0 p-0  panel-default">
                    <div class="panel-heading border-bottom mb-2">
                        <h6 class="tx-14 m-0 p-0">
                            <b class="d-flex">
                                <i class="far fa-address-book me-1"></i> Category Vise Clients Summary
                            </b>
                        </h6>
                    </div>
                    <div class="panel-body pt-0" style="overflow-x: auto; white-space: nowrap;width:100%;">
                        <canvas id="chartBar2" class="chart_canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Column -->
        <div class="col-sm-6 mb-3">
            <div class="custom-card"><!-- Added mb-3 to give margin bottom -->
                <div class="panel m-0 p-0  panel-default">
                    <div class="panel-heading border-bottom mb-2">
                        <h6 class="tx-14 m-0 p-0">
                            <b class="d-flex">
                                <i class="far fa-address-book me-1"></i> Status Vise Clients Summary
                            </b>
                        </h6>
                    </div>
                    <div class="panel-body pt-0">
                        <canvas id="chartBar1" class="chart_canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- chart section end here --}}

    <!-- code for the chart start here -->

    {{-- modal code for update status --}}
    <!-- Modal -->
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
                            <legend id="clientFileName">Update Status</legend>
                            <div class="form-group">
                                <label for="" class="form-label">ClientId</label>
                                <input type="text" readonly name="clientId" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="" class="form-label">Main Category Slug</label>
                                <input type="text" readonly name="main_category_slug" class="form-control">
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






    {{-- edit status modal open code here with data --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#renuwalTable').on('click', '.editStatus', function(e) {
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
                            $('input[name="main_category_slug"]').val(category_slug);

                            $('select[name="updateStatusMainCategory"]').val(response
                                .clientDetails.category_id);
                            if (response.clientDetails.sub_category) {
                                $('select[name="clientstatus"]').val(response.clientDetails
                                    .sub_category);
                            }
                            $('#clientFileName').text(response.clientDetails.file_name)
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


    <!-- chart javascript start here -->
    <script type="text/javascript">
        $(document).ready(function() {
            let route = "{{ route('admin.chart.CategoryWiseUserCount') }}";
            horizontalchartBarFunction(route);
        });
        $(document).ready(function() {
            let route = "{{ route('admin.chart.statusWiseClientChart') }}";
            verticalBarChartFunction(route);
        });
    </script>

    <!-- chart javascript start here -->


    {{-- script for the get search client for the dashbord --}}
    <script type="text/javascript">
        $(document).ready(function () {
            let route = "{{ route('get.searchClent') }}";
            let csrfToken = "{{ csrf_token() }}";
    
            // Call the function to initialize Typeahead
            searchClientWithType(route, csrfToken);
        });
    </script>
    
    {{-- script for the get search client for the dashbord --}}

    <script>
        function toggleDetails(element) {
            const details = element.querySelectorAll('.absent-data');
            details.forEach(detail => {
                detail.style.display = detail.style.display === 'none' ? 'block' : 'none';
            });
        }
    </script>

    <style>
        .accordion-btn {
            border: 1px solid silver;
        }

        .table-small tr th {
            border: 0px !important;
        }

        .table-small tr td,
        .table-small tr th {
            padding-left: 3px !important;
        }
    </style>
    <!-- content -->
@endsection
{{-- main content section start here --}}
