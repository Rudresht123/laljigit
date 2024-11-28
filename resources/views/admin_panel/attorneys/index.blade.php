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
                        <table id="AttorneysTable" class="table table-bordered fs-13 text-center">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Sr. No.</th>
                                    <th class="fw-bold">Profile Pic.</th>
                                    <th class="fw-bold">Attorney Name</th>
                                    <th class="fw-bold">Email</th>
                                    <th class="fw-bold">Phone Number</th>
                                    <th class="fw-bold">Specialization</th>
                                    <th class="fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 0;
                                @endphp
                                @foreach ($attroneys as $attorney)
                                    <tr class="justify-content-center align-items-center">
                                        <td>{{ ++$counter }}</td>
                                        <td class="text-center  d-flex justify-content-center align-items-center">
                                            <div class="avatar avatar-sm ">
                                                <img src="{{ asset('storage/uploads/attorneys_images/' . $attorney->profile_picture) }}"
                                                    class="rounded-circle" alt="">
                                            </div>
                                        </td>
                                        <td>{{ $attorney->attorneys_name ? $attorney->attorneys_name : '' }}</td>
                                        <td>{{ $attorney->email ? $attorney->email : '' }}</td>
                                        <td>{{ $attorney->phone_number ? $attorney->phone_number : '' }}</td>
                                        <td>{{ $attorney->specialization ? $attorney->specialization : '' }}</td>
                                        <td class="d-flex justify-content-center">
                                            <a href="" title="Show Attorney " class="me-2 text-success"><i
                                                    class="far fa-user"></i></a>
                                            <a href="{{ route('admin.global-setting.edit.attorneys', $attorney->id) }}"
                                                title="Edit Attorney" class="editButton" data-id="{{ $attorney->id }}"
                                                class="text-primary p-1 rounded fw-bold "><i class="far fa-edit"></i></a>
                                            <a href="" data-id="{{ $attorney->id }}" title="Delete Attorney"
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

    {{-- delete script start here --}}
@endsection
