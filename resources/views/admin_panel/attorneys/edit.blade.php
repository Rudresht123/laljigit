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

{{-- message section --}}
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('success') }}'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}'
    });
</script>
@endif
@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validation Error',
        html: '<ul style="list-style-type:none;">' +
            @foreach ($errors->all() as $error)
                '<li>{{ $error }}</li>' +
            @endforeach
            '</ul>',
        showConfirmButton: true
    });
</script>
@endif
{{-- message section --}}


    {{-- form section start here --}}
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.global-setting.attorneys') }}" class="btn btn-outline-primary float-end">All
                        Attorneys</a>
                </div>
                <div class="card-body">
                    <fieldset class="form-fieldset">
                        <legend>Attorneys Information</legend>
                        <form action="{{route('admin.global-setting.edit.attorneys',$attroney->id)}}" id="editAttorneys" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="attorney_id" value="{{ $attroney->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Attorney name<span
                                                class="text-danger">*</span></label>
                                        <input type="text"
                                            value="{{ $attroney->attorneys_name ? $attroney->attorneys_name : '' }}"
                                            required name="attorneys_name" class="form-control"
                                            placeholder="Attorney Name..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Phone Number<span
                                                class="text-danger">*</span></label>
                                        <input type="phone_number" required
                                            value="{{ $attroney->phone_number ? $attroney->phone_number : '' }}"
                                            maxlength="10" name="phone_number" class="form-control"
                                            placeholder="Attorney Phone Number..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            value="{{ $attroney->email ? $attroney->email : '' }}" required
                                            class="form-control" placeholder="Attorney Email..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Specialization<span class="text-danger">*</span></label>
                                        <input type="text"
                                            value="{{ $attroney->specialization ? $attroney->specialization : '' }}"
                                            name="specialization" class="form-control"
                                            placeholder="Attorney Specialization..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">License Number<span class="text-danger">*</span></label>
                                        <input type="text"
                                            value="{{ $attroney->license_number ? $attroney->license_number : '' }}"
                                            name="license_number" class="form-control"
                                            placeholder="Attorney License Number..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Bar Admission Date<span
                                            class="text-danger">*</span></label>
                                        <input type="date"
                                            value="{{ $attroney->bar_admission_date ? $attroney->bar_admission_date : '' }}"
                                            name="bar_admission_date" class="form-control"
                                            placeholder="Attorney Bar Admission Date..">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Gender<span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select" id="">
                                            <option value="Male" {{$attroney->gender==='Male' ? 'selected' : ''}}>Male</option>
                                            <option value="Female" {{$attroney->gender==='Female' ? 'selected' : ''}}>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="" class="form-label">Profile Picture</label>
                                        <input type="file" name="profile_picture" class="form-control"
                                            placeholder="Attorney Name..">
                                        <span class="text-danger fw-bold" style="font-size: 10px">**Select if you want to
                                            change profile_picture</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Attorney Bio<span
                                            class="text-danger">*</span></label>
                                        <textarea name="bio" id="" cols="1" placeholder="Attorney Bio Data" class="form-control"
                                            rows="1"> {{ $attroney->bio ? $attroney->bio : '' }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-3 d-flex justify-content-end">
                                    <input type="reset" value="Reset" class="btn btn-outline-secondary me-2">
                                    <input type="submit" value="Submit" id="submit-button"
                                        class="btn btn-outline-primary">
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
        // $(document).ready(function() {
        //     $('#editAttorneys').on('submit', function(e) {
        //         e.preventDefault(); // Prevent default form submission

        //         // Show loader and overlay
        //         $('#ld').show();
        //         $('#overlay').show();

        //         let formData = new FormData(this);

        //         for (let [key, value] of formData.entries()) {
        //             console.log(`${key}: ${value}`);
        //         }

        //         let attorneyId = $("input[name='attorney_id']").val();
        //         let route = "{{ route('admin.global-setting.edit.attorneys', ':id') }}".replace(':id',
        //             attorneyId);

        //         // Disable form or submit button to prevent multiple submissions
        //         $('#submit-button').prop('disabled', true);
        //         $.ajax({
        //             headers: {
        //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
        //             },
        //             url: route,
        //             type: 'PUT',
        //             data: formData,
        //             processData: false, // Required for FormData
        //             contentType: false, // Required for FormData
        //             success: function(response) {
        //                 $('#ld').hide(); // Hide loader
        //                 $('#overlay').hide(); // Hide overlay
        //                 if (response.success) {
        //                     Swal.fire({
        //                         icon: 'success',
        //                         title: 'Success',
        //                         text: response.success
        //                     });
        //                 } else {
        //                     Swal.fire({
        //                         icon: 'error',
        //                         title: 'Error',
        //                         text: response.error
        //                     });
        //                 }
        //             },
        //             error: function(xhr) {
        //                 $('#ld').hide(); // Hide loader on error
        //                 $('#overlay').hide(); // Hide overlay on error

        //                 if (xhr.status === 422) {
        //                     const errors = xhr.responseJSON
        //                     .errors; // Ensure you're reading this correctly
        //                     let errorMessages = '';
        //                     for (const field in errors) {
        //                         if (errors.hasOwnProperty(field)) {
        //                             errorMessages += errors[field].join('<br>') + '<br>';
        //                         }
        //                     }
        //                     Swal.fire({
        //                         title: 'Validation Errors',
        //                         html: errorMessages,
        //                         icon: 'error',
        //                         confirmButtonText: 'Okay'
        //                     });
        //                 } else {
        //                     Swal.fire({
        //                         title: 'Error',
        //                         text: 'An error occurred: ' + xhr.responseText,
        //                         icon: 'error',
        //                         confirmButtonText: 'Okay'
        //                     });
        //                     console.error(xhr); // Optional: Log the error for debugging
        //                 }
        //             },
        //             complete: function() {
        //                 $('#submit-button').prop('disabled', false);
        //                 $('#ld').hide();
        //                 $('#overlay').hide();
        //             }
        //         });
        //     });
        // });
    </script>
    {{-- add js end here --}}
    {{-- section end here --}}
@endsection
