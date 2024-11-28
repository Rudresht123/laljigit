<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
{{-- main section start here --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
        <li class="breadcrumb-item active" aria-current="page">Create Attorneys</li>
    </ol>
</nav>


{{-- form section start here --}}
<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card">
            <div class="card-header">
                <a href="{{route('admin.global-setting.attorneys')}}" class="btn btn-outline-primary float-end">All Attorneys</a>
            </div>
            <div class="card-body">
                <fieldset class="form-fieldset">
                    <legend>Attorneys Information</legend>
                    <form id="addAttorneys" method="POST" enctype="multipart/form-data">
                        @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Attorney name<span class="text-danger">*</span></label>
                            <input type="text" required name="attorneys_name" class="form-control" placeholder="Attorney Name..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Phone Number<span class="text-danger">*</span></label>
                            <input type="phone_number" required  maxlength="10" name="phone_number" class="form-control" placeholder="Attorney Phone Number..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" name="email" required class="form-control" placeholder="Attorney Email..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Specialization</label>
                            <input type="text" name="specialization" class="form-control" placeholder="Attorney Specialization..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">License Number</label>
                            <input type="text" name="license_number" class="form-control" placeholder="Attorney License Number..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Bar Admission Date</label>
                            <input type="date" name="bar_admission_date" class="form-control" placeholder="Attorney Bar Admission Date..">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Gender<span class="text-danger">*</span></label>
                            <select name="gender" class="form-select" id="">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="" class="form-label">Profile Picture</label>
                            <input type="file" name="profile_picture" class="form-control" placeholder="Attorney Name..">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="" class="form-label">Attorney Bio</label>
                            <textarea name="bio" id="" cols="1" placeholder="Attorney Bio Data" class="form-control" rows="1"></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 d-flex justify-content-end">
                        <input type="reset" value="Reset" class="btn btn-outline-secondary me-2">
                        <input type="submit" value="Submit" class="btn btn-outline-primary">
                    </div>
                </div>
                    </form>
                </fieldset>
            </div>
        </div>
    </div>
</div>
{{-- form section start here --}}


{{-- add js start here --}}
<script type="text/javascript">
$(document).ready(function() {
    $('#addAttorneys').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        // Show loader and overlay
        $('#ld').show(); 
        $('#overlay').show(); 

        let formData = new FormData(this);
        let route = "{{ route('admin.global-setting.create.attorneys') }}";

        // Disable form or submit button to prevent multiple submissions
        $('#submit-button').prop('disabled', true);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: route,
            type: 'POST',
            data: formData,
            processData: false, // Prevent jQuery from processing the data
            contentType: false, // Prevent jQuery from setting the content type
            success: function(response) {
                $('#ld').hide(); // Hide loader
                $('#overlay').hide(); // Hide overlay

                // Check for success in response
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success
                    }).then(($result) => {
                        if ($result.isConfirmed) {
                            $('#addAttorneys')[0].reset(); // Reset the form
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
                $('#ld').hide(); // Hide loader on error
                $('#overlay').hide(); // Hide overlay on error

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors; // Ensure you're reading this correctly
                    let errorMessages = '';
                    for (const field in errors) {
                        if (errors.hasOwnProperty(field)) {
                            errorMessages += errors[field].join('<br>') + '<br>';
                        }
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
            },
            complete: function() {
                // Re-enable the form or submit button after the request completes
                $('#submit-button').prop('disabled', false);
                $('#ld').hide(); // Hide the loader in all cases
                $('#overlay').hide(); // Hide the overlay in all cases
            }
        });
    });
});



</script>
{{-- add js end here --}}
{{-- section end here --}}
@endsection