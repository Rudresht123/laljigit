<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('admin.global-setting.main-category') }}">Main-Category</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub-Category</li>
        </ol>
    </nav>

    <div class="custom-card col-lg-10 mx-auto">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b><i class="fa fa-list"></i> Sub-Category</b>
                {{-- <a href="{{route('admin/global-setting.main-category')}}" class="btn btn-primary">Main-Category</a> --}}
            </div>

            <div class="panel-body p-1 p-md-3 pd-b-0">
                <form method="post" id="addsubcategory">
                    @csrf
                    <fieldset class="form-fieldset">
                        <legend>Sub-Category</legend>

                        <!-- Flexbox for lg and md screens, stack on small screens -->
                        <div class="row d-flex flex-lg-row flex-md-row flex-sm-column">

                            <div class="col-lg-4 col-md-3 mb-3">
                                <label for="" class="form-label">Main Category</label>
                                <select name="main_category_id" class="form-select" id="">
                                    <option value="">**Select Main Category</option>
                                    @foreach ($mainCategory as $mcat)
                                        <option value="{{ $mcat->id ? $mcat->id : '' }}">
                                            {{ $mcat->category_name ? $mcat->category_name : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-8 col-md-9 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="subcategoryName" required class="form-control" name="subcategory"
                                        placeholder="Enter Sub Category Name...">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Remark</label>
                                    <textarea class="form-control"  name="subcategory_remark" id="subcatregoryRemark" cols="5" rows="5"
                                        placeholder="Please Enter Sub Category Remark..."></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Remark</label>
                                   <select name="status" class="form-select" id="">
                                    <option value="yes">Active</option>
                                    <option value="no">De-Active</option>
                                   </select>
                                </div>
                                <div class="form-group text-end py-1 ">
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
                let route = "{{ route('admin.global-setting.create.sub-category') }}";
                
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
                                    $('#subcategoryName').val(''); // Clear subcategory name field
                                    $('#subcatregoryRemark').val(''); // Clear subcategory remark field
                                    $('#status').val(''); // Clear status field
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
