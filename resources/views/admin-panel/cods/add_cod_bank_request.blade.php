@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_processing {

            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
    </style>




    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Add COD BANK Request</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>





        <div class="row">
            <div class="col-sm-12">
            <div class="card text-left">
                <div class="card-body">

                <div class="card-title mb-3">Add COD Bank Reqeusts</div>
                    <form  action="{{isset($cods)?route('edit_cod_bank',$cods->id):url('add_cod_bank_store')}}" method="POST" enctype="multipart/form-data">

                    {!! csrf_field() !!}
                    @if(isset($cods))
                            {{ method_field('GET') }}
                    @endif

                    <div class="row">
                        {{-- <div class="col-md-3 form-group mb-3">
                            <label for="repair_category">Platform</label>
                            <select id="platform_id" name="platform_id" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach($platforms as $platform)
                                    <option value="{{ $platform->id }}"  >{{ $platform->name  }}</option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-md-3 form-group mb-3">
                            <label for="repair_category">Rider id</label>
                            <select id="zds_code" name="zds_code" class="form-control cod_zds_code" required>
                                <option value=""  >Select option</option>
                                @foreach ($rider_ids as $rider_id)
                                <option value="{{ $rider_id->passport_id}}">{{ $rider_id->platform_code}}</option>
                            @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 form-group mb-3" id="unique_div1" >
                            <label for="repair_category">Name</label><br>
                            <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>
                        </div>


                        {{-- <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Slip Number</label>
                            <input class="form-control" id="slip_number" name="slip_number"  value="{{isset($cods)?$cods->slip_number:""}}"  type="number" placeholder="Enter Employee Name" />
                        </div> --}}
                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Machine Number</label>
                            <input class="form-control" id="machine_number" name="machine_number" value="{{isset($cods)?$cods->machine_number:""}}"  type="number" placeholder="Enter Insurance" required />
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Machine Location </label>
                            <input class="form-control" id="location_at_machine" name="location_at_machine" value="{{isset($cods)?$cods->location_at_machine:""}}"   type="text" placeholder="Enter Category" />
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Date</label>
                            <input class="form-control" id="date" name="date"  type="date"  value="{{isset($cods)?$cods->date:""}}"  placeholder="Enter Date" max="<?php echo date("Y-m-d"); ?>" required/>
                        </div>
                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Time</label>
                            <input class="form-control" id="time" name="time" type="time" value="{{isset($cods)?$cods->time:""}}"  placeholder="Enter Time" required />
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Amount </label>
                            <input class="form-control " id="amount" name="amount"  value="{{isset($cods)?$cods->amount:""}}"  type="number" placeholder="Enter amount " step="0.01" required />
                        </div>

                        <div class="col-md-6">
                            <label for="repair_category" id="copy_label">COD Slip Image</label>
                            <input class="form-control" id="picture" type="file" name="picture"/>
                        </div>
                        @if(isset($cods))
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">View COD Slip Image</label><br>

                                <br>
                                <input class="form-control form-control" value="{{isset($cods)?$cods->picture:""}}" id="pictures" name="picture2" type="hidden"   />
                                <a class="attachment_display" href="{{ isset($cods->picture) ? url($cods->picture) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">COD Slip Image</strong></a>

                            </div>
                        @endif
                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Message/Remarks</label>
                            <textarea id="message" name="message" value="{{isset($cods)?$cods->message:""}}" cols="30" rows="5" class="form-control" placeholder="Enter Message Or Remarks">{{isset($cods)?$cods->message:""}}</textarea>
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


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
        var date = new Date();
        var time = date.getHours() + ":" + date.getMinutes();
        document.getElementById('time').value = time;
        console.log(time);
        document.getElementById('date').valueAsDate = date;
        });
    </script>
    <script>

        $('.cod_zds_code').select2({
            placeholder: 'Select an option'
        });
        $(document).on('change','#zds_code', function(){
            var zds_code = $(this).val();
            if(zds_code != null){

                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "{{ route('cod_get_passport_detail') }}",
                    method: 'POST',
                    data: {zds_code: zds_code, _token:token},
                    success: function(response) {
                        var res = response.split('$');
                        $("#sur_name1").html(res[0]);
                    }
                });

            }


        });

        $("#platform_id").change(function(){
            var token = $("input[name='_token']").val();
            var platform_id = $(this).val();
            $("#sur_name1").html("");
            $.ajax({
                url: "{{ route('get_rider_id_by_platform') }}",
                method: 'POST',
                dataType: 'json',
                data: {platform_id: platform_id, _token:token},
                success: function(response) {

                    $('#zds_code').empty().trigger("change");
                    $("#sur_name1").html("");
                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        $('#zds_code').empty().trigger("change");
                        for(var i=0; i<len; i++){
                            var newOption = new Option(response[i].platform_code, response[i].passport_id, true, true);
                            $('#zds_code').append(newOption);
                        }
                        $('#zds_code').val(null).trigger('change');

                    }else{

                    }
                }
            });

        });
    </script>



    <script>
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

    </script>

{{--    <script type="text/javascript">--}}
{{--        function load_data(from_date= '', end_date= ''){--}}

{{--            var table = $('#datatable').DataTable({--}}
{{--                "aaSorting": [[0, 'desc']],--}}
{{--                "language": {--}}
{{--                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",--}}
{{--                },--}}


{{--                "pageLength": 10,--}}
{{--                "columnDefs": [--}}
{{--                    // {"targets": [0],"visible": false},--}}
{{--                    {"targets": [0][1],"width": "30%"}--}}
{{--                ],--}}
{{--                "scrollY": false,--}}
{{--                "processing": true,--}}
{{--                "serverSide": true,--}}

{{--                ajax:{--}}
{{--                    url : "{{ route('bank_paid_detail',Request::segment(2)) }}",--}}
{{--                    data:{from_date:from_date, end_date:end_date},--}}
{{--                },--}}

{{--                "deferRender": true,--}}
{{--                columns: [--}}
{{--                    {data: 'name', name: 'name'},--}}
{{--                    {data: 'date', name: 'date'},--}}
{{--                    {data: 'time', name: 'time'},--}}
{{--                    {data: 'slip_number', name: 'slip_number'},--}}
{{--                    {data: 'machine_number', name: 'machine_number'},--}}
{{--                    {data: 'location_at_machine', name: 'location_at_machine'},--}}
{{--                    {data: 'amount', name: 'amount'},--}}
{{--                    {data: 'status', name: 'status'},--}}
{{--                    {data: 'picture', name: 'picture' , orderable: false, searchable: false},--}}

{{--                ]--}}
{{--            });--}}

{{--        }--}}
{{--    </script>--}}

    <script>

        $('#platform_id').select2({
            placeholder: 'Select an option'
        });
        </script>


    <script>
        $(document).ready(function () {
            load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable').DataTable().destroy();
                    load_data(start_date, end_date);
                }
                else
                {
                    tostr_display("error","Both date is required");
                }

            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#datatable').DataTable().destroy();
                load_data();
            });


        });

        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('rider_profile.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }

        function resetPassportFile() {
            $('#passport-change').hide();
            $('.passport-div').show();
        }
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
