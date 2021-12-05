@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .btn-upload {
            margin-top: 23px;
        }
        th {
            white-space: nowrap;
            font-size: 13px;
        }
        td {
            white-space: nowrap;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Labour Existing Data</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">













        <div class="row">

            <div class="col-md-12 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                        <h4>Existing System List</h4>
                        <div class="table-responsive">

                            <table class="table" id="datatable3" class="cell-border" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Person Code</th>
                                    <th scope="col">Labour Card</th>
                                    <th scope="col">Person Name</th>
                                    <th scope="col">Passport</th>
                                    <th scope="col">Nationality</th>
                                    <th scope="col">Labour Card Expiry</th>
                                    <th scope="col">Card Type</th>
                                    <th scope="col">Job</th>

                                </tr>
                                </thead>
                                <tbody>


                                @foreach($approval_electronics_exist as $person_exist)


                                    <tr>
                                        <td>{{ $person_exist['person_code']  }}</td>
                                        <td>{{ $person_exist['labour_card_no']  }}</td>
                                        <td>{{$person_exist['person_name']}}</td>
                                        <td>{{$person_exist['passport_number']}}</td>
                                        <td>{{$person_exist['nation']}}</td>
                                        <td>{{$person_exist['expiry_date']}}</td>
                                        <td>{{$person_exist['card_type']}}</td>
                                        <td>{{$person_exist['job']}}</td>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable,#datatable1,#datatable3,#datatable4').DataTable( {

                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "30%"}
                ],


                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [

                    {
                        extend: 'excel',
                        title: 'Labour Uploads',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },

                ],

                // select: true,
                "scrollY": false,
                "scrollX": true
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
        //-----------Download sample divs------------------
    </script>
    @if(isset($gamer_exist))
        <script>
            $(document).ready(function() {


                var style_name = "<?php echo isset($counter_name); ?>";
                var style_pass = "<?php echo isset($counter_pass); ?>";
                var style_person = "<?php echo isset($counter_person) ; ?>";
                var $style_nation = "<?php echo isset($counter_nation); ?>";
                var $style_expiry = "<?php echo isset($counter_expiry) ; ?>";
                var $style_card_type = "<?php echo isset($counter_card); ?>";
                // alert(style_name)



                if (style_name>=1){
                    $("#person_name").css("background", "#ef0000");
                }


                if (style_pass>=1){
                    $("#passport").css("background", "#ef0000");
                }



                if (style_person>=1){
                    $("#person_code").css("background", "#ef0000");
                }



                if ($style_nation>=1){
                    $("#nationality").css("background", "#ef0000");
                }

                if ($style_expiry >=1){
                    $("#labour_card_expiry").css("background", "#ef0000");
                }



                if ($style_card_type>=1){
                    $("#card_type").css("background", "#ef0000");
                }



            });

        </script>
    @endif
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

    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endsection
