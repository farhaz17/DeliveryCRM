@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Vendor</a></li>
        <li>Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="vendor_name">Vendor Name</label>
                        <select id="vendor_name" name="vendor_name" class="form-control vendor_name" required>
                            <option value=""  >Select option</option>
                            @foreach ($vendor_accept as $vendor_name)
                            <option value="{{$vendor_name->id}}"  >{{$vendor_name->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mt-3"><input type="date" class="form-control" id="codDate" name="cod_date"></div>
                    <div class="col-md-3"><button class="btn btn-success mt-3 cod-btn">COD</button></div>
                </div>

                <div class="row vendor">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11 vendor_rider" id="vendor_rider" style="width:100%;">
                            <thead>
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Contact Official</th>
                                <th scope="col">Contact Personal</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Vendor</th>
                                <th scope="col">PP UID</th>
                                <th scope="col">Checkin Date</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <div class="row cod" style="display:none">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11 cod-fourpl" id="codFourpl" style="width:100%;">
                            <thead>
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Contact Personal</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Vendor</th>
                                <th scope="col">PP UID</th>
                                <th scope="col">Checkin Date</th>
                                <th scope="col">Status</th>
                                <th scope="col">Previous Day Pending</th>
                                <th scope="col">Cash Depsoit</th>
                                <th scope="col">Previous Day Balance</th>
                                <th scope="col">Current Day COD</th>
                                <th scope="col">Current Day Balance</th>
                                <th scope="col">COD Date</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function () {
            load_data();
            'use strict';
            $(".vendor").show();
            $(".cod").hide();
            $('.vendor_name').on('change',function(){
                var id = $(this).val();
                $('.vendor_rider').DataTable().destroy();
                load_data(id);
            });

            function load_data(id){
                $(".vendor").show();
                $(".cod").hide();
            $('.vendor_rider').DataTable( {
                ajax:{
                    url : "{{ route('ajax_vendor_rider') }}",
                    data:{id: id},
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                columns: [
                    { data: 'rider_first_name' },
                    { data: 'rider_last_name' },
                    { data: 'contacts_email' },
                    { data: 'contact_official' },
                    { data: 'contacts_personal' },
                    { data: 'passport_no' },
                    { data: 'vendor' },
                    { data: 'pp_uid' },
                    { data: 'checkin' },
                    { data: 'status' },
                ],
                pageLength: 10,
            });
            }
        });

        $('.vendor_name').select2({
            placeholder: 'Select an option'
        });

        $(document).on("click", ".cod-btn", function () {
            if($('.vendor_name').val())
                var id = $('.vendor_name').val();
            else
                var id = 0

            if($('#codDate').val())
                var codDate = $('#codDate').val();
            else
                var codDate = 0

                console.log($('#codDate').val())
            $(".vendor").hide();

            $('.cod-fourpl').DataTable().destroy();
            $('.cod-fourpl').DataTable( {
                ajax:{
                    url : "{{ route('ajax_vendor_rider_cod') }}",
                    data:{id: id, date:codDate},
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                columns: [
                    { data: 'rider_first_name' },
                    { data: 'rider_last_name' },
                    { data: 'contacts_personal' },
                    { data: 'passport_no' },
                    { data: 'vendor' },
                    { data: 'pp_uid' },
                    { data: 'checkin' },
                    { data: 'status' },
                    { data: 'previous_day_pending' },
                    { data: 'current_day_cash_deposit' },
                    { data: 'previous_day_balance' },
                    { data: 'current_day_cod' },
                    { data: 'current_day_balance' },
                    { data: 'start_date' },
                ],
                pageLength: 10,
            });
            $(".cod").show();
        });
    </script>
@endsection
