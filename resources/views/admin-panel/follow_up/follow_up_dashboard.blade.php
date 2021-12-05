@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>

        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')


    {{-- --------------------tickets---------------------}}
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Business-Mens"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Query Received</p>
                        <p class="text-primary text-24 line-height-1 mb-2">{{ $total_query_received }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Conference"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Followed</p>
                        <p class="text-primary text-24 line-height-1 mb-2">0020</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">
                <div class="card-body text-center"><i class="i-Find-User"></i>
                    <div class="content">
                        <p class="text-muted mt-2 mb-0">Total Remain Followup</p>
                        <p class="text-primary text-24 line-height-1 mb-2">100</p>
                    </div>
                </div>
            </div>
        </div>

{{--        <div class="col-lg-3 col-md-6 col-sm-6">--}}
{{--            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4">--}}
{{--                <div class="card-body text-center"><i class="i-University1"></i>--}}
{{--                    <div class="content">--}}
{{--                        <p class="text-muted mt-2 mb-0">Total Received in Bank</p>--}}
{{--                        <p class="text-primary text-24 line-height-1 mb-2"> 145800</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>






















    <!--------Companny employee detail modal------------->
    <div class="col-md-12">
        <div class="modal fade" id="emp_modal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Company Employees Detail</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12 form-group mb-3 " id="emp_div">


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------Companny employee detail modal Ends------------->

    <!--------Companny employee detail modal------------->
    <div class="col-md-12">
        <div class="modal fade" id="emp_detail" style="z-index: 9999" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Employee Details</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">

                            <div class="col-md-12 form-group mb-3 " id="emp_det">

                                <table class="table mytable" id="datatable">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Passport Number</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------Companny employee detail modal Ends------------->


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>


@endsection
