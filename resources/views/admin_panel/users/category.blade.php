<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb"> 
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item" aria-current="page">Attorney Category</li>
            <li class="breadcrumb-item active" aria-current="page">{{$attorney->attorneys_name ?? ''}}</li>
        </ol>
    </nav>

{{-- category section start here --}}
<div class="container">
<div class="row row-xs text-center">
    @foreach ($mainCategory as $category)
    <div class="col-sm-12 col-lg-4 m-2 m-md-0 text-center">
      <a href="{{route('admin.attorney.user-registration',['attoernyId' => $attorney->id, 'category' => $category->category_slug])}}">
        <div class="atorney-card card card-body p-3 mb-2">
          <div class="d-flex align-items-center">
            <img src="{{ $category->category_icon ? asset('storage/uploads/category_icon/' . $category->category_icon) : asset('assets/img/icons/ipicon.png') }}" 
     style="height:50px;width:50px;" 
     class="border me-1 rounded-50" 
     alt="Category Icon">   <span class="tx-normal tx-rubik mg-b-0 mg-r-5 lh-1 fw-bold fs-5 text-dark">{{ ucwords($category->category_name)}}</span> 
          </div>
        </div>
    </a>
  </div>
  @endforeach
</div>
</div>
{{-- category section start here --}}

{{-- /chart section start here --}}
<div class="container mt-4">
  <div class="row">
    <div class="col-sm-6 mb-3"> <!-- Added mb-3 to give margin bottom -->
      <div class="custom-card">
          <div class="panel m-0 p-0  panel-default">
              <div class="panel-heading border-bottom mb-2">
                  <h6 class="tx-14 m-0 p-0 d-flex justify-content-between" style="padding-right: 45px !important;">
                      <b class="fs-12">
                        Total Trademark
                      </b>
                      <b class="fs-12"><span class="badge text-dark fs-14">{{$totalCount ?? ''}}</span></b>
                  </h6>
              </div>
              <div class="panel-body pt-0">
                <table class="table  table-bordered table-hover fs-10">
                  <thead class="bg-light">
                    <tr>
                      <th class="fw-bold text-center">Sr.</th>
                      <th class="fw-bold text-center">Status</th>
                      <th class="fw-bold text-center">Count</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $count=0;
                    @endphp
                    @foreach ($statuswisecount as $clientCount)
                        <tr>
                          <td class="text-center">{{++$count}}</td>
                          <td class="fs-12">{{$clientCount->status_name ?? ''}}</td>
                          <td class="text-center">
                            <span class="fs-10">
                                <a class="text-primary" 
                                   href="{{ route('admin.attorney.chart.status-data', [
                                       'attorney_id' => $attorney->id, 
                                       'category_slug' => 'trademark', 
                                       'status_id' => $clientCount->id
                                   ]) }}">
                                    {{ $clientCount->usercount ?? '' }}
                                </a>
                            </span>
                        </td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
          </div>
      </div>
  </div>
  </div>
  </div>
</div>
{{-- /chart section start here --}}


{{-- main section end here --}}

@endsection