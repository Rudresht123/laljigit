<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">User Registration</li>
        </ol>
    </nav>


    {{-- message code here --}}


{{-- main content start here --}}
<div class="panel panel-default mt-3 custom-card">
    <div class="panel-heading"></div>
    <div class="panel-body mb-0">

        <div class="row m-0 p-0 mt-0">

            <div id="sp_body" class="col-lg-12 m-0 p-0"><div class="card m-0 p-0 b-0" style="border: 0px !important;">
<div class="card-header b-0 rounded-0 pd-y-15 pd-x-20 d-flex align-items-center justify-content-between">
    <h6 class="tx-uppercase tx-semibold mg-b-0 d-flex"><div class="wd-30 text-center"><i class="fa fa-user" aria-hidden="true"></i></div><b> Client Profile [{{$clientdetail->trademark_name ? $clientdetail->trademark_name : '' }} - {{$clientdetail->financial_session ? $clientdetail->financial_session : '' }}] </b></h6>
    <div class="d-flex">
        <a href="{{route('admin.attorney.edit-clientDetails',['attoerny_id'=>$clientdetail->attorney_id,'category_slug'=>$clientdetail->category_slug,'application_no'=>$clientdetail->application_no])}}" class="btn btn-xs rounded-5 btn-outline-success d-flex align-items-center mg-r-5"><i class="typcn typcn-edit"></i> <span class="d-none d-sm-inline mg-l-5"> Edit</span></a>
        <a target="_blank" href="{{route('admin.client-details.print-pdf',['category_slug'=>$clientdetail->category_slug,'application_no'=>$clientdetail->application_no])}}" class="btn btn-xs rounded-5 btn-outline-primary d-flex align-items-center mg-r-5"><i class="typcn typcn-printer"></i>  Print</button>
        <a class="btn btn-xs rounded-5 btn-outline-danger d-flex  align-items-center"><i class="typcn typcn-trash"></i> <span class="d-none d-sm-inline mg-l-5"> Delete</span></a>
    </div>
</div>
<div class="card-body pd-lg-l-25 pd-lg-r-25 pd-lg-t-10" id="clientInformai">
    <div class="row">

        <div class="col-lg-12">
                <div class="tab-content mg-t-20" id="myTabContent5">
                    <div class="tab-pane fade active show" id="home5" role="tabpanel" aria-labelledby="home-tab5">
                        <div data-label="Office Details" class="df-example">

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Attorney Id</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->attorney_id ? $clientdetail->attorney_id : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Application No</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->application_no ? $clientdetail->application_no : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>File Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->file_name ? $clientdetail->file_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Trademark Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->trademark_name ? $clientdetail->trademark_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Trademark Class</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->trademark_class ? $clientdetail->trademark_class : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Filling Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->filling_date ? $clientdetail->filling_date : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Phone No</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->phone_no ? $clientdetail->phone_no : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Email ID.</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->email_id ? $clientdetail->email_id : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Date Of Application</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->date_of_application ? $clientdetail->date_of_application : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Opponenet Applicant Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->opponenet_applicant_name ? $clientdetail->opponenet_applicant_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Opposition Hearing Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->opposition_hearing_date ? $clientdetail->opposition_hearing_date : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Valid Up To</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->valid_up_to ? $clientdetail->valid_up_to : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Status</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->status_name ? $clientdetail->status_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Sub Status</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->sub_status_name ? $clientdetail->sub_status_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Consultant Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->consultant_name ? $clientdetail->consultant_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Deal With</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->deal_with ? $clientdetail->deal_with : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Office</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->office_name ? $clientdetail->office_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Sub Category</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->subcategory_name ? $clientdetail->subcategory_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Field By</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->filed_by ? $clientdetail->filed_by : ''}}</div></div></div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Client_remarks</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->client_remark_name ? $clientdetail->client_remark_name : ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>IP Field</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->ip_field ? $clientdetail->ip_field : ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Evidence Last Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->evidence_last_date ? $clientdetail->evidence_last_date : ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Email Recived Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->email_recived_date ? $clientdetail->email_recived_date : ''}}</div></div></div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4"><b>Email Recived Date 2</b></div><div class="col-8"><div class="bg-light ht-35 p-2">{{$clientdetail->email_recived_date_2 ? $clientdetail->email_recived_date_2 : ''}}</div></div></div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2"><b>Email Remarks</b></div><div class="col-10"><div class="bg-light ht-35 p-2">{{$clientdetail->email_remarks ? $clientdetail->email_remarks : ''}}</div></div></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2"><b>Client Communication</b></div><div class="col-10"><div class="bg-light ht-35 p-2">{{$clientdetail->client_communication ? $clientdetail->client_communication : ''}}</div></div></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2"><b>Remarks</b></div><div class="col-10"><div class="bg-light ht-35 p-2">{{$clientdetail->remark ? $clientdetail->remark : ''}}</div></div></div>
                                </div>
                              
                            </div>

                        </div>

                    </div>

        </div>

        <div></div>

       
    </div>

</div>
</div>

</div>

        </div>

    </div>
</div>
{{-- main content end here --}}


{{-- main section end here --}}
@endsection