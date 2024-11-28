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
            <li class="breadcrumb-item active" aria-current="page">Email Configuration</li>
        </ol>
    </nav>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}"
            });
        </script>
    @endif

    @if (session('error'))
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



    {{-- form section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <div class="row mb-1 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading"><b><i class="fa fa-list"></i> Update Email Configuration
                                </b>
                                <a href="{{ route('admin.systemsetting.all-email-template') }}"
                                    class="btn btn-outline-primary float-end"><i data-feather="arrow-left"></i>All
                                    Template</a>
                            </div>
                        </div>
                    </div>
                    

                        <form action="{{ route('admin.systemsetting.email-config', $email->id) }}" method="POST">
                            @csrf

                            <div class="row">
                            {{-- form left section start here --}}
                            <div class="col-sm-4">
                                <label for="page_title" class="form-label">Mail Encription<span class="text-danger">*</span>
                                    :</label>
                                <div class="">
                                    <input name="mail_encription" required class="form-control" type="text"
                                        value="{{ $email->mail_encription ?? '' }}" placeholder="Enter Mail Encription">
                                </div>
                            </div>


                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail Mailer<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input type="text" name="mail_mailer" value="{{ $email->mail_mailer ?? '' }}"
                                        class="form-control" placeholder="Sulg...">
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail Host<span
                                        class="text-danger">*</span> :</label>
                                <div class="">
                                    <input name="mail_host" value="{{ $email->mail_host ?? '' }}" required
                                        class="form-control" type="text" placeholder="Subject.....">
                                </div>
                            </div>



                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail Port <span
                                        class="text-danger">*</span></label>
                                <div class="">
                                    <input name="mail_port" value="{{ $email->mail_port ?? '' }}" class="form-control"
                                        type="text" placeholder="Description..">
                                </div>
                            </div>


                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail Username</label>
                                <div class="">
                                    <input name="mail_username" class="form-control"
                                        value="{{ $email->mail_username ?? '' }}" type="text"
                                        placeholder="From Name...">
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail Password</label>
                                <div class="">
                                    <input name="mail_password" class="form-control"
                                        value="{{ $email->mail_password ?? '' }}" type="text"
                                        placeholder="From Name...">
                                </div>
                            </div>
                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail From Address</label>
                                <div class="">
                                    <input name="mail_fromaddress" class="form-control"
                                        value="{{ $email->mail_fromaddress ?? '' }}" type="text"
                                        placeholder="From Name...">
                                </div>
                            </div>

                            <div class="col-sm-4 ">
                                <label for="example-password-input1" class="form-label">Mail From Name</label>
                                <div class="">
                                    <input name="mail_fromname" class="form-control"
                                        value="{{ $email->mail_fromname ?? '' }}" type="text"
                                        placeholder="From Name...">
                                </div>
                            </div>
                            <div class="col-sm-4 pt-3">
                                <input type="reset" class="btn btn-danger me-2" value="Reset">
                                <input type="submit" class="btn btn-primary" value="Submit">
                            </div>
                        </div>
                        </form>
                    
                </div>
            </div>



        </div>
    </div>
    {{-- form section start here --}}



    {{-- script section start here --}}
@endsection
