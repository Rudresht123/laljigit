<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

{{-- message section start here --}}
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

@if($errors->any())
<script>
    let errorMessage = '';
    @foreach ($errors->all() as $error)
        errorMessage += "{{ $error }}\n"; // Append each error message
    @endforeach

    Swal.fire({
        icon: 'error',
        title: 'Validation Errors',
        text: errorMessage
    });
</script>
@endif

{{-- message section start here --}}


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
                <form action="{{route('admin.global-setting.update.sub-category',$subCategory->id)}}" method="post" id="addsubcategory">
                    @csrf
                    @method('put')
                    <fieldset class="form-fieldset">
                        <legend>Sub-Category</legend>

                        <!-- Flexbox for lg and md screens, stack on small screens -->
                        <div class="row d-flex flex-lg-row flex-md-row flex-sm-column">

                            <div class="col-lg-4 col-md-3 mb-3">
                                <label for="" class="form-label">Main Category</label>
                                <select name="main_category_id" class="form-select" id="">
                                    <option value="">**Select Main Category</option>
                                    @foreach ($mainCategory as $mcat)
                                        <option value="{{ $mcat->id ? $mcat->id : '' }}" {{$mcat->id == $subCategory->main_category_id ? 'selected' : ''}}>
                                            {{ $mcat->category_name ? $mcat->category_name : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-8 col-md-9 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="subcategoryName" value="{{$subCategory->subcategory ? $subCategory->subcategory : ''}}" required class="form-control" name="subcategory"
                                        placeholder="Enter Sub Category Name...">
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Remark</label>
                                    <textarea class="form-control"  name="subcategory_remark" id="subcatregoryRemark" cols="3" rows="3"
                                        placeholder="Please Enter Sub Category Remark...">{{$subCategory->subcategory_remark ? $subCategory->subcategory_remark : ''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Remark</label>
                                   <select name="status" class="form-select" id="">
                                    <option value="yes" {{$subCategory->status=='yes' ? 'selected' : ''}}>Active</option>
                                    <option value="no" {{$subCategory->status=='no' ? 'selected' : ''}}>De-Active</option>
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
    {{-- java script code end --}}
    {{-- main section end here --}}
@endsection
{{-- main section end here --}}
