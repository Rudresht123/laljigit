<!-- Extending master layout here -->
@extends('admin_panel.comman.masterLayout')
<!-- Extending master layout here -->


@section('main-content')
    {{-- main section start here --}}

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Global Setting</li>
            <li class="breadcrumb-item active" aria-current="page">TradeMarkClasses</li>
        </ol>
    </nav>


    {{-- table section start here --}}
    <div class="custom-card col-lg-11 mx-auto">
        <div class="panel panel-default">
            <div class="panel-body pd-b-0 row">
                <div class="col-lg-12 vhr">
                    <div class="row mb-1">
                        <div class="col-sm-8"> <div class="panel-heading"><b><i class="fa fa-list"></i> Trademark Classes List</b></div></div>
                    </div>
                    <div class="table-responsive">
                        <table id="trademarkClasses" class="table table-hover w-100   fs-10 ">
                            <thead class="bg-light fw-bold">
                                <tr class="py-3">
                                    <th class="fw-bold text-center">Class Name</th>
                                    <th class="fw-bold">Class Desciption</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($classes as $class)
                                <tr>
                                    <td class="fw-bold text-center bg-light">{{$class->class_name ? $class->class_name : ''}}</td>
                                    <td>{{$class->description ? $class->description : ''}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                   
                </div>
            </div>

        </div>
    </div>
    {{-- table section end here --}}


    {{-- import modal here --}}
<script type="text/javascript">
$(document).ready(function(){
    $('#trademarkClasses').DataTable({
  responsive: true,
  language: {
    searchPlaceholder: 'Search...',
    sSearch: '',
    lengthMenu: '_MENU_ items/page',
  }
});
});
</script>
    {{-- main section end here --}}
@endsection