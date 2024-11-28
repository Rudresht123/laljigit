<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->



@section('main-content')


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
                <form method="post" action="{{route('admin.global-setting.update-sub-status',$substatus->id)}}">
                    @csrf
                    @method('PUT')
                    <fieldset class="form-fieldset">
                        <legend>Sub-Status</legend>

                        <!-- Flexbox for lg and md screens, stack on small screens -->
                        <div class="row d-flex flex-lg-row flex-md-row flex-sm-column">

                            <div class="col-lg-4 col-md-3 mb-3">
                                <label for="" class="form-label">Main Status</label>
                                <select name="main_status_id" required class="form-select select2" id="">
                                    <option value="">**Select Main Status</option>
                                    @foreach ($mainStatus as $mStatus)
                                        <option value="{{ $mStatus->id ? $mStatus->id : '' }}" {{ $mStatus->id === $substatus->id ? 'selected' : '' }}>
                                            {{ $mStatus->status_name ? $mStatus->status_name : '' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-8 col-md-9 mb-3">
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-name<span class="text-danger">*</span></label>
                                    <textarea class="form-control" required  name="substatus_name" id="substatus_name" cols="2" rows="2"
                                        placeholder="Please Enter Sub Status Remark...">{{$substatus->substatus_name ? $substatus->substatus_name :''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Sub-Category-Remark</label>
                                    <textarea class="form-control"  name="substatus_remarks" id="substatus_remarks" cols="2" rows="2"
                                        placeholder="Please Enter Sub Status Remark...">{{$substatus->substatus_remarks ? $substatus->substatus_remarks :''}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="" class="form-label">Is-Active</label>
                                   <select name="status" class="form-select" id="status">
                                    <option value="yes" {{$substatus->status === 'yes' ? 'selected' :''}}>Active</option>
                                    <option value="no" {{$substatus->status === 'no' ? 'selected' :''}}>De-Active</option>
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

@endsection
{{-- main section end here --}}
