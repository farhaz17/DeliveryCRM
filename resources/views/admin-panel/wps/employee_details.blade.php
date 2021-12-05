@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wps_dashboard',['active'=>'reports-menu-items']) }}">WPS Reports</a></li>
      <li class="breadcrumb-item active" aria-current="page">Employee Details</li>
    </ol>
</nav>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="row form-group mb-6">

                    <div class="col-md-4 text-left ">
                        <div class="form-check-inline">
                            <label for="repair_category">Filter By Company</label>
                            <select id="companyName" class="form-control" class="company_cls" name="company_name">
                                <option value="" selected>Select Company</option>
                                @foreach($company as $com)
                                    <option value="{{$com->id}}">{{$com->name}} ({{ isset($com->total_employee) ? $com->total_employee : '0' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 text-left ">
                        <div class="form-check-inline">
                            <label for="repair_category">Filter By Employee Type</label>
                            <select id="employeeType" class="form-control" class="employee_type" name="employee_type">
                                <option value="">Select Employee Type</option>
                                    <option value="1">Not Employee</option>
                                    <option value="2">Full Time</option>
                                    <option value="3">Part Time</option>
                            </select>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="card-title mb-3 mt-4">Employee Details</div>
    <div class="row">
        <table class="table table-sm table-hover text-12 data_table_cls">
            <thead>
            <tr>
                <th>Name</th>
                <th>Passport No</th>
                <th>PPUID</th>
                <th>ZDS Code</th>
                <th>Visa Number</th>
                <th>Emirates ID</th>
                <th>MB No</th>
                <th>Labour Card No</th>
                <th>Person card</th>
                <th>Country</th>
                <th>Company</th>
            </tr>
            </thead>
        </table>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>

</script>

<script>

     $(document).ready(function(){
        // DataTable
        'use-strict'
        var id = 0;
        all_load_data(id)

        $('#companyName').on('change', function() {
            var company_id = $(this).val();
            var employee_type = $('#employeeType').val();
            $('table.data_table_cls').DataTable().destroy();
            all_load_data(company_id, employee_type);
        });

        $('#employeeType').on('change', function() {
            var employee_type = $(this).val();
            var company_id = $('#companyName').val();
            $('table.data_table_cls').DataTable().destroy();
            all_load_data(company_id, employee_type);
        });


        function all_load_data(company_id, employee_type){
            $('table.data_table_cls').DataTable({
            processing: true,
            language:{
                processing: '<img src="{{asset('assets/images/load-gif.gif')}}">'
            },
            serverSide: false,
            retrieve: true,
            ajax:{
                url : "{{route('wps-get-employee-details')}}",
                data:{company_id: company_id, employee_type: employee_type},
            },
            columns: [
                { data: 'full_name' },
                { data: 'passport_no' },
                { data: 'pp_uid' },
                { data: 'zds_code' },
                { data: 'visa_number' },
                { data: 'card_no' },
                { data: 'mb_no' },
                { data: 'labour_card_no' },
                { data: 'person_code' },
                { data: 'country' },
                { data: 'name' },
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
                    title: 'WPS Employee Details',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
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
    });

</script>

@endsection
