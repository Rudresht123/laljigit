<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Attorneys</li>
        </ol>
    </nav>


    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading"><b><i class="fa fa-list"></i> Attorneys</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <a href="{{ route('admin.global-setting.create.attorneys') }}"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="fa fa-plus"></i> Add Attorneys
                    </a>

                    <button type="button" class="btn btn-block btn-outline-dark mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-times"></i> Dashboard</button>
                    <button type="button" id="exportButton" onclick="exportTableToExcel('AttorneysTable')" class="btn btn-block btn-outline-success mg-t-10 btn-sm rounded-pill px-4"><i
                            class="fa fa-print" aria-hidden="true"></i> Excel Export</button>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Search Input..." onkeyup="filterTableData('AttorneysTable',this.value)">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="AttorneysTable" class="table w-100 table-hover fs-10">
                            <thead class="bg-light text-center fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Attorney Name</th>
                                    <th class="fw-bold">Email</th>
                                    <th class="fw-bold">Phone Number</th>
                                    <th class="fw-bold">Specialization</th>
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


    {{-- delete script start here --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('.deletebutton').on('click', function(e) {
                e.preventDefault();
                let atorneyId = $(this).data('id');
                let route = "{{ route('admin.global-setting.delete.attorneys', ':id') }}".replace(':id',
                    atorneyId);

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
     <script type="text/javascript">
        $(document).ready(function() {
            let route = "{{ route('admin.common.datatable') }}";
            let csrf = "{{ csrf_token() }}";

            let columnsDefinition = [{
                    data: 'attorneys_name',
                    name: 'attorneys_name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'specialization',
                    name: 'specialization'
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
                route: route, 
                csrf: csrf,
                columnsDefinition: columnsDefinition,
                tableId: 'AttorneysTable',
                dbtable: 'attorneys'
            });

            // block and unbloc code here

            $('#consultantTable').on('click', '.blockButton', function(e) {
                e.preventDefault();
                let itemId = $(this).data('id');
                let csrf = "{{ csrf_token() }}";
                let route = "{{ route('admin.block-data') }}";
                let dbtable = "consultant";
                let columnname = "status";
                showConfirmAlert(route, csrf, dbtable, columnname, itemId);
            });
            $('#consultantTable').on('click', '.blockButton', function(e) {
                e.preventDefault();
                let itemId = $(this).data('id');
                let csrf = "{{ csrf_token() }}";
                let route = "{{ route('admin.block-data') }}";
                let dbtable = "consultant";
                let columnname = "status";
                showConfirmAlert(route, csrf, dbtable, columnname, itemId);
            });
        });
    </script>

    {{-- delete script start here --}}
@endsection
