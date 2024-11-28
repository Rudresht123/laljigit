<!-- exteinding master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- exteinding master layout here -->


@section('main-content')
    {{-- main section start here --}}

    {{-- table section satrt here --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a
                    href="{{ route('admin.systemsetting.all-email-template') }}">All Templates</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Template</li>
        </ol>
    </nav>




    {{-- form section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <form id="AddTemplate" method="POST">
                    <div class="row mb-1 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading"><b><i class="fa fa-list"></i> Cretae Email Template 
                                </b>
                            <a href="{{route('admin.systemsetting.all-email-template')}}" class="btn btn-outline-primary float-end"><i data-feather="arrow-left"></i>All Template</a>
                            </div>
                        </div>
                       
                            @csrf
                        <div class="col-sm-4">
                            {{-- form left section start here --}}
                            <div class="mb-1">
                                <label for="page_title" class="form-label">Template Name<span class="text-danger">*</span>
                                    :</label>
                                <div class="">
                                    <input name="name" required class="form-control" type="text"
                                        placeholder="page Title">
                                </div>
                            </div>


                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Slug<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input type="text" name="slug" class="form-control" placeholder="Sulg...">
                                </div>
                            </div>

                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Subject<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input name="subject" required class="form-control" type="text"
                                        placeholder="Subject.....">
                                </div>
                            </div>



                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <div class="">
                                    <input name="description" class="form-control" type="text"
                                        placeholder="Description..">
                                </div>
                            </div>


                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">From Name</label>
                                <div class="">
                                    <input name="from_name" class="form-control" type="text" placeholder="From Name...">
                                </div>
                            </div>


                            <div class="mb-1">
                                <label for="">From Email</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" id="example-input2-group1" name="from_email" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>



                            <div class="mb-1">
                                <label for="">CC Email</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" id="example-input2-group1" name="cc_email" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8 ">
                            <label for="example-password-input1" class="form-label">Content</label>
                            <div class="">
                                <textarea name="content" id="editor" class="form-control" id="" cols="5" rows="3"
                                    placeholder="Meta Desciption"></textarea>
                            </div>
                            <div class="row mt-2 ">
                                <div class="col-sm-12 d-flex justify-content-end align-item-center">
                                    <input type="reset" class="btn btn-danger me-2" value="Reset">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>

                        </div>
                    

                    </div>
                
                </div>
            </form>
            </div>
        </div>
    {{-- form section start here --}}



    {{-- script section start here --}}
    <script class="text/javascript">
        $(document).ready(function() {
            $('#AddTemplate').on('submit', function(e) {
                e.preventDefault();

                let route = "{{ route('admin.systemsetting.create-template') }}";
                let formData = new FormData(this);

                // Ensure CKEditor is ready and get its data
                let editorData = CKEDITOR.instances.editor ? CKEDITOR.instances.editor.getData() : '';
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Correct CSRF token header
                    },
                    url: route,
                    type: "POST",
                    data: formData,
                    processData: false, // Ensure formData is sent as multipart
                    contentType: false, // Ensure contentType is not set (FormData does this automatically)
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.success
                            }).then(function() {
                                if (CKEDITOR.instances.editor) {
    CKEDITOR.instances.editor.setData(''); // Clear the editor content
}
                                $('#AddTemplate')[0]
                            .reset(); // Reset the form after success
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error || 'An unexpected error occurred.'
                            });
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessages = '';

                            // Concatenate validation error messages
                            $.each(errors, function(key, value) {
                                errorMessages += value.join('<br>') + '<br>';
                            });

                            Swal.fire({
                                title: 'Validation Errors',
                                html: errorMessages,
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'An unexpected error occurred. Please try again.',
                                icon: 'error',
                                confirmButtonText: 'Okay'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endsection
