@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
         #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 2px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }

        </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Jobs</a></li>
            <li>Create Job</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">

        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title mb-3">Jobs List</h4>
                <div class="table-responsive">
                    <table class="table table-stripped" id="datatable2">
                        <thead>
                            <tr>
                                <th scope="col">Reference #</th>
                                <th scope="col">Applied For</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Education</th>
                                <th scope="col">Last Company</th>
                                <th scope="col">CV</th>
                                <th scope="col">Cover Letter</th>
                                <th scope="col">Comments</th>
                                <th scope="col">Questions</th>
                                <th scope="col">References</th>
                                <th scope="col">Applied Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($applicants as $row)
                            <tr>
                                <td>{{isset($row->jobs_created->refrence_no)?$row->jobs_created->refrence_no:"N/A"}}</td>
                                <td>{{isset($row->jobs_created->job_title)?$row->jobs_created->job_title:"N/A"}}</td>
                                <td>{{isset($row->first_name)?$row->first_name:"N/A"}} {{isset($row->last_name)?$row->last_name:""}}</td>
                                <td>{{isset($row->email_address)?$row->email_address:"N/A"}}</td>
                                <td>{{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                                <td>{{isset($row->education)?$row->education:"N/A"}}</td>
                                <td>{{isset($row->last_company)?$row->last_company:"N/A"}}</td>

                                <td>
                                    @if (isset($row->cv))

                                    <a class="btn btn-primary btn-file2 mb-4 text-white" href="{{Storage::temporaryUrl($row->cv, now()->addMinutes(5))}}"  target="_blank">
                                        <strong style="color: #000000"> <i class="text-15 text-white  i-Download"></i></strong>
                                    </a>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-info"
                                    onclick="viewJobCoverLetter({{$row->id}})" type="button">
                                    <i class="text-15  i-Mail-2"></i>
                                    </button>
                                </td>
                                <td>
                                    <button class="btn btn-warning"
                                    onclick="viewJobComments({{$row->id}})" type="button">
                                    <i class="text-15  i-Align-Justify-All

                                    "></i>
                                    </button>
                                </td>

                                <td>

                                    <button class="btn btn-success"
                                    onclick="viewJobQuestions({{$row->id}})" type="button">
                                    <i class="text-15  i-Speach-Bubble-Asking"></i>
                                    </button>

                                </td>

                                <td> <button class="btn btn-dark"
                                    onclick="viewJobRef({{$row->id}})" type="button">
                                    <i class="text-15  i-Business-Mens"></i>
                                    </button>
                                </td>
                                <td>{{isset($row->created_at)?$row->created_at:"N/A"}}</td>


                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>







            </div>

{{-- -------------- visa process modals----------------- --}}

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row_show_offer">


            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- -------------- visa process modals ends here----------------- --}}








@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>




    <script>
        function viewJobComments(id)
            {
                var id=id;
                var token = $("input[name='_token']").val();
                $.ajax({
                            url: "{{ route('get_app_comments') }}",
                            method: 'POST',
                            dataType: 'json',
                            data:{id:id,_token:token},
                            beforeSend: function () {
                                $("body").addClass("loading");
                        },
                            success: function (response) {
                                $('.row_show_offer').empty();
                                $("body").removeClass("loading");
                                $('.row_show_offer').append(response.html);
                                $('.bd-example-modal-lg').modal('show');
                            }
                        });
            }
    </script>
        <script>
            function viewJobCoverLetter(id)
                {
                    var id=id;
                    var token = $("input[name='_token']").val();
                    $.ajax({
                                url: "{{ route('get_app_cover_letter') }}",
                                method: 'POST',
                                dataType: 'json',
                                data:{id:id,_token:token},
                                beforeSend: function () {
                                    $("body").addClass("loading");
                            },
                                success: function (response) {
                                    $('.row_show_offer').empty();
                                    $("body").removeClass("loading");
                                    $('.row_show_offer').append(response.html);
                                    $('.bd-example-modal-lg').modal('show');
                                }
                            });
                }
        </script>


<script>
    function viewJobQuestions(id)
        {
            var id=id;
            var token = $("input[name='_token']").val();
            $.ajax({
                        url: "{{ route('get_app_question') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{id:id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('.row_show_offer').empty();
                            $("body").removeClass("loading");
                            $('.row_show_offer').append(response.html);
                            $('.bd-example-modal-lg').modal('show');
                        }
                    });
        }
</script>

<script>
    function viewJobRef(id)
        {
            var id=id;
            var token = $("input[name='_token']").val();
            $.ajax({
                        url: "{{ route('get_app_ref') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{id:id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('.row_show_offer').empty();
                            $("body").removeClass("loading");
                            $('.row_show_offer').append(response.html);
                            $('.bd-example-modal-lg').modal('show');
                        }
                    });
        }
</script>







<script>
    $(document).ready(function () {
        'use strict';

        $('#datatable2').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                // {"targets": [0],"visible": true},

            ],
            "scrollY": false,
            "scrollX": false,



        });

    });

</script>

{{-- <script>
       $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 15,
                "columnDefs": [
                    {"targets": [0],"visible": true},


                ],
                language: { search: "" ,
                searchPlaceholder: "Search....."},
                "scrollY": true,
                "scrollX": true,
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                    responsive: true

            });


        });
</script> --}}

<script>
     $('#company').select2({
        placeholder: 'Select an option'
    });
    $('#state').select2({
        placeholder: 'Select an option'
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
