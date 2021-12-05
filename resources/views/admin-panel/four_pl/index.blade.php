@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>4PL</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">4Pl  Details</div>
                    <form method="post" action="{{isset($fourpl_edit)?route('four_pl.update',$fourpl_edit->id):route('four_pl.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($fourpl_edit))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">4PL Type</label>
                                <select id="platform_category" name="pl_typle" class="form-control cls_card_type">
                                    <option value="" selected disabled>Select option</option>
                                    <option value="1">4PL Company</option>
                                    <option value="2">4PL Agent</option>
                                </select>

                            </div>


                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control" required id="name" name="name" value="{{isset($fourpl_edit)?$fourpl_edit->name:""}}" type="text" placeholder="Enter name" />

                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Phone/Mobile Number</label>
                                <input class="form-control" required id="phone_number" name="phone_number" value="{{isset($fourpl_edit)?$fourpl_edit->phone_number:""}}" type="text" placeholder="Enter Phone/Mobile Number" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">4PL Code</label>
                                <input class="form-control" required id="four_pl_code" name="four_pl_code" value="{{isset($fourpl_edit)?$fourpl_edit->four_pl_code:""}}" type="text" placeholder="Enter 4PL Code" />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Email</label>
                                <input class="form-control" required id="email" name="email" value="{{isset($fourpl_edit)?$fourpl_edit->email:""}}" type="text" placeholder="Enter Email" />
                            </div>

{{--                            <div class="col-md-6 form-group mb-3">--}}
{{--                                <label for="repair_category">Password</label>--}}
{{--                                <input class="form-control" required id="password" name="password" value="" type="text" placeholder="Enter Password" />--}}
{{--                            </div>--}}


                            <!---------------------------------------------------------------------->

                            <!----------------------------------------------->

{{--                            <div class="col-md-12 form-group mb-3">--}}

{{--                                <h4 class="card-title mb-3">4 PL Company Rate</h4>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 1</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 2</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 3</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off" >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 4</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off"  >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 5</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off" >--}}
{{--                            </div>--}}

                            <!---------------------------------------------->


                            <!---------------------------------------------------------------------->

                            <!----------------------------------------------->

{{--                            <div class="col-md-12 form-group mb-3">--}}

{{--                                <h4 class="card-title mb-3">4 PL Rider Rate</h4>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 1</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 2</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 3</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off" >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 4</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off"  >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-4 form-group mb-3">--}}

{{--                                <input type="hidden" class="form-control"  name="platform_name"  id="platform_search">--}}
{{--                                <label for="repair_category">Field 5</label>--}}
{{--                                <input type="text" class="form-control"  name="date_from" id="date_from_search"  autocomplete="off" >--}}
{{--                            </div>--}}

                            <!---------------------------------------------->

                            <div class="col-md-12">
                                <button class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Company</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Agent</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable" width="100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Type</th>
                            <th scope="col">Name</th>
                            <th scope="col">email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">4PL Code</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($fourpl as $row)
                            <tr>
                                    <td>Company</td>
                                <td>
                                    {{$row->name ? $row->name : 'N/A' }}
                                </td>
                                <td>
                                    {{$row->email ? $row->email : 'N/A' }}
                                </td>
                                    <td>
                                    {{$row->phone_no}}
                                </td>
                                    <td>
                                    {{$row->request_no}}
                                </td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('four_pl.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
             </div>
                    <!---------------------tab1 ends here-------------->
                    <!---------------------tab2-------------->

                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" id="datatable2" width="100%">
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Type</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">4PL Code</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fourpl_agent as $row)
                                    <tr>
                                        <td>Agent</td>

                                        <td>
                                            {{$row->name ? $row->name : 'N/A' }}
                                        </td>
                                        <td>
                                            {{$row->email ? $row->email : 'N/A' }}
                                        </td>
                                        <td>
                                            {{$row->phone_no}}
                                        </td>
                                        <td>
                                            {{$row->four_pl_code}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!---------------------tab2 ends here-------------->
                </div>





            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

        <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "sScrollX": "100%",
                "scrollX": true
            });
        });
    </script>
        <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }

                else{
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
        });

    </script>
        {{--function deleteData(id)--}}
        {{--{--}}
        {{--var id = id;--}}
        {{--var url = '{{ route('parts.destroy', ":id") }}';--}}
        {{--url = url.replace(':id', id);--}}
        {{--$("#deleteForm").attr('action', url);--}}
        {{--}--}}

        {{--function deleteSubmit()--}}
        {{--{--}}
        {{--$("#deleteForm").submit();--}}
        {{--}--}}
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
