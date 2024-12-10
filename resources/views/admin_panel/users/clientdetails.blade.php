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
    <h6 class="tx-uppercase tx-semibold mg-b-0 d-flex"><div class="wd-30 text-center"><i class="fa fa-user" aria-hidden="true"></i></div><b> Client Profile [{{$clientdetail->trademark_name ? $clientdetail->trademark_name : '' }} - {{$clientdetail->financialYear->financial_session ? $clientdetail->financialYear->financial_session : '' }}] </b></h6>
    <div class="d-flex">
        <a href="{{route('admin.attorney.edit-clientDetails',['attoerny_id'=>$clientdetail->attorney_id,'category_slug'=>$clientdetail->mainCategory->category_slug,'id'=>$clientdetail->id])}}" class="btn btn-xs rounded-5 btn-outline-success d-flex align-items-center mg-r-5"><i class="typcn typcn-edit"></i> <span class="d-none d-sm-inline mg-l-5"> Edit</span></a>
        <a target="_blank" href="{{route('admin.client-details.print-pdf',['category_slug'=>$clientdetail->mainCategory->category_slug,'id'=>$clientdetail->id])}}" class="btn btn-xs rounded-5 btn-outline-primary d-flex align-items-center mg-r-5"><i class="typcn typcn-printer"></i>  Print</button>
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
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Attorney Id</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->attorney_id ? $clientdetail->attorney_id : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Application No</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->application_no ? $clientdetail->application_no : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>File Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->file_name ? $clientdetail->file_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Trademark Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->trademark_name ? $clientdetail->trademark_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Trademark Class</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->trademark_class ? $clientdetail->trademark_class : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Filling Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->filling_date ? $clientdetail->filling_date : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Phone No</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->phone_no ? $clientdetail->phone_no : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Email ID.</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->email_id ? $clientdetail->email_id : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Opponenet Applicant Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->opponenet_applicant_name ?? ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Opposition Hearing Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->opposition_hearing_date ?? ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Valid Up To</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->valid_up_to ?? ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Status</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->statusMain->status_name ?? ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Status Remarks</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{ $clientdetail->subStatus->substatus_name ?? null }}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Consultant Name</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->Clientonsultant->consultant_name ?? ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Deal With</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->deal_with ? $clientdetail->dealWith->dealler_name : ''}}</div></div></div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Office</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->office->office_name ? $clientdetail->office->office_name : ''}}</div></div></div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Field By</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->filed_by ? $clientdetail->filed_by : ''}}</div></div></div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Whatsapp Remarks</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->clientRemark->client_remarks ?? ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>IP Field</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->ip_field ? $clientdetail->ip_field : ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Evidence Last Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->evidence_last_date ?? ''}}</div></div></div>
                                </div>


                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Email Recived Date</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->	mail_recived_date ?? ''}}</div></div></div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="row mb-2"><div class=" pt-2 col-4 fs-10"><b>Email Recived Date 2</b></div><div class="col-8"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->mail_recived_date_2 ??''}}</div></div></div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2 fs-10"><b>Email Remarks</b></div><div class="col-10"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->email_remarks ?? ''}}</div></div></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2 fs-10"><b>Client Communication</b></div><div class="col-10"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->client_communication ?? ''}}</div></div></div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="row mb-2"><div class=" pt-2 col-2 fs-10"><b>Remarks</b></div><div class="col-10"><div class="bg-light ht-35 p-2 fs-10">{{$clientdetail->remarksMain->remarks_name ?? ''}}</div></div></div>
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