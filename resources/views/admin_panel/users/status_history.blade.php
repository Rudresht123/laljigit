<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Status-History</li>
            <li class="breadcrumb-item active" aria-current="page">User Status Case File</li>
        </ol>
    </nav>


    {{-- message code here --}}

    {{-- main content start here --}}
    <div class="container mt-3">
        <div class="panel panel-default mt-3 custom-card">
            <div class="panel-heading">
                <div class="row mb-4 border-bottom pb-2">
                    <div class="col-sm-8 fs-12">
                        <b><i class="fa fa-list"></i> Client Status History : <span
                                class="text-primary">{{ $statusHistory->file_name ?? '' }}</span></b>

                    </div>
                </div>
            </div>
            <div class="panel-body mb-0">
                <div class="content ">
                    <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                        <div class="media d-block d-lg-flex">
                            <div class="media-body">
                                <div class="timeline-group tx-13">
                                    <div class="timeline-label fs-12">StatusHistory</div>
                                    @php
                                         $statusdata = $statusHistory->statusHistories->status_history ?? 'Hello';
                                         $decodedData = json_decode($statusdata);
                                    @endphp
                                    @foreach ($decodedData as $decodeddata)
                                    <div class="timeline-item mb-4">
                                        <div class="timeline-time fs-10 fw-bold"> {{ \Carbon\Carbon::parse($decodeddata->date)->format('j F Y') ?? '' }}</div>
                                        <div class="timeline-body">
                                            {{-- status --}}
                                            @foreach ($status as $statusItem)
                                                @if ($statusItem->id==$decodeddata->status)
                                                <h6 class="mg-b-0">Status : <span class="text-primary">{{$statusItem->status_name ?? ''}}</span></h6>
                                                @endif
                                            @endforeach
                                            {{-- substatus --}}
                                            @foreach ($substatus as $substatusItem)
                                            @if ($substatusItem->id==$decodeddata->sub_status)
                                            <h6 class="mg-b-0 fs-10 mt-1"><b>Sub Status Remarks :</b> <span class="text-primary">{{$substatusItem->substatus_name ?? ''}}</span></h6>
                                            @endif
                                        @endforeach
                                        </div><!-- timeline-body -->
                                    </div> 
                                    @endforeach
                                  <!-- timeline-item -->
                                </div><!-- timeline-group -->

                            </div><!-- media-body -->

                        </div><!-- media -->
                    </div><!-- container -->
                </div>

            </div>


        </div>
    </div>

    {{-- main content end here --}}


    {{-- main section end here --}}
@endsection
