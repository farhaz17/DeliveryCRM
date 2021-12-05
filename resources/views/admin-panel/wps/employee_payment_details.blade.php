@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .modal_table .table th{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }

        .modal_table .table td{
            padding: 2px;
            font-size: 12px;
            font-weight: 300;
        }
        caption { caption-side:top; }
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wps_dashboard',['active'=>'reports-menu-items']) }}">WPS Reports</a></li>
      <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
    </ol>
</nav>

<div class="container">
    <div class="form-check-inline mb-4">
        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
        <label for="repair_category">Filter By Company</label>
        <select id="companyName" class="form-control" class="company_cls" name="company_name">
            <option value="" selected>Select Company</option>
            <option value="0">ALL EMPLOYEES</option>
            @foreach($companies as $com)
                <option value="{{$com->id}}">{{$com->name}}</option>
            @endforeach
        </select>
        <label for="repair_category" class="ml-3">Filter By 4PL</label>
        <select id="fourPL" class="form-control" class="company_cls" name="four_pl">
            <option value="" selected>Select Company</option>
            <option value="0">All Enployees</option>
            @foreach($four_pls as $com)
                <option value="{{$com->id}}">{{$com->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-md-12 mb-3">
    <div class="row card container m-auto p-3">
        <div>
            <form action="{{ route('wps-data-export') }}" method="POST">
                {!! csrf_field() !!}
                <input type="hidden" name="company_id" value="" id="companyId">
                <input type="submit" class="btn btn-primary" value="Export User Data">
            </form>
            {{-- <a class="btn btn-primary" href="{{ route('wps-data-export') }}">Export User Data</a> --}}
        </div>

        <div class="card-title mb-3 mt-4">Employee Details</div>
        <table class="table table-sm table-hover text-12 data_table_cls">
            <thead>
            <tr>
                <th>Name</th>
                <th>Company</th>
                <th>Passport No</th>
                <th>PPUID</th>
                <th>Labour Card No</th>
                <th>Default Payment Method</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
</div>


 <!---------WPS Details Modal---------->
 <div class="modal fade" id="wpsDetails">
    <div class="modal-dialog modal-lg modal-xl">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="table-responsive modal_table">
                        <h6>Personal Detail</h6>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Name</th>
                                <td><span id="fullName"></span></td>
                            </tr>
                            <tr>
                                <th>Company</th>
                                <td><span id="company"></span></td>
                            </tr>
                            <tr>
                                <th>Passport No</th>
                                <td><span id="passportNo"></span></td>
                            </tr>

                            <tr>
                                <th>PP UID</th>
                                <td><span id="ppUid"></span></td>
                            </tr>

                            <tr>
                                <th>Labour Card No</th>
                                <td><span id="labourCardNo"></span></td>
                            </tr>


                        </table>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mt-4">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Active Payment Method</th>
                                <td><span id="activePaymentMethod"></span></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="mt-4 col-md-12">

                    <table id="allCardDetails" class="table table-bordered table-striped" style="display: none">
                        <caption class="text-center">C3 Card Details</caption>
                        <tr>
                            <th>Card No</th>
                            <th>Code No</th>
                            <th>Expiry</th>
                            <th>Remarks</th>
                        </tr>
                    </table>

                    <table id="luluCardDetails" class="table table-bordered table-striped" style="display: none">
                        <caption class="text-center">Lulu Card Details</caption>
                        <tr>
                            <th>Card No</th>
                            <th>Code No</th>
                            <th>Expiry</th>
                            <th>Remarks</th>
                        </tr>
                    </table>

                    <table id="bankDetails" class="table table-bordered table-striped" style="display: none">
                        <caption class="text-center">Bank Account Details</caption>
                        <tr>
                            <th>Bank Name</th>
                            <th>IBAN No</th>
                            <th>Remarks</th>
                        </tr>
                    </table>

                </div>
            </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>


    all_load_data(0, 0);

    $(document).on('click', '#wpsModalBtn', function(){
        var wps_id = $(this).attr('data-id');
        $.ajax({
            url: "{{ URL::to('wps-individual-details') }}",
            method: 'GET',
            data:{ wps_id: wps_id },
            success: function (response) {


                $('#allCardDetails').hide()
                $('#luluCardDetails').hide()
                $('#bankDetails').hide()
                $('.appendedRow').remove('.appendedRow')
                $('.appendedRowLulu').remove('.appendedRowLulu')
                $('.appendedRowBank').remove('.appendedRowBank')

                var c_three_details = response[0].c_three_details;
                c_three_details.forEach(element => {
                    // console.log(element)
                    $('#allCardDetails').show()
                    $('#allCardDetails tr:last').after("<tr class='appendedRow'><td>"+element.card_no+"</td><td>"+element.code_no+"</td><td>"+element.expiry+"</td><td></td></tr>");
                });

                var lulu_card_details = response[0].lulu_card_details;
                lulu_card_details.forEach(element => {
                    // console.log(element)
                    $('#luluCardDetails').show()
                    $('#luluCardDetails tr:last').after("<tr class='appendedRowLulu'><td>"+element.card_no+"</td><td>"+element.code_no+"</td><td>"+element.expiry+"</td><td></td></tr>");
                });

                var bank_details = response[0].bank_details;
                bank_details.forEach(element => {
                    // console.log(element)
                    $('#bankDetails').show()
                    $('#bankDetails tr:last').after("<tr class='appendedRowBank'><td>"+element.bank_name+"</td><td>"+element.iban_no+"</td><td></td></tr>");
                });

                $("#ppUid").html(response[0].pp_uid);
                $("#passportNo").html(response[0].passport_no);
                $("#fullName").html(response[0].full_name);
                $("#company").html(response[0].name);
                $("#labourCardNo").html(response[0].labour_card_no);

                var paymentMethod = response[0].cash_or_exchange;
                if(paymentMethod == 1)
                    var activePaymentMethod = 'Office Cash';
                else if(paymentMethod == 2)
                    var activePaymentMethod = 'Exchange Cash (Lulu)';
                else if(paymentMethod == 3)
                    var activePaymentMethod = 'C3 Card';
                else if(paymentMethod == 4)
                    var activePaymentMethod = 'Lulu Card';
                else if(paymentMethod == 5)
                    var activePaymentMethod = 'Bank';

                $("#activePaymentMethod").html(activePaymentMethod);
                // $("#full_name").html(array.name);
                // $("#zds_code").html(array.zds_code);

            }
        });
    });

    $('#companyName').change(function () {
        var id = $(this).val();
        $("input[name='company_id']").val(id);
        // $('.wps-ajax-employee').show();
        all_load_data(id, 0);

    });

    $('#fourPL').change(function () {
        var id = $(this).val();
        $("input[name='four_pl']").val(id);
        // $('.wps-ajax-employee').show();
        all_load_data(0, id);

    });

    function all_load_data(company_id, four_pl_id) {
            $('table.data_table_cls').DataTable().destroy();
            $('table.data_table_cls').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{ URL::to('wps-employee-data-list') }}",
                data:{id: company_id, four_pl_id: four_pl_id},
            },
            columns: [
                { data: 'full_name' },
                { data: 'name' },
                { data: 'passport_no' },
                { data: 'pp_uid' },
                { data: 'labour_card_no' },
                { data: 'cash_or_exchange', name: 'cash_or_exchange' },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ],
            order: [[ 1, 'desc' ]],
            pageLength: 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/printer.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'excel',
                    // title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        // columns: [ 2, 3, 4, 5, 6],
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                {
                    extend: 'pdf',
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/pdf.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ]
            });
        }

    </script>

@endsection
