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
            <li>Attachment Types</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4" style="background: #dedede">
                <div class="card-body">
                    <div class="card-title mb-3">Attachment Types</div>

                    <form method="post" action="{{isset($edit_attach)?route('attachment_update',$edit_attach->id):route('attachment_store')}}">
                        {!! csrf_field() !!}
                        @if(isset($edit_attach))
                            {{ method_field('GET') }}
                        @endif

                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Attachment Type</label>
                                <input class="form-control form-control-rounded" value="{{isset($edit_attach->name)?$edit_attach->name:""}}" id="attachment_type" name="attachment_type"  type="text" placeholder="Enter the main category name"  />

                            </div>
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

                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered" style="width: 100%" id="datatable2" >
                                <thead class="thead-dark" style="width: 100%">
                                <tr>

                                    <th scope="col">Attachement</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($attachment as $attach)
                                    <tr>
                                        <td>{{$attach->name}}</td>
                                        <td>
                                          <a class="text-success mr-2" href="{{route('attachment_edit',$attach->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

            });

            'use strict';

            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

            });
        });
    </script>

    <script>


        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;

                if(split_ab=="home-basic-tab"){
                    var ab_table = $('#datatable').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var ab_table = $('#datatale2').DataTable();
                    ab_table.destroy();
                    var table = $('#datatale2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }


            }) ;
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
