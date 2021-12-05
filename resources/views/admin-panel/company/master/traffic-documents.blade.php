@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        
        </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'reports-menu-items']) }}">Company Documents</a></li>
      <li class="breadcrumb-item active" aria-current="page">Traffic</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
    <div class="card-body">
        <div class="card-title mb-3 col-12">Traffic</div>
        <div class="row">
            @forelse ($traffics as $traffic)
            <div class="col-md-4 text-left mb-3">
                <div class="ul-widget-app__social-friends">
                    <div class="ul-widget-app__small-title">
                        <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{ $traffic->company->name }}</span>
                        <span class="text-primary">
                            <a href="{{ $traffic->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $traffic->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $traffic->attachment }}">Download</a>
                        </span>
                    </div>
                </div>
            </div> 
            @empty
            <p>No data attachment available!</p>
            @endforelse
        </div>
    </div>
</div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 col-12">Salik</div>
            <div class="row">
                @forelse ($saliks as $salik)
                <div class="col-md-4 text-left mb-3">
                    <div class="ul-widget-app__social-friends">
                        <div class="ul-widget-app__small-title">
                            <span class="t-font-bolder"><i class="nav-icon i-File-Horizontal-Text text-16"></i> {{ $salik->company->name }}</span>
                            <span class="text-primary">
                                <a href="{{ $salik->attachment ?? asset('assets/images/faces/3.jpg')}}" target="_blank">View</a> | <a href="{{ $salik->attachment ?? asset('assets/images/faces/3.jpg')}}" download="{{ $salik->attachment }}">Download</a>
                            </span>
                        </div>
                    </div>
                </div> 
                @empty
                <p>No data attachment available!</p>
                @endforelse
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
    'use-strict'
    $('table.data_table_cls').DataTable( {
        "aaSorting": [[0, 'desc']],
        "pageLength": 10,
        "columnDefs": [
            {"targets": [0],"visible": false},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'print',
                title: 'Traffic Summary',
                text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'excel',
                title: 'Traffic Summary',
                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
            {
                extend: 'pdf',
                title: 'Traffic Summary',
                text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                exportOptions: {
                    modifier: {
                        page : 'all',
                    }
                }
            },
        ],
        select: true,
        scrollY: 300,
        responsive: true,
        // scrollX: true,
        // scroller: true
    });
});
</script>

<script>
function tostr_display(type,message){
    switch(type){
        case 'info':
            toastr.info(message);
            break;
        case 'warning':
            toastr.warning(message);
            break;
        case 'success':
            toastr.success(message);
            break;
        case 'error':
            toastr.error(message);
            break;
    }
}
</script>
@endsection