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
            <li><a href="">DC List</a></li>
            <li>DC</li>
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
                    <div class="card-title mb-3">DC LIST</div>

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
                                    <th scope="col">Name</th>
                                    <th scope="col">Platforms/Rider Number</th>
                                    <th scope="col">email</th>
                                    <th scope="col">created at</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <?php $gamer  = $platforms->whereIn('id',$user->user_platform_id); ?>
                                            @if(isset($gamer))
                                        <td>@foreach($gamer as $g)
                                             <a href="{{ route('dc_rirder_by_platform',['id' => $user->id, 'name' => $g->id]) }}" target="_blank">{{ $g->name }} ({{ count($user->get_dc_riders_by_platform($g->id)) }})<a> ,
                                            @endforeach
                                        </td>
                                        @else
                                            <td>N/A</td>
                                         @endif

                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->created_at }}</td>
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


            $('#dc_id').select2({
                placeholder: 'Select an option'
            });

            $('#quantity').select2({
                placeholder: 'Select an option'
            });

            $('#platform_id').select2({
                placeholder: 'Select an option'
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
