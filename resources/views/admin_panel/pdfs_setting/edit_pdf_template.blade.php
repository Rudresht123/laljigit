<!-- extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- extending master layout here -->

@section('main-content')
    {{-- main section start here --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">PDF Templates</li>
        </ol>
    </nav>
    {{-- main section end here --}}


       {{-- message code here --}}
 
   
       @if (session('success'))
       <script>
           Swal.fire({
               icon: 'success',
               title: 'Success!',
               text: '{{ session('success') }}',
               timer: 3000,  // auto close after 3 seconds
               showConfirmButton: true
           });
         </script>
       @endif
       @if (session('error'))
       <script>
           Swal.fire({
               icon: 'error',
               title: 'Error!',
               text: '{{ session('error') }}',
               timer: 3000,  // auto close after 3 seconds
               showConfirmButton: true
           });
           </script>
       @endif
       @if ($errors->any())
       <script>
           Swal.fire({
               icon: 'error',
               title: 'Validation Error',
               html: '<ul>' +
                   @foreach ($errors->all() as $error)
                       '<li>{{ $error }}</li>' +
                   @endforeach
                   '</ul>',
               showConfirmButton: true
           });
       </script>
       @endif
  
  

    {{-- form section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading">
                                <b><i class="fa fa-list"></i> Edit PDF Template</b>
                                <a href="{{route('admin.global-setting.pdf-template')}}" class="btn btn-primary float-end">All Template</a>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('admin.global-setting.edit-pdf-template',$pdfdata->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <fieldset class="form-fieldset">
                            <legend>Basic Information</legend>
                            <div class="row p-4">
                                <div class="col-sm-4">
                                    <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Template Name<span class="text-danger">*</span></label>
                                        <input type="text" name="template_name" required value="{{$pdfdata->template_name ? $pdfdata->template_name : ''}}" class="form-control" placeholder="Enter Template Name.." required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Template Slug<span class="text-danger">*</span></label>
                                        <input type="text" name="template_slug" required value="{{$pdfdata->template_slug ? $pdfdata->template_slug : ''}}" class="form-control" placeholder="Enter Template Slug.." required>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Template Logo</label>
                                        <input type="file" name="template_logo"  class="form-control" placeholder="Enter Template Slug.." >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Template Watermark</label>
                                        <input type="file" name="template_watermark" class="form-control" placeholder="Enter Template Slug.." >
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="" class="form-label">Is-Active<span class="text-danger">*</span></label>
                                        <select name="is_active" required class="form-select" id="" required>
                                            <option value="yes" {{$pdfdata->is_active==='yes' ? 'selected' : ''}}>Active</option>
                                            <option value="no" {{$pdfdata->is_active==='no' ? 'selected' : ''}}>De-Active</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-sm-12 d-flex justify-content-end mt-5">
                                    <input type="reset" class="btn btn-danger me-2"  value="Reset">
                                    <input type="submit" class="btn btn-primary" value="Submit">
                                </div>
                            </div>
                        </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="" class="form-label">Template HTML Code</label>
                                        <textarea name="content" class="form-control" id="editor" cols="30" rows="10" style="display:none;">{{$pdfdata->content ? $pdfdata->content :''}}</textarea>
                                       
                                    </div>
                                </div>
                                
                            </div>
                            
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- form section end here --}}

    {{-- Display submitted HTML content --}}
    

    <!-- Include Quill JS -->
  

  <!-- Include CKEditor 5 -->

@endsection
