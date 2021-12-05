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
            <li><a href="">Create Interview</a></li>
            <li>Create Intreview</li>
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
                    <div class="card-title mb-3">Create Interview</div>
                    <form method="post" action="{{ route('emirates_id_card.store')  }}"  enctype="multipart/form-data">
                        {!! csrf_field() !!}

{{--                        <div class="row">--}}
{{--                            <div class="col-md-5">--}}

{{--                                <div class="form-check-inline">--}}
{{--                                    <label class="radio radio-outline-success">--}}
{{--                                        <input type="radio" class="search_type_cls" checked  value="3" name="search_type" /><span>Passport Number</span><span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                                <div class="form-check-inline">--}}
{{--                                    <label class="radio radio-outline-primary">--}}
{{--                                        <input type="radio" class="search_type_cls" value="1" name="search_type"  /><span>PPUID</span><span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                                <div class="form-check-inline">--}}
{{--                                    <label class="radio radio-outline-secondary">--}}
{{--                                        <input type="radio"  class="search_type_cls"  value="2" name="search_type" /><span>ZDS Code</span><span class="checkmark"></span>--}}
{{--                                    </label>--}}
{{--                                </div>--}}

{{--                            </div>--}}

{{--                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >--}}
{{--                                <label class="radio-outline-success ">Name:</label>--}}
{{--                                <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>--}}
{{--                            </div>--}}

{{--                        </div>--}}


                        <div class="row ">
                            <div class="col-md-6 form-group mb-3 append_div">
                                <label for="repair_category">Select Platform</label>
                                <select class="form-control  " name="platform_id" id="passport_id" required >
                                    <option value="">select an option</option>
                                    @foreach($platforms as $platform)
                                        <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-2 form-group mb-3">
                                <label for="repair_category">Select Quantity</label>
                                <select class="form-control" id="quantity" name="quantity" >
                                    <option value="">select an option</option>
                                    @for($i=1; $i<=100; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor

                                </select>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Select Date And Time</label>

                                <input class="form-control form-control" id="date_time" name="date_time" type="datetime-local" required  />
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary pull-right" id="btn_display" type="button">Display List</button>
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
                        <form action="{{ route('save_interview_list') }}" method="POST">
                            @csrf
                            <input type="hidden" value="" id="select_platform" name="select_platform" >
                            <input type="hidden" value="" id="select_quantity" name="select_quantity" >
                            <input type="hidden" value="" id="select_date_time" name="select_date_time" >
                        <table class="display table table-striped table-bordered" id="datatable">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
            function ajax_table_load(){

                var token = $("input[name='_token']").val();
                var platform_id = $("#passport_id").val();
                var quantity = $("#quantity").val();
                var select_date_time = $("#select_date_time").val();

                $.ajax({
                    url: "{{ route('display_interview_list') }}",
                    method: 'POST',
                    data: {_token:token,platform_id:platform_id,quantity:quantity,select_date_time:select_date_time},
                    success: function(response) {

                        $('#datatable tbody').empty();
                        $('#datatable tbody').append(response.html);


                    }
                });

            }
        </script>


    <script>

        $("#btn_display").click(function(){

            var platform = $("#passport_id").val();
            var quantity = $("#quantity").val();
            var select_date_time = $("#date_time").val();

            $("#select_platform").val(platform);
            $("#select_quantity").val(quantity);
            $("#select_date_time").val(select_date_time);

            if(platform != '' &&  quantity != '')
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


            $('#passport_id').select2({
                placeholder: 'Select an option'
            });

            $('#quantity').select2({
                placeholder: 'Select an option'
            });



            $("#passport_id").change(function () {


                var passport_id = $(this).val();


                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('ajax_get_current_passport_status') }}",
                    method: 'POST',
                    data: {passport_id: passport_id, _token:token},
                    success: function(response) {
                        $("#status_id").val(response);
                    }
                });

            });

        });

    </script>



    <script>
        $(".edit_cls").click(function(){

            tail.DateTime("#edit_issue_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });

            tail.DateTime("#edit_expire_date",{
                dateFormat: "YYYY-mm-dd",
                timeFormat: false,
            });

            var  ids  = $(this).attr('id');
            $("#primary_id").val(ids);

            $(".select2-container").css('width','100%');

            var ab  = $("#edit_from").attr('action');

            var now = ab.split('emirates_id_card/');

            $("#edit_from").attr('action',now[0]+"emirates_id_card/"+ids);


            var edit_ab = "{{ route('emirates_id_card.edit',1) }}";

            var now_edit_ab = edit_ab.split("emirates_id_card/");

            var final_edit_url = now_edit_ab[0]+"emirates_id_card/"+ids+"/edit";

            console.log("edit ab="+final_edit_url);

            var token = $("input[name='_token']").val();
            $.ajax({
                url: final_edit_url,
                method: 'GET',
                data: {primary_id: ids ,_token:token},
                success: function(response) {
                    var arr = $.parseJSON(response);
                    if(arr !== null){

                        $("#edit_id_number").val(arr['card_no']);
                        $("#passport_id_edit").val(arr['passport_number']);
                        $("#edit_issue_date").val(arr['expire_date']);


                    }

                }
            });

            $("#edit_modal").modal('show');
        });
    </script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

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
