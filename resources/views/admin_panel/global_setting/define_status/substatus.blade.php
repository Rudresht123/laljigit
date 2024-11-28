<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.global-setting.status') }}">Main-Status</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub-Status</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-10 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-sm-12">
                <b><i class="fa fa-list"></i> Sub-Category</b>
                <a href="{{route('admin.global-setting.sub-status')}}" class="btn btn-primary float-end">Sub-Status</a>
            
            </div></div>
            </div>

            <div class="panel-body p-1 p-md-3 pd-b-0">
                <form method="post" id="addsubcategory">
                    @csrf
                    <fieldset class="form-fieldset">
                        <legend>Sub-Status</legend>

                        <!-- Flexbox for lg and md screens, stack on small screens -->
                        <div class="row d-flex flex-lg-row flex-md-row flex-sm-column">

                            <div class="col-lg-4 col-md-3 mb-3">
                                <label for="" class="form-label">Main Status</label>
                                <select name="main_status_id" required class="form-select select2" id="">
                                    <option value="">**Select Main Status</option>
                                    @foreach ($mainStatus as $mStatus)
                                        <option value="{{ $mStatus->id ? $mStatus->id : '' }}">
                                            {{ $mStatus->status_name ? $mStatus->status_name : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-8 col-md-9 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Status-name<span class="text-danger">*</span></label>
                                    <textarea class="form-control" required  name="substatus_name" id="substatus_name" cols="1" rows="1"
                                        placeholder="Please Enter Sub Status Remark..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Status-Slug<span class="text-danger">*</span></label>
                                    <input type="text" name="slug" class="form-control" placeholder="Sub Status Slug" required>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Status-Remark</label>
                                    <textarea class="form-control"  name="substatus_remarks" id="substatus_remarks" cols="1" rows="1"
                                        placeholder="Please Enter Sub Status Remark..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Is-Active</label>
                                   <select name="status" class="form-select" id="status">
                                    <option value="yes">Active</option>
                                    <option value="no">De-Active</option>
                                   </select>
                                </div>
                                <div class="form-group text-end ">
                                    <input type="Reset" class=" btn btn-danger mx-2 ">
                                    <input type="submit" class=" btn btn-primary">

                                </div>

                            </div>

                        </div>
                    </fieldset>
                </form>
            </div>

        </div>
    </div>

    {{-- java script code start --}}
    <script type="text/javascript">
        $(document).ready(function() {
            $('#addsubcategory').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();
                let route = "{{ route('admin.global-setting.store-sub-status') }}";
                
                // Show loader and overlay
                $('#ld').show();
                $('#overlay').show();
    
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: route,
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        // Hide loader and overlay
                        $('#ld').hide();
                        $('#overlay').hide();
    
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Reset specific fields using their IDs, but keep 'main_category' select unchanged
                                    $('#substatus_name').val(''); // Clear subcategory name field
                                    $('#substatus_remarks').val(''); // Clear subcategory remark field
                                }
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
                        // Hide loader and overlay
                        $('#ld').hide();
                        $('#overlay').hide();
    
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
                            console.error(xhr); // Log the error for debugging
                        }
                    }
                });
            });
        });
    </script>
    
    
    {{-- java script code end --}}
    {{-- main section end here --}}
@endsection
{{-- main section end here --}}
