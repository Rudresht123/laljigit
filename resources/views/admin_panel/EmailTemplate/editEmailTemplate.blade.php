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


    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}"
        });
    </script>
    @endif
    
    @if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}"
        });
    </script>
    @endif
    
    
    @if ($errors->any())
        <script>
            // Collect all error messages
            var errors = @json($errors->all());
    
            // Create a single string with all errors
            var errorMessages = errors.join('<br>');
    
            // Display the SweetAlert with error messages
            Swal.fire({
                title: 'Validation Errors',
                html: errorMessages,
                icon: 'error',
                confirmButtonText: 'Okay'
            });
        </script>
    @endif
    
    {{-- message section --}}
    

    {{-- form section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <form action="{{route('admin.systemsetting.update-template',$template->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                    <div class="row mb-1 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading"><b><i class="fa fa-list"></i> Cretae Email Template 
                                </b>
                            <a href="{{route('admin.systemsetting.all-email-template')}}" class="btn btn-outline-primary float-end"><i data-feather="arrow-left"></i>All Template</a>
                            </div>
                        </div>
                       
                           
                        <div class="col-sm-4">
                            {{-- form left section start here --}}
                            <div class="mb-1">
                                <label for="page_title" class="form-label">Template Name<span class="text-danger">*</span>
                                    :</label>
                                <div class="">
                                    <input name="name" value="{{$template->name ?? ''}}" required class="form-control" type="text"
                                        placeholder="page Title">
                                </div>
                            </div>


                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Slug<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input type="text" value="{{$template->slug ?? ''}}" name="slug" class="form-control" placeholder="Sulg...">
                                </div>
                            </div>

                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Subject<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input name="subject" value="{{$template->subject ?? ''}}" required class="form-control" type="text"
                                        placeholder="Subject.....">
                                </div>
                            </div>



                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">Description <span
                                        class="text-danger">*</span></label>
                                <div class="">
                                    <input name="description" value="{{$template->description ?? ''}}" class="form-control" type="text"
                                        placeholder="Description..">
                                </div>
                            </div>


                            <div class="mb-1 ">
                                <label for="example-password-input1" class="form-label">From Name</label>
                                <div class="">
                                    <input name="from_name" value="{{$template->from_name ?? ''}}" class="form-control" type="text" placeholder="From Name...">
                                </div>
                            </div>


                            <div class="mb-1">
                                <label for="">From Email</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" id="example-input2-group1" value="{{$template->from_email ?? ''}}" name="from_email" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>



                            <div class="mb-1">
                                <label for="">CC Email</label>
                                <div class="input-group mb-1">
                                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                    <input type="email" id="example-input2-group1" value="{{$template->cc_email ?? ''}}" name="cc_email" class="form-control"
                                        placeholder="Email">
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-8 ">
                            <label for="example-password-input1" class="form-label">Content</label>
                            <div class="">
                                <textarea name="content" id="editor" class="form-control" id="" cols="5" rows="3"
                                    placeholder="Meta Desciption">{{$template->content ?? ''}}</textarea>
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



   @endsection
