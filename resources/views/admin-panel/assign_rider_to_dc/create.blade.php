@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Assign Rider to DC</a></li>
            <li>Assign Rider</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-lg" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="edit_from" action="{{ route('emirates_id_card.update',1) }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    {{ method_field('PUT') }}

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update Details</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3 append_div " >
                                <label for="repair_category">Passport </label>
                                <input type="text" class="form-control" id="passport_id_edit" name="passport_id" readonly>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Enter Id Number</label>
                                <input type="text" class="form-control" id="edit_id_number" name="edit_id_number" >
                            </div>

                        </div>

                        <div class="row ">
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Expire Date</label>
                                <input type="text" class="form-control" autocomplete="off" name="edit_expire_date" id="edit_issue_date" required>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Front Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="front_pic" id="front_pic" >
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Emirates Id Back Pic</label>
                                <input type="file" class="form-control" autocomplete="off" name="back_pic" id="back_id" >
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

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Assign Rider To DC</div>
                    <div class="row display_dc_remain_div" >
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Total DC LIMIT</label>
                            <h4 class="text-primary font-weight-bold" id="total_dc_html">0</h4>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold" >Total Rider Assigned TO DC</label>
                            <h4 class="text-info font-weight-bold" id="total_assigned_dc_html" >0</h4>
                        </div>
                        <div class="col-md-4 form-group mb-3">
                            <label for="repair_category" class="font-weight-bold">Total Limit Remain of DC</label>
                            <h4 class="text-success font-weight-bold" id="total_remain_dc_html" >0</h4>
                        </div>
                    </div>

                    <form method="post" action="{{ route('emirates_id_card.store')  }}"  enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="row ">
                            <div class="col-md-4 form-group mb-3 append_div">
                                <label for="repair_category">Select User</label>
                                <select class="form-control" name="dc_id" id="dc_id" required >
                                    <option value="" selected  >select an option</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Platform</label>
                                <select class="form-control" id="platform_id" name="platform_id" >
                                    <option value="">select an option</option>
                                </select>
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Select Quantity</label>
                                <select class="form-control" id="quantity" name="quantity" >
                                    <option value="">select an option</option>
                                    @for($i=1; $i<=300; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor

                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-right" id="btn_display" type="button">Display List</button>
                            </div>
                        </div>

                        <div class="row display_remain_div" >
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold">Total Riders</label>
                                <h4 class="text-primary font-weight-bold" id="total_rider_html">0</h4>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold" >Total Assigned</label>
                                <h4 class="text-info font-weight-bold" id="total_assigned_rider_html" >0</h4>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category" class="font-weight-bold">Total Remain</label>
                                <h4 class="text-success font-weight-bold" id="total_remain_rider_html" >0</h4>
                            </div>
                        </div>

                    </form>
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
                                    <th scope="col">
                                        <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                            <input type="checkbox"  id="checkAll"   ><span>Check All</span><span class="checkmark"></span>
                                        </label>
                                    </th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Nationality</th>
                                </tr>
                                </thead>
                                <tbody>


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

            var total_remain_dc = $("#total_remain_dc_html").html();


            if(quantity > parseInt(total_remain_dc)){
                tostr_display("error","you are exceeded form the DC limit.!")
            }else if(platform != '' &&  quantity != '' && dc_id != '')
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


            $('#dc_id').select2({
                placeholder: 'Select an option'
            });

            $('#quantity').select2({
                placeholder: 'Select an option'
            });

            $('#platform_id').select2({
                placeholder: 'Select an option'
            });


        });


        // $("#dc_id").change(function () {
            $(document).on("change", "#dc_id", function (e) {
                e.stopPropagation();

                $("#select_platform").val("");
                $("#select_quantity").val("");
                $("#select_dc_id").val("");

            var user_id = $(this).val();
            var token = $("input[name='_token']").val();
            $("#platform_id").empty();
            $.ajax({
                url: "{{ route('get_passport_checkin_platform') }}",
                method: 'POST',
                dataType: 'json',
                data: {user_id: user_id, _token:token},
                success: function(response) {
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    var options = "";
                    if(len > 0){
                        var html_ab = '';

                        for(var i=0; i<len; i++){
                            // html_ab += '<option value="'+response[i].id+'">'+response[i].name+'</option>';
                            add_dynamic_opton(response[i].id,response[i].name);
                        }
                        // $("#platform_id").html(html_ab);
                    }
                }
            });








        });

        $(document).on("change", "#platform_id", function (e) {
            // e.stopPropagation();

            var selected_platform = $(this).val();
            var user_id = $( "#dc_id option:selected" ).val()


            if(selected_platform!=null){
                $.ajax({
                    url: "{{ route('get_remain_platform_counts') }}",
                    method: 'get',
                    data: {platform_id: selected_platform},
                    success: function(response) {

                        var  array = JSON.parse(response);

                        $(".display_remain_div").show(400);
                        $("#total_assigned_rider_html").html(array.total_rider_assigned);
                        $("#total_rider_html").html(array.total_rider_platform);
                        $("#total_remain_rider_html").html(array.total_rider_remain);

                    }
                });

                $.ajax({
                    url: "{{ route('get_remain_dc_counts') }}",
                    method: 'get',
                    data: {user_id: user_id,platform_id:selected_platform},
                    success: function(response) {

                        var  array = JSON.parse(response);

                        $(".display_dc_remain_div").show(400);
                        $("#total_dc_html").html(array.total_dc_limit);
                        $("#total_assigned_dc_html").html(array.total_rider_assigned);
                        $("#total_remain_dc_html").html(array.total_rider_remain);

                    }
                });



            }else{
                $(".display_remain_div").hide();
                console.log("we are in else");
            }




        });

        $(document).on("change", "#quantity", function (e) {
            // e.stopPropagation();
            var selected_value = $(this).val();
            var total_remain_dc = $("#total_remain_dc_html").html();

            var abc_value = parseInt(selected_value)

            if(abc_value > parseInt(total_remain_dc)){
                tostr_display("error","you are exceeded form the DC limit.!")
            }


        });


    </script>
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
