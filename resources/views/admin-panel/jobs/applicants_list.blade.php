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
    .submenu{
            display: none;
        }
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    .containter{
    display: flex;
  justify-content: center;
}
.add{
    color: #FF0000
}
#first-tab{
background: rgb(5, 5, 5);
}
.btn-s{
    padding: 1px;
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


                    <ul class="nav nav-tabs containter mt-4" id="dropdwonTab1">
                        <li class="nav-item"><a  class="nav-link active show tab-btn btn-info   text-white ml-2 mr-2 mt-1" style="padding:4px" id="first-tab" data-toggle="tab" href="#first" aria-controls="first" aria-expanded="true">New</a></li>
                        <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="second-tab" data-toggle="tab" href="#second" aria-controls="second" aria-expanded="false">Accepted</a></li>
                        <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="third-tab" data-toggle="tab" href="#third" aria-controls="third" aria-expanded="false">Rejected</a></li>

                    </ul>

                    <div class="tab-content px-1 pt-1" id="dropdwonTabContent1">
                        <div class="tab-pane active show" id="first" role="tabpanel" aria-labelledby="first-tab" aria-expanded="true">

                                        <h5><span class="badge badge-primary m-2 font-weight-bold">New Applicants</span></h5>
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
                                                <th scope="col">Action</th>
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

                                                <td>
                                                    <button class="btn btn-success btn-s btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                                                    data-target=".bd-example-modal-lg2" onclick="accept_app({{$row->id}})" id="start-{{$row->id}}"
                                                     type="button">
                                                     Accept
                                                   </button>

                                                   <button class="btn btn-danger btn-s btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                                                   data-target=".bd-example-modal-lg3" onclick="rej_app({{$row->id}})" id="start-{{$row->id}}"
                                                    type="button">
                                                    Reject
                                                  </button>
                                                </td>


                                            </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- tab1 ends here --}}
                            <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab" aria-expanded="false">
                                <h5><span class="badge badge-primary m-2 font-weight-bold">Accepted Applicants</span></h5>
                              <div class="div-2"> </div>
                            </div>
                            {{-- second tabs ends here --}}


                            <div class="tab-pane" id="third" role="tabpanel" aria-labelledby="third-tab" aria-expanded="false">
                                <h5><span class="badge badge-primary m-2 font-weight-bold">Rejected Applicants</span></h5>
                                <div class="div-3"> </div>
                            </div>

                            {{-- third tab ends here --}}






            </div>
        </div>
    </div>



            </div>
            <div class="overlay"></div>

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


 {{-- --------------------------------------------------------- --}}

 <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg2">
        <div class="modal-content">
            <form action="" id="startForm2" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Accept Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                {{-- <div class="alert alert-warning" role="alert">
                    <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                </div> --}}
                <div class="modal-body">
                    {{csrf_field()}}
                    {{method_field('GET')}}
                  <strong>
                       <h5> Are you sure to accept the application, an email will be sent to applicant?
                       </h5>
                  </strong>
                </div>



                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success ml-2" type="submit" onclick="accept_app_submit()">Accept it</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- <rejected modal> --}}

 <div class="modal fade bd-example-modal-lg3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg3">
        <div class="modal-content">
            <form action="" id="startForm3" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Rejected Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                {{-- <div class="alert alert-warning" role="alert">
                    <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                </div> --}}
                <div class="modal-body">
                    {{csrf_field()}}
                    {{method_field('GET')}}
                  <strong>
                       <h5> Are you sure to reject the application, an email will be sent to applicant?
                       </h5>
                  </strong>
                </div>



                <div class="modal-footer">
                    <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-success ml-2" type="submit" onclick="rej_app_submit()">Reject it</button>
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
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>




    <script>
        function accept_app(id)
                       {
                           var id = id;

                           var url = '{{ route('accept_app', ":id") }}';
                           url = url.replace(':id', id);
                           $("#startForm2").attr('action', url);
                       }

                       function accept_app_submit()
                       {
                           $("#startForm2").submit();
                           // alert('Deleted!!!111 Chal band kar');
                       }
    </script>


<script>
    function rej_app(id)
                   {
                       var id = id;

                       var url = '{{ route('rej_app', ":id") }}';
                       url = url.replace(':id', id);
                       $("#startForm3").attr('action', url);
                   }

                   function rej_app_submit()
                   {
                       $("#startForm3").submit();
                       // alert('Deleted!!!111 Chal band kar');
                   }
</script>


    <script>
        $(document).on('click', '#second-tab', function(){
                         var company_id='1';
                         var token = $("input[name='_token']").val();
                         $("#second-tab").css("background-color", "3663399");
                         $("#first-tab").css("background-color", "#black");
                         $("#third-tab").css("background-color", "#663399");

                         $('.div-2').empty();
                         $('.div-3').empty();


                      });
          </script>

    <script>
        $(document).on('click', '#second-tab', function(){
                         var company_id='1';
                         var token = $("input[name='_token']").val();
                         $("#second-tab").css("background-color", "black");
                         $("#first-tab").css("background-color", "#663399");
                         $("#third-tab").css("background-color", "#663399");

                          $.ajax({
                              url: "{{ route('get_accept_applicant_list') }}",
                              method: 'POST',
                              dataType: 'json',
                              data:{company_id:company_id,_token:token},
                              beforeSend: function () {
                                  $("body").addClass("loading");
                          },
                              success: function (response) {
                                $('.div-3').empty()
                                  $('.div-2').append(response.html);
                                  $('.div-2').show();
                                  $("body").removeClass("loading");
                                  var table1 = $('#datatable-2').DataTable({
                                      "autoWidth": true,
                                  });
                                  table1.columns.adjust().draw();
                              }
                          });
                      });
          </script>


<script>
    $(document).on('click', '#third-tab', function(){
                     var company_id='1';
                     var token = $("input[name='_token']").val();
                     $("#second-tab").css("background-color", "663399");
                     $("#first-tab").css("background-color", "#663399");
                     $("#third-tab").css("background-color", "black");

                      $.ajax({
                          url: "{{ route('get_reject_applicant_list') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{company_id:company_id,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                                $('.div-2').empty();
                              $('.div-3').append(response.html);
                              $('.div-3').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable-3').DataTable({
                                  "autoWidth": true,
                              });

                              table1.columns.adjust().draw();


                          }
                      });
                  });
      </script>








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
                {"targets": [0],"width": "10%"}
                {"targets": [1],"width": "10%"}
                {"targets": [2],"width": "10%"}
                {"targets": [3],"width": "10%"}
                {"targets": [4],"width": "10%"}
                {"targets": [5],"width": "10%"}
                {"targets": [6],"width": "10%"}
                {"targets": [7],"width": "10%"}
                {"targets": [8],"width": "10%"}
                {"targets": [9],"width": "10%"}
                {"targets": [10],"width": "10%"}
                {"targets": [11],"width": "10%"}
                {"targets": [12],"width": "10%"}
                {"targets": [13],"width": "10%"}
                {"targets": [14],"width": "10%"}
                {"targets": [15],"width": "10%"}

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
