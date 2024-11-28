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

                        <li class="breadcrumb-item active" aria-current="page">Email Templates</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading "><b><i class="fa fa-list"></i> Email Template List</b></div>
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-2 mb-3">
                    <a href="{{ route('admin.systemsetting.create-template') }}" type="button"
                        class="btn btn-block mg-t-10 btn-outline-primary btn-sm rounded-pill px-4">
                        <i class="fa fa-plus"></i> Add Template
                    </a>
                    <a href="{{ route('admin.systemsetting.update-email-config') }}" type="button"
                        class="btn btn-block mg-t-10 btn-outline-success btn-sm rounded-pill px-4">
                        <i class="fa fa-cog"></i> Email Setting
                    </a>
                </div>

                <div class="col-lg-10 vhr">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-4">
                            <input type="text" class="form-control" placeholder="Search Input..."
                                onkeyup="filterTableData('sessionTable',this.value)">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="sessionTable" class="table table-bordered   fs-13 text-center">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold">Sr. No.</th>
                                    <th class="fw-bold">Template name</th>
                                    <th class="fw-bold">Template Slug</th>
                                    <th class="fw-bold">Template Subject</th>
                                    <th class="fw-bold">From Name</th>
                                    <th class="fw-bold">From Email</th>
                                    <th class="fw-bold">CC Email</th>
                                    <th class="fw-bold">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $counter = 0;
                                @endphp
                                @foreach ($templates as $template)
                                    <tr class="text-dark">
                                        <td class="border">{{ ++$counter }}</td>
                                        <td class="border">{{ $template->name ?? '' }}</td>
                                        <td class="border">{{ $template->slug ?? '' }}</td>
                                        <td class="border ">
                                            {{ $template->subject ?? ''}}
                                        </td>
                                        <td class="border ">
                                            {{ $template->from_name ?? '' }}
                                        </td>
                                        <td class="border ">
                                            {{ $template->from_email ?? '' }}
                                        </td>
                                        <td class="border ">
                                            {{ $template->cc_email ?? ''}}
                                        </td>
                                        <td class="d-flex justify-content-center">
                                            <a href="{{route('admin.systemsetting.edit-template',$template->id)}}" class="editButton" title="Edit"><i class="far fa-edit"></i></a>
                                            <a href="" data-id="{{$template->id}}" title="Delete" class="buttonDelete text-danger p-1 rounded fw-bold "><i class="fa fa-trash"></i></a>
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('.buttonDelete').on('click', function(e) {
                e.preventDefault();
    
                var dataId = $(this).data('id'); // Correctly retrieve the data-id attribute
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let route = "{{ route('admin.systemsetting.delete-template', ':id') }}".replace(':id', dataId); // Correctly replace the placeholder
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Correctly set the CSRF token header
                            },
                            url: route,
                            type: 'DELETE',
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.success
                                    }).then(() => {
                                        // Optionally, you can reload or redirect the page after success
                                        location.reload(); // Reload the page
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
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'An error occurred while processing your request.'
                                });
                            }
                        });
                    }
                });
    
                // Removed the alert(dataId); as it's likely not needed for debugging
            });
        });
    </script>
@endsection
