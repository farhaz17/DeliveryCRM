@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css">

    <style>
        @media print {
            p.bodyText {font-family:georgia, times, serif;}
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Purchase Detail</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Select Dates For Report</div>
                    <form method="post" enctype="multipart/form-data" action="{{url('search_report')}}">
                        {{csrf_field()}}
                        {{ method_field('POST') }}
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text">From</span></div>
                            <input class="form-control" name='from' type="Date"  />
                            <div class="input-group-prepend"><span class="input-group-text">To</span></div>
                            <input class="form-control" name='to' type="Date" />
                            <div class="input-group-append"><button class="btn btn-primary">Search</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
{{--                <input type='button' id='btn' value='Print' onclick='printDiv();'>--}}
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
{{--                            <th scope="col">#</th>--}}
                            <th scope="col">Part Number</th>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Part Name</th>
                            <th scope="col">Part Description</th>
                            <th scope="col">Part Quantity</th>
                            <th scope="col">Amount</th>
                            <th scope="col">VAT</th>
                            <th scope="col">Final Amount</th>

                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($result))
                        @foreach($result as $row)
                            <div style="display: none">
                            {{$final_amount=$row->amount+$row->vat }}
                            </div>
                                <tr>

                                <td> {{$row->part_number}}</td>
                                <td>{{$row->invoice_number}}</td>
                                <td>{{$row->part_name}}</td>
                                <td>{{$row->part_des}}</td>
                                <td>{{$row->part_qty}}</td>
                                <td>{{$row->amount}}</td>
                                <td>{{$row->vat}}</td>
                                <td>{{$final_amount}}</td>

                            </tr>
                          @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        Are you sure want to delete the data?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    {"targets": [1][2],"width": "30%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'
                ],


                "scrollY": false,
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });




        });




        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }


    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>


{{--    <script !src="">--}}

{{--        function printDiv()--}}
{{--        {--}}

{{--            var divToPrint=document.getElementById('datatable');--}}

{{--            var newWin=window.open('','Print-Window');--}}

{{--            newWin.document.open();--}}

{{--            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');--}}

{{--            newWin.document.close();--}}

{{--            setTimeout(function(){newWin.close();},10);--}}

{{--        }--}}
{{--    </script>--}}
@endsection
