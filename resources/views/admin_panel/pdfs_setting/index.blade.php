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
            <div class="panel-heading"><b><i class="fa fa-list"></i> PDF Template Setting</b>
            </div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <a href="{{route('admin.global-setting.create-pdf-template')}}"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Add Template
                </a>

                    <button type="button" class="btn btn-block btn-outline-dark mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-times"></i> Dashboard</button>
                    <button type="button" class="btn btn-block btn-outline-success mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-print" aria-hidden="true"></i> Print PDF</button>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Search Input..." onkeyup="filterTableData('sessionTable',this.value)">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="sessionTable" class="table table-bordered   fs-13 text-center">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Sr. No.</th>
                                    <th class="fw-bold">Template Name</th>
                                    <th class="fw-bold">Template Slug</th>
                                    <th class="fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 0;
                                @endphp
                              @foreach ($pdfs as $pdf)
                                  <tr>
                                    <td>{{++$counter}}</td>
                                    <td>{{$pdf->template_name ? $pdf->template_name :''}}</td>
                                    <td>{{$pdf->template_slug ? $pdf->template_slug :''}}</td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{route('admin.global-setting.edit-pdf-template',$pdf->id)}}"  
                                            class="text-primary p-1 rounded fw-bold "><i class="far fa-edit"></i></a>
                                        <a href="" data-id="{{ $pdf->id }}"
                                            class="deletebutton text-danger p-1 rounded fw-bold "><i
                                                class="fa fa-trash"></i></a>
                                    </td>
                                  </tr>
                              @endforeach
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
    {{-- <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div> --}}
    {{-- end here add modal --}}
    <script class="text/javascript">
        $(document).ready(function() {
            $('.deletebutton').on('click', function(e) {
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
                        let templateId = $(this).data('id');
                        route = "{{ route('admin.global-setting.delete-pdf-template', ':id') }}"
                            .replace(':id', templateId);
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
@endsection
