@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .label_caption{
            font-weight: 700;
            color : #000000 !important;
        }
        .color_block{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">DC List</a></li>
            <li>DC</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row">
        <div class="col-md-12">
            <div class="card mb-0">
                <div class="card-body">
                    @if($type=="absent_dc_rider")
                        <div class="card-title mb-3">TODAY ABSENT RIDER OF DC</div>
                    @elseif($type=="dc_rider")
                        <div class="card-title mb-3">DC LIST</div>
                    @else
                        <div class="card-title mb-3">Without DC LIST</div>
                    @endif


                </div>
            </div>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">



                    <div class="table-responsive">
                        <form action="{{ route('assign_to_dc.store') }}" method="POST">
                            @csrf
                            <input type="hidden" value="" id="select_platform" name="select_platform" >
                            <input type="hidden" value="" id="select_quantity" name="select_quantity" >
                            <input type="hidden" value="" id="select_dc_id" name="select_dc_id" >
                            <table class="display table table-sm table-striped table-bordered" id="datatable">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Rider Name</th>
                                    <th scope="col">Zds Code</th>
                                    <th scope="col">Passport No</th>
                                    <th scope="col">Platform Name</th>
                                    <th scope="col">DC Name</th>
                                    <th scope="col">Assign DC date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($assign_to_dc as $user)
                                    <tr>
                                        <td>{{ $user->passport->personal_info->full_name }}</td>
                                        <td>{{ isset($user->passport->rider_zds_code->zds_code) ? $user->passport->rider_zds_code->zds_code : 'N/A' }}</td>
                                        <td>{{ $user->passport->passport_no }}</td>
                                        <td>{{ $user->platform->name }}</td>
                                        <td>{{ $user->user_detail->name }}</td>
                                        <td>{{ $user->created_at }}</td>
                                        <td><a href="{{ route('profile.index') }}?passport_id={{ $user->passport->passport_no }}" target="_blank">see profile</a></td>
                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>


    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
        function ajax_table_load(){

            var token = $("input[name='_token']").val();
            var platform_id = $("#platform_id").val();
            var user_id = $("#dc_id").val();
            var quantity = $("#quantity").val();


            $.ajax({
                url: "{{ route('display_rider_list') }}",
                method: 'POST',
                data: {_token:token,platform_id:platform_id,quantity:quantity,user_id:user_id},
                success: function(response) {

                    $('#datatable tbody').empty();
                    $('#datatable tbody').append(response.html);


                }
            });

        }
    </script>


    <script>

        $("#btn_display").click(function(){

            var platform = $("#platform_id").val();
            var dc_id = $("#dc_id").val();
            var quantity = $("#quantity").val();


            $("#select_platform").val(platform);
            $("#select_quantity").val(quantity);
            $("#select_dc_id").val(dc_id);

            if(platform != '' &&  quantity != '' && dc_id != '')
            {
                // $('#datatable').DataTable().destroy();
                ajax_table_load();

            }
            else
            {
                tostr_display("error","Both field is required");
            }

        });
    </script>

    <script>

        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });



    </script>




    <script>
        $(document).ready(function () {

            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 25,
                "columnDefs": [
                    {"targets": [0][0],"width": "30%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'DC Riders',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
            });



            $("#dc_id").change(function () {

                var user_id = $(this).val();
                var token = $("input[name='_token']").val();
                $("#platform_id").empty();
                $.ajax({
                    url: "{{ route('get_passport_checkin_platform') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {user_id: user_id, _token:token},
                    success: function(response) {
                        // $("#status_id").val(response);

                        var len = 0;
                        if(response != null){
                            len = response.length;
                        }
                        var options = "";
                        if(len > 0){
                            for(var i=0; i<len; i++){
                                add_dynamic_opton(response[i].id,response[i].name);
                            }
                        }
                    }
                });

            });

        });

    </script>






    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

    <script>
        function add_dynamic_opton(id,text_ab){



            if ($('#platform_id').find("option[value='"+id+"']").length) {
                // $('#visa_designation').val('1').trigger('change');
            } else {
                // Create a DOM Option and pre-select by default
                var newOption = new Option(text_ab, id, true, true);
                // Append it to the select
                $('#platform_id').append(newOption);
            }
            $('#platform_id').val(null).trigger('change');
        }
    </script>

    <script>

        // $('#card_no').simpleMask({
        //     'mask': ['###-####-#######-#','#####-####']
        // });
        $(function() {
            $('#card_no').inputmask("***-****-*******-*",{
                placeholder:"X",
                clearMaskOnLostFocus: false
            });
        });


    </script>





    <script>
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }

        }
    </script>

@endsection
