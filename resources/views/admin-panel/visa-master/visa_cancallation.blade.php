@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        #drop-pass_id{
            display: none;
        }
        </style>
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
            <li><a href="">Visa Process</a></li>
            <li>Visa Cancellation</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">

        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="row">
            <div class="col-md-2">
            </div>
               <div class="col-md-8">
                 <div class="card mb-4">
                     <div class="card-body">
                        <div class="card-title mb-3">Visa Cancelation</div>
                        <form method="post" action="{{isset($designation_data)?route('visa_cancel.store',$designation_data->id):route('visa_cancel.store')}}">
                            {!! csrf_field() !!}
                            <input type="hidden" id="id" name="id" value="{{isset($designation_data)?$designation_data->id:""}}">
                            <div class="row">

                                <div class="input-group mb-3 ml-3 mr-0">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>

                                    <input class="form-control typeahead" id="keyword" autocomplete="off" type="text" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <div id="clear">
                                        X
                                    </div>

                                </div>
                                <input class="form-control" id="passport_ids" name="passport_id" type="hidden" />


{{--                                <div class="col-md-12 form-group mb-3">--}}
{{--                                    <label for="repair_category">Cancallation</label>--}}
{{--                                    <select id="passport_id" name="passport_id" class="form-control" >--}}
{{--                                        @foreach($passport as $pas)--}}
{{--                                            <option value="{{ $pas->id }}">{{$pas->passport_no}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                </div>--}}

                                <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Cancallation</label>
                                    <select id="cancel_type" name="cancallation_type" class="form-control" >
                                        <option value=""  selected disabled >Select option</option>
                                            <option value="1">Resign</option>
                                            <option value="2">Termination</option>
                                    </select>
                                </div>

                                <div class="col-md-12 form-group mb-3" id="res_type" style="display: none">
                                    <label for="repair_category">Resignation Type</label>
                                    <select id="" name="resignation_type" class="form-control" >
                                    <option value=""  selected disabled >Select option</option>
                                    <option value="1">Instant</option>
                                    <option value="2">Wait For Cancallation Until He Continues</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group mb-3 form1" style="display: none">
                                    <label for="repair_category">Remarks</label>
                                    <input class="form-control" id="remarks" name="remarks" type="text" placeholder="Enter Remarks"  />
                                </div>
                                <div class="col-md-4 form-group mb-3 form2" style="display: none">
                                    <label for="repair_category">Date Untill He Works</label>
                                    <input class="form-control" id="date_works" name="date_until_works"  type="date" placeholder="Date Untill He Works"  />
                                </div>
                                <div class="col-md-4 form-group mb-3 form3" style="display: none">
                                    <label for="repair_category">When To Start Cancellation</label>
                                    <input class="form-control" id="date_works" name="start_cancel_date"  type="date" placeholder="When To Start Cancellation"  />
                                </div>

                                <div class="col-md-12">
                                    <button class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
            </div>
        </div>

    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script type="text/javascript">
        var path = "{{ route('autocomplete_cancel') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {
                    return process(data);
                });},
            highlighter: function (item, data) {
                var parts = item.split('#'),
                    html = '<div class="row drop-row">';
                if (data.type == 0) {
                    html += '<div class="col-lg-12 sugg-drop">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<span id="drop-pass_id">'  + data.passport_id  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<span id="drop-pass_id">'  + data.passport_id  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<span id="drop-pass_id">'  + data.passport_id  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else{
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<span id="drop-pass_id">'  + data.passport_id  + '</span>';
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
            var keyword  =   $(this).find('#drop-pass_id').text();
            $("#passport_ids").val(keyword);
        });
        </script>


    <script>
        $("#cancel_type").change(function(){
            var cancel_type = $("input[name='cancel_type']").val();
            var token = $("input[name='_token']").val();
            var id=this.value;
            if (id=='1') {
                $('#res_type').hide();
                $('#res_type').show();
                $('.form1').show();
                $('.form2').show();
                $('.form3').show();
            }
            else{
                $('#res_type').hide();
                $('.form1').show();
                $('.form2').show();
                $('.form3').show();
            }
        });
        $('#passport_id').select2({
            placeholder: 'Select an option'
        });
    </script>

    <script>
        $("#clear").click(function(){
            $("#passport_ids").val('');
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
