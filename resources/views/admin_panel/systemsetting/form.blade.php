<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->

@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">ADD Form Field</li>
        </ol>
    </nav>

    {{-- form-section start here --}}
    {{-- table section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <fieldset class="form-fieldset p-0 p-md-3">
                        <legend>Basic Field Information</legend>
                        <form id="addFieldForm" method="POST" >
                            @csrf
                            <div class="row p-4">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="category_id" class="form-label">Category<span class="text-danger">*</span></label>
                                        <select name="category_id" required class="form-select" id="category_id">
                                            <option value="">**Please Select Field Category</option>
                                            @foreach ($category as $cat)
                                                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="field_name" class="form-label">Field Name<span class="text-danger">*</span></label>
                                        <input type="text" required class="form-control" name="field_name" placeholder="Field Name..">
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="field_label" class="form-label">Field Label<span class="text-danger">*</span></label>
                                        <input type="text" required class="form-control" name="field_label" placeholder="Field Label..">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="field_type" class="form-label">Field Type<span class="text-danger">*</span></label>
                                        <select required name="field_type" class="form-select" id="field_type">
                                            <option value="">**Please Select Field Type</option>
                                            <option value="text">Text</option>
                                            <option value="date">Date</option>
                                            <option value="textarea">Textarea</option>
                                            <option value="email">Email</option>
                                            <option value="number">Number</option>
                                            <option value="select">Select</option>
                                            <option value="radio">Radio</option>
                                            <option value="checkbox">Checkbox</option>
                                            <option value="file">File</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="field_order" class="form-label">Field Order<span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="field_order" id="field_order" value="0" min="0">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="field_options" class="form-label">Field Options</label>
                                        <textarea name="field_options" class="form-control" id="field_options" placeholder='{"option1": "Option 1", "option2": "Option 2"}'></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 mt-2">
                                    <div class="form-group">
                                        <label for="is_required" class="form-label">Is Required</label>
                                        <input type="checkbox" name="is_required" value="1">
                                    </div>
                                </div>

                                <div class="row p-0 m-0">
                                    <div class="col-sm-12 d-flex justify-content-end">
                                        <input type="reset" class="btn btn-danger me-2">
                                        <input type="submit" class="btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    {{-- form-section end here --}}

    <script type="text/javascript">
        $(document).ready(function(){
            $('#addFieldForm').on('submit', function(e){
                e.preventDefault();
                // You can handle form validation or additional logic here
                $('#ld').show();
                $('#overlay').show();
                let route = "{{ route('admin.systemsetting.create-formfield') }}";
                let formData = $(this).serialize();

                $.ajax({
                    headrs: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: route,
                    type: "POST",
                    data: formData,
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
                                $('#addFieldForm')[0].reset(); // Reset form fields
                            }
                        });
                    },
                    error: function(xhr) {
                        $('#ld').hide(); // Hide loader on error
                        $('#overlay').hide(); // Hide overlay on error
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
                            console.error(xhr); // Optional: Log the error for debugging
                        }
                    }
                });
            });
            });
        
    </script>
    {{-- main section end here --}}
@endsection
