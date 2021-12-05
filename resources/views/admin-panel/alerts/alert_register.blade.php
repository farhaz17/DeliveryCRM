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
            <li><a href="">Alerts</a></li>
            <li>Registration</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-sm" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{ route('manage_alerts.store') }}">
                    {!! csrf_field() !!}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select Status</label>

                                <select id="status" name="status" class="form-control form-control-rounded" required >
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="1">Solved</option>
                                    <option value="0">Not Solved</option>
                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    status update modal end--}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#not_solved" role="tab" aria-controls="not_solved" aria-selected="true">Not Solved ({{ $alerts->count() }})</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#solved" role="tab" aria-controls="solved" aria-selected="false">Solved ({{ $alerts_solved->count() }})</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="not_solved" role="tabpanel" aria-labelledby="home-basic-tab">
                        <div class="table-responsive">
                            <table class="table" id="datatable_not_solved">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">zds_code</th>
                                    <th scope="col">passport</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alerts as $alert)
                                    <tr>
                                        <th scope="row">1</th>
                                        <th>{{$alert->name}}</th>
                                        <td>{{$alert->email}}</td>
                                        <td>{{$alert->phone}}</td>
                                        <td>{{$alert->zds_code}}</td>
                                        <td>{{$alert->passport}}</td>
                                        <td>{{$alert->message}}</td>
                                        <td>{{ ($alert->status=="0") ? 'Not Solved' : "Solved" }}</td>
                                        <td>
                                            @if($alert->status=="0")
                                                <a class="text-success mr-2 edit_cls" id="{{ $alert->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            @else
                                                &nbsp;
                                            @endif
                                        </td>
                                    </tr>



                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="profile-basic-tab">

                        <div class="table-responsive">
                            <table class="table" id="datatable_solved">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">zds_code</th>
                                    <th scope="col">passport</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($alerts_solved as $alert)
                                    <tr>
                                        <th scope="row">1</th>
                                        <th>{{$alert->name}}</th>
                                        <td>{{$alert->email}}</td>
                                        <td>{{$alert->phone}}</td>
                                        <td>{{$alert->zds_code}}</td>
                                        <td>{{$alert->passport}}</td>
                                        <td>{{$alert->message}}</td>
                                        <td>{{ ($alert->status=="0") ? 'Not Solved' : "Solved" }}</td>
                                        <td>
                                            @if($alert->status=="0")
                                                <a class="text-success mr-2 edit_cls" id="{{ $alert->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            @else
                                               &nbsp;
                                            @endif
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

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable_not_solved, #datatable_solved').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                // "scrollY": false,

            });
        });

    </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');


                var table = $('#datatable_'+split_ab[1]).DataTable();
                $('#container').css( 'display', 'block' );
                $('#datatable_solved').css( 'width', '100%' );
                table.columns.adjust().draw();
            }) ;
        });
   </script>


    <script>
        $('tbody').on('click', '.edit_cls', function() {
            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);
            $("#edit_modal").modal('show');
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
