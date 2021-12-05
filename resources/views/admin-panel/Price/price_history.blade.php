@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Price</a></li>
            <li>Price History</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div  class="row row3">
        <div class="col-md-1"> </div>
           <div class="col-md-10">
             <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Price History</h4>
                    <div class="table-responsive">
                        <table  id="datatable" class="table table-sm table-hover table-striped text-11 data_table_cls " >
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Serial No</th>
                                <th scope="col">Part Name</th>
                                <th scope="col">Part Number</th>
                                <th scope="col">Price</th>
                                <th scope="col">Date From</th>
                                <th scope="col">Date To </th>
                                <th scope="col">Source </th>
                                <th scope="col">Added By</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $count =1; ?>
                            @foreach($price_history   as $row)
                                <tr>
                                    <th scope="row">{{$count}}</th>
                                    <td>{{$row->parts->part_name}}</td>
                                    <td>{{$row->parts->part_number}}</td>
                                    <td>{{$row->price}}</td>
                                    <td>{{$row->date_from}}</td>
                                    <td>{{$row->date_to}}</td>
                                    <td>
                                        @if($row->source=='0')
                                        <span class="badge badge-primary font-weight-bold m-2">New Price Added</span>
                                        @else
                                        <span class="badge badge-success font-weight-bold m-2">Price Edited</span>
                                        @endif
                                    </td>
                                    <td>{{$row->users->name}}</td>
                                </tr>
                                <?php $count = $count+1; ?>
                            @endforeach
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-1"> </div>
      </div>
    </div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>

        $('#datatable').DataTable( {
                    "aaSorting": [[0, 'desc']],
                    "pageLength": 5,
                    "columnDefs": [
                        {"targets": [0],"visible": true},
                    ],
                    "scrollY": false,
                });
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


@endsection
