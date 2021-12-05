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
        <li class="breadcrumb-item"><a href="{{ route('sim_wise_dashboard',['active'=>'reports-menu-items']) }}">SIM Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Sim Package List</li>
    </ol>
</nav>
<div class="card col-md-12 mb-2">
<div class="card-body">
    <div class="card-title mb-3 col-12">Sim Replace Reports</div>
    <div class="row">
        <table class="table table-sm table-hover table-striped text-11 data_table_cls" >
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>Replaced On</th>
                    <th>Sim No</th>
                    <th>Last Serial No</th>
                    <th>Last Replacement Reason</th>
                    <th>Last Paid By</th>
                    <th>Last Payment</th>
                    <th>Total Replaced</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($sim_cards as $sim_card)
               
                @php $last_history_index = $sim_card->replaces_history->max('id') @endphp
                <tr>
                    <td>&nbsp;</td>
                    <td> {{ dateToRead($sim_card->created_at) ?? '' }} </td>
                    <td> {{ $sim_card->account_number ?? '' }} </td>
                    <td> {{ $sim_card->get_last_record()->sim_sl_no ?? 'N/A' }} </td>
                    <td> {{ get_sim_replace_reason($sim_card->get_last_record()->reason)}} </td>
                    <td> {{ get_paid_by($sim_card->get_last_record()->paid_by)}} </td>
                    <td> {{ $sim_card->get_last_record()->amount ?? '' }} </td> {{-- Last Payment --}}
                    <td> {{ $sim_card->replaces_history->count()}} </td>{{-- Total Replaced --}}
                    <td> {{ $sim_card->replaces_history->sum('amount') ?? '' }} </td> {{-- Total Amount --}}
                    <td>
                        <a class="text-success mr-2 view_replacement_histroy_btn" href="{{ route('sim_card_replace.edit', $sim_card->id) }}" data-sim-id="{{ $sim_card->id }}" data-toggle="modal" data-target="#exampleModalCenter">
                            <i class="nav-icon i-eye font-weight-bold"></i>
                        </a>
                    </td>
                </tr>
                @empty

                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Sim Replacement History</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="sim_replacement_history_holder"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- <button class="btn btn-primary" type="button">Launch demo modal</button> --}}
</div>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $('select').select2();
</script>
<script>
    $('.view_replacement_histroy_btn').on('click', function(){
        var sim_id = $(this).attr('data-sim-id');   
        $.ajax({
            method: "GET",
            url: "{{ route('sim_replace_history') }}",
            dataType: "json",
            data: { sim_id }
        })
        .done(function(response) {
            $('#sim_replacement_history_holder').empty();
            $('#sim_replacement_history_holder').append(response.html);
        });
    });
</script>
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
                    title: 'Sim Card Replacement Report',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    title: 'Sim Card Replacement Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'Sim Card Replacement Report',
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
 @if(Session::has('message'))
    var type = "{{ Session::get('alert-type', 'info') }}";
    switch(type){
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;

        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;

        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;

        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
    @endif
</script>
@endsection