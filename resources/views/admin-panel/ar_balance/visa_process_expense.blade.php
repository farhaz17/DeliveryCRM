@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        button.btn.btn-primary.btn-sub {
            height: 33px;
            margin-top: 28px;
        }
        a.dropdown-item {
            width: 1000px;
        }
        .card1 {
            height: 290px;
            margin-bottom: 25px;
        }
        .card.card2 {
            height: 410px;
            margin-bottom: 10px;
        }
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
        }
        #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
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
    .dataTableLayout {
        table-layout:fixed;

        button.btn.btn-primary.visa_submti {
    height: 28px;
    padding-top: 3px;
}
button.btn.btn-primary.visa_submti {
    height: 30px;
}


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Ar Balance</a></li>
            <li>Visa Process Expenses</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <!-----------------------------balance add and substract--------------->

    <div class="col-md-12">
        <div class="card card2">
            <div class="card-body">
                <div>
                    <label for="repair_category">Search</label>
                </div>
                <div class="input-group ">


                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                    <input class="form-control typeahead" id="keyword" autocomplete="off" type="text"  placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>

                </div>
            </div>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <div class="row">
            <div class="col-md-1"></div>
        <div class="col-md-10  form-group mb-3">
            <div  style="display: none" id="all-row">
            </div>
        </div>
        <div class="col-md-1"></div>
    </div>

    <!-----------------------------Ends here-----------   balance add and substract Ends here--------------->


















@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>


    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {

                    return process(data);
                });
            },
            highlighter: function (item, data) {
                var parts = item.split('#'),
                    html = '<div class="row drop-row">';
                if (data.type == 0) {
                    html += '<div class="col-lg-12 sugg-drop">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }

                return html;
            }
        });
    </script>

{{-- 22222222222222222222222 --}}

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead2').typeahead({
        source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {

                return process(data);
            });
        },
        highlighter: function (item, data) {
            var parts = item.split('#'),
                html = '<div class="row drop-row">';
            if (data.type == 0) {
                html += '<div class="col-lg-12 sugg-drop2">';
                html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                html += '<div><br></div>';
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type == 1){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }  else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==3){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==4){
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==5)
            {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==6) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==7) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==8) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==9) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==10) {
                html += '<div class="col-lg-12 sugg-drop2" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }

            return html;
        }
    });
</script>

<script>
    $(document).on('click', '.sugg-drop', function(){

        var passport_no  =   $(this).find('#drop-name').text();
        $('input[name=passport_number]').val(passport_no);


    });
    </script>
    <script>
        $(document).on('click', '.sugg-drop2', function(){

            var passport_no  =   $(this).find('#drop-name').text();
            $('input[name=passport_number]').val(passport_no);


        });
        </script>
    <script>


        $(document).ready(function () {
            'use strict';

            $('#datatable,#datatable3').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Date Between A/R Balance',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'

                            }

                        }
                    },
                    'pageLength',
                ],
                "columnDefs": [
                    {"targets": [0],"visible": true},
                ],
                "scrollY": true,
                "scrollX": true,
            });

        });

    </script>
            <script>
                $('#platform_id-1').select2({
                    placeholder: 'Select an option'
                });

                $('#platform_id-2').select2({
                    placeholder: 'Select an option'
                });

                $('#zds_code_balance_id').select2({
                    placeholder: 'Select an option'
                });

                $('#zds_code_user2').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_search').select2({
                    placeholder: 'Select an option'
                });
                $('#platform_id_search_user').select2({
                    placeholder: 'Select an option'
                });
                $('#zds_code_user').select2({
                    placeholder: 'Select an option'
                });
                $('#seeder_value').select2({
                    placeholder: 'Select an option'
                });
                $('#seeder_value2').select2({
                    placeholder: 'Select an option'
                });

            </script>

    <script>
        $(document).on('click', '.sugg-drop', function() {
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();
            $.ajax({
                url: "{{ route('ar_balance_visa_expense') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token,keyword:keyword},
                beforeSend: function () {
                    $(".loading_msg").show();
                },
                success: function (response) {
                    $('#all-row').empty();
                    $('#search_between').empty();
                    $('#search_user').empty();
                    $('#all-row').append(response.html);
                    $('#all-row').show();
                    $('#ar_balance_div').show();

                    $(".loading_msg").hide();

                }
            });
        })
    </script>

<script>
    $(document).on('click', '.sugg-drop2', function() {
        var token = $("input[name='_token']").val();
        var keyword  =   $(this).find('#drop-name').text();
        $.ajax({
            url: "{{ route('assigning_detail') }}",
            method: 'POST',
            dataType: 'json',
            data:{_token:token,keyword:keyword},
            beforeSend: function () {
                $(".loading_msg").show();
            },
            success: function (response) {
                $('.assign_info').empty();
                $('#visa_steps_show').empty();
                $('.assign_info').append(response.html);
                $('#visa_steps_show').append(response.html2);



                console.log(response.process_array);
                $(".loading_msg").hide();

            }
        });
    })
</script>

<script>

// $(document).ready(function(e) {
//     $("#myOption").change(function(){
//         var textval = $(":selected",this).val();
//         $('input[name=text]').val(textval);
//     })
// });


</script>
{{--    </script>--}}



    <script>
            $("#btn_date_search").click(function(){

                var date_from_search = $("#date_from_search").val();
                var date_to_search = $("#date_to_search").val();
                var platform_id_search = $("#platform_id_search").val();
                var token = $("input[name='_token']").val();

                // if (date_from_search != '' && date_to_search != ''){
                    $.ajax({
                        url: "{{ route('ar_balance_between_search') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{date_from_search:date_from_search,date_to_search:date_to_search,_token:token,platform_id_search:platform_id_search},
                        beforeSend: function () {
                            $(".loading_msg").show();
                        },
                        success: function (response) {
                            $('#search_suer').empty();
                            $('#all-row').empty();
                            $('#search_between').empty();
                            $('#search_between').append(response.html);
                            $('#search_between').show();
                            $(".loading_msg").hide();
                        }
                    });
                // }
                // else{
                //     toastr.error("Please select both options");
                // }




            });
    </script>




    <script>
        $("#btn_date_user").click(function(){
            var passport_number = $("#passport_number").val();
            var date_from_user = $("#date_from_user").val();
            var date_to_user = $("#date_to_user").val();
            var token = $("input[name='_token']").val();



            if (date_from_user != '' && date_to_user != '' && passport_number != ''){

            $.ajax({
                url: "{{ route('ar_balance_between_user') }}",
                method: 'POST',
                dataType: 'json',
                data:{date_from_user:date_from_user,date_to_user:date_to_user,_token:token,passport_number:passport_number},
                beforeSend: function () {
                    $(".loading_msg").show();
                },

                success: function (response) {
                    $('#search_user').empty();
                    $('#all-row').empty();
                    $('#search_between').empty();
                    $('#search_user').append(response.html);
                    $('#search_user').show();
                    $(".loading_msg").hide();
                }
            });
            }
            else{
                toastr.error("Please select all options");
            }
        });
    </script>




    <script>
        $(document).on('click','.edit_ar_bal', function(){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ar_balance_sheet_edit') }}",
                method: 'POST',
                dataType: 'json',
                data:{id:id,_token:token},
                success: function (response) {
                    $('.edit-row').empty();
                    $("#bike_checkout").modal('hide')
                    $('.edit-row').append(response.html);
                    $('.edit-row').show();
                    $(".ar_balance_edit").modal('show')
                }
            });
        });
    </script>

    <script>

$(document).ready(function(){
    $('input[type="radio"]').click(function(){
        if($('input:radio[type="radio"]:checked').val() == "1"){

        $('#amount_status').show();
        $('#paying_options').hide();
        $('#step_to_pay').hide();

    }
    else{
        // $('#partial_amount_div').show();
        $('#amount_status').hide();
        $('#paying_options').show();
        $('#step_to_pay_partial_payment').hide();
        $('#gridCheck1').prop('checked', false);

        // $('#partial_amount').hide();
        // $('#remarks_status').show();
    }
    });
});
    </script>

    <script>
        $(document).ready(function(){
    $('input[name="pay_option"]').click(function(){
        if($('input:radio[name="pay_option"]:checked').val() == "1"){
        $('#step_to_pay').show();
        $('#remarks_status').show();}
    else{
        $('#step_to_pay').hide();

        $('#remarks_status').show();}});
});
    </script>

<script>
    $(document).ready(function(){
$('input[name="pay_option_partial"]').click(function(){
    if($('input:radio[name="pay_option_partial"]:checked').val() == "1"){
    $('#step_to_pay_partial_payment').show();
    $('#partial_amount').show();
    $('#remarks_status').show();
    }
else{
    $('#step_to_pay_partial_payment').hide();
    $('#partial_amount').show();
    $('#visa_step_amount_pay_at').val('')
    }});
});
</script>

     <script>
    $(document).ready(function (e){
    $("#visa_amount_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('add_assigning_amount') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#visa_amount_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Visa Process Amount Added Successfully!", { timeOut:10000 , progressBar : true});
                    location.reload();
                }
                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                }
            },
            error: function(){}
        });
    }));
});

</script>
    <script>
        $(document).ready(function(e) {
            $("#zds_code_sub").change(function(){
                var textval = $(":selected",this).val();

                $('input[name=zds_code_balance]').val(textval);
            })
        });


    </script>


    <script>
        $('#zds_code_add').select2({
            placeholder: 'Select an option'
        });
    </script>
    <script>
        $('#rider_id').select2({
            placeholder: 'Select an option'
        });
    </script>

    <script>
        tail.DateTime("#date_save",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: "HH:ii:ss",
            position: "top"
        });

    </script>


<script>
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){


                $('#partial_amount_div').show();
            }
            else if($(this).prop("checked") == false){
                $('#partial_amount_div').hide();
                $('#payButton_partial').prop('checked', false);
                $('#payButton_partial2').prop('checked', false);
            }
        });
    });
</script>

{{-- <script>
$(document).ready(function(e) {
    $("#gridCheck1").change(function(){
        alert('asdf');
        // var textval = $(":selected",this).val();
        // $('input[name=text]').val(textval);
    })
});
</script> --}}




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
