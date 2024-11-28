<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">Edit Client Details</li>
        </ol>
    </nav>


    {{-- message code here --}}


    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                timer: 3000, // auto close after 3 seconds
                showConfirmButton: false
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                timer: 3000, // auto close after 3 seconds
                showConfirmButton: false
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



    {{-- message code end here --}}
    {{-- form-section start here --}}
    {{-- table section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr p-3">
                    <div class="row mb-3 d-flex justify-content-end">
                        <div class="col-sm-12">
                            <div class="panel-heading"><b><i class="fa fa-list"></i> Attoreny :
                                    {{ $attorney->attorneys_name }}</b></div>
                        </div>
                    </div>
                    @if ($category->category_slug === 'trademark')
                        <form action="{{ route('admin.attorney.updatetrademarkformdata',$client->application_no) }}" method="POST">
                            @csrf
                            <fieldset class="form-fieldset">
                                <legend>Basic Information</legend>
                                <div class="row p-4">


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Attorney ID<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="attorney_id"
                                            value="{{ $attorney->id }}" readonly placeholder="Attoreny Name..">
                                    </div>

                                    <div class="col-sm-4" hidden>
                                        <label for="" class="form-label">Category ID<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="category_id"
                                            value="{{ $category->id }}" readonly placeholder="Attoreny Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Office<span
                                                class="text-danger">*</span></label>
                                        <select name="office_id" class="form-select" id="">
                                            <option value="">**Please Office Name...</option>
                                            @foreach ($offices as $office)
                                                <option {{$office->id==$client->office_id ? 'selected' : ''}} value="{{ $office->id ? $office->id : '' }}">
                                                    {{ $office->office_name ? $office->office_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Application No.<span
                                                class="text-danger">*</span></label>
                                        <input type="text" readonly  value="{{$client->application_no ? $client->application_no : ''}}" class="form-control" required name="application_no"
                                            placeholder="File Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">File Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->file_name ? $client->file_name : ''}}" class="form-control" required name="file_name"
                                            placeholder="File Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Trademark Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->trademark_name ? $client->trademark_name : ''}}" class="form-control" required name="trademark_name"
                                            placeholder="File Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">TradeMark Class<span
                                                class="text-danger">*</span></label>
                                        <select name="trademark_class" class="form-select" id="">
                                            <option value="">**Please Select Trademark Class...</option>
                                            @foreach ($classes as $class)
                                                <option {{$class->class_name==$client->trademark_class ? 'selected' : ''}} value="{{ $class->class_name ? $class->class_name : '' }}">
                                                    {{ $class->class_name ? $class->class_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Filling Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->filling_date ? $client->filling_date : ''}}"  class="form-control datepicker" required name="filling_date"
                                            placeholder="File Name..">
                                    </div>

                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Phone Number<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->phone_no ? $client->phone_no : ''}}" class="form-control" required name="phone_no"
                                            placeholder="Phone Number..">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email ID<span
                                                class="text-danger">*</span></label>
                                        <input type="email" value="{{$client->email_id ? $client->email_id : ''}}" class="form-control" required name="email_id"
                                            placeholder="Please Enter Email Here..">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Date Of Application<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->date_of_application ? $client->date_of_application : ''}}" class="form-control datepicker" required
                                            name="date_of_application" placeholder="Date Of Application..">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Objected Hearing Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text"  value="{{$client->objected_hearing_date ? $client->objected_hearing_date : ''}}" class="form-control datepicker" required
                                            name="objected_hearing_date" placeholder="Objected Hearing Date..">
                                    </div>



                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Opponenet / Applicant name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->opponenet_applicant_name	 ? $client->opponenet_applicant_name	 : ''}}" class="form-control" required
                                            name="opponenet_applicant_name" placeholder="Opponenet / Applicant name..">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Opposition Hearing Date<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->opposition_hearing_date ? $client->opposition_hearing_date : ''}}" name="opposition_hearing_date"
                                            class="form-control datepicker" placeholder="Choose date">
                                    </div>


                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Valid up-To<span
                                                class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->valid_up_to ? $client->valid_up_to : ''}}" class="form-control datepicker" name="valid_up_to" required
                                            placeholder="Opposition Hearing Date..">
                                    </div>



                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Status<span
                                                class="text-danger">*</span></label>
                                        <select name="status" id="status" class="form-select" id="">
                                            <option value="">**Please Select Status</option>
                                            @foreach ($statuss as $status)
                                                <option {{$status->id == $client->status ? 'selected' : ''}} data-id="{{ $status->id }}"
                                                    value="{{ $status->id ? $status->id : '' }}">
                                                    {{ $status->status_name ? $status->status_name : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="" class="form-label">Sub-Status<span
                                                class="text-danger">*</span></label>
                                        <select name="sub_status" id="sub-status" class="form-select select2"
                                            id="">
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="" class="form-label">Sub-Category<span
                                                class="text-danger">*</span></label>
                                        <select name="sub_category" id="sub-category" class="form-select select2"
                                            id="">
                                            <option value="">**Please Select Sub-Category</option>
                                            @forEach($subcategory as $subcat)
                                            <option {{$subcat->id == $client->sub_category ? 'selected' :''}} value="{{$subcat->id ? $subcat->id : ''}}">{{$subcat->subcategory ? $subcat->subcategory : ''}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                            </fieldset>
                            </fieldset>


                            <fieldset class="form-fieldset mt-4">
                                <legend>Consultant Information</legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Consultant Name<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required  value="{{$client->consultant_name ? $client->consultant_name : ''}}" name="consultant_name"
                                            placeholder="Please Enter Consultant Name..">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Deal With<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" value="{{$client->deal_with ? $client->deal_with : ''}}" required name="deal_with"
                                            placeholder="Please Enter Deal with Name..">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Filed By<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" readonly required
                                            value="{{ $attorney->attorneys_name ? $attorney->attorneys_name : '' }}"
                                            name="filed_by" placeholder="Please Enter Filed Name Name..">
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Opposition Status<span
                                                class="text-danger">*</span></label>

                                        <select name="opp_status" class="form-select select2" id="">
                                            <option value="">**Please Select Opposition Status</option>
                                            @foreach ($oppsition_status as $opp_status)
                                                <option {{$opp_status->id==$client->opp_status ? 'selected' :'' }} value="{{ $opp_status->id ? $opp_status->id : '' }}">
                                                    {{ $opp_status->opp_status_name ? $opp_status->opp_status_name : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Remarks</label>
                                        <select name="remarks" class="form-select select2" id="">
                                            <option value="">**Please Select Remarks</option>
                                            @foreach ($remarks as $remark)
                                                <option {{$remark->id==$client->remarks ? 'selected' :'' }}  value="{{ $remark->id ? $remark->id : '' }}">
                                                    {{ $remark->remarks ? $remark->remarks : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-12 ">
                                        <label for="" class="form-label">Client Remarks</label>
                                        <select name="client_remarks" class="form-control select2 " id="">
                                            <option value="">**Please Select Remarks</option>
                                            @foreach ($clientRemarks as $cleintRemark)
                                                <option {{$cleintRemark->id==$client->client_remarks ? 'selected' :'' }}  value="{{ $cleintRemark->id ? $cleintRemark->id : '' }}">
                                                    {{ $cleintRemark->client_remarks ? $cleintRemark->client_remarks : '' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </fieldset>


                            <fieldset class="form-fieldset mt-4">
                                <legend>Client Communication Information</legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">IP Field <span class="text-danger">*</span></label>
                                        <input type="text" value="{{$client->ip_field}}" name="ip_field" readonly class="form-control" placeholder="Name Of IP Field...">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Evidence Last Date</label>
                                        <input type="text" value="{{$client->evidence_last_date}}" name="evidence_last_date" class="form-control datepicker" placeholder="Please Enter Evidence last Date...">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email Recived Date</label>
                                        <input type="text" value="{{$client->mail_recived_date}}" class="form-control datepicker" name="mail_recived_date" 
                                            placeholder="Email Recived Date 2..">
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="" class="form-label">Email Recived Date 2</label>
                                        <input type="text" value="{{$client->mail_recived_date_2}}" class="form-control datepicker" name="mail_recived_date_2" 
                                            placeholder="Email Recived Date 2..">
                                    </div>

                                    <div class="col-sm-8">
                                        <label for="" class="form-label">Email Remarks</label>
                                        <textarea class="form-control"  name="email_remarks" placeholder="Please Enter Client Email Remarks..." id="" cols="1" rows="1">{{$client->email_remarks}}</textarea>
                                  
                                    </div>

                                    <div class="col-sm-12">
                                        <label for="" class="form-label">Client Communication</label>
                                        <textarea class="form-control" name="client_communication" placeholder="Please Enter Client Communication Feedback Here..." id="" cols="2" rows="2">{{$client->client_communication}}</textarea>
                                    </div>

                                </div>
                            </fieldset>

                            <div class="row mt-3">
                                <div class="col-lg-12 d-flex justify-content-end">
                                    <input type="reset" value="Reset" class="btn me-2 btn-danger px-3 py-1">
                                    <input type="submit" value="Submit" class="btn btn-primary px-3 py-1">
                                </div>
                            </div>
                            </form>
                    @elseif($category->category_slug === 'copyright')
                    <div class="row">
                        <div class="col-sm-6 mx-auto text-center">
                            <h3>In working</h3>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    {{-- form-section start here --}}



    {{-- script section statr here --}}
    <script type="text/javascript">
        // code for geting substatus
        $(document).ready(function() {
    // Function to fetch sub-status based on status ID
    function fetchSubStatus(statusId) {
        let route = "{{ route('getsubstatus', ':id') }}".replace(':id', statusId);

        $.ajax({
            url: route,
            type: 'GET',
            success: function(response) {
                let select = $('#sub-status');
                select.empty(); // Clear existing options before appending new ones
                response.forEach(substatus => {
                    let options = `
                        <option value="${substatus.id}">${substatus.substatus_name}</option>
                    `;
                    select.append(options);
                });
            }
        });
    }

    // On page load, fetch sub-status based on the selected status
    let initialStatusId = $('#status').val();
    if (initialStatusId) {
        fetchSubStatus(initialStatusId);
    }

    // On change of status, fetch sub-status dynamically
    $('#status').on('change', function(e) {
        e.preventDefault();
        let statusId = $(this).val();
        if (statusId) {
            fetchSubStatus(statusId);
        }
    });
});

    </script>
    {{-- script section statr here --}}

    {{-- main section end here --}}
@endsection
