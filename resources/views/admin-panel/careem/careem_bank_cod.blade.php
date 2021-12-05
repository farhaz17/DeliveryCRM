@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Careem</a></li>
        <li>Bank Cod</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="card-title">Add Bank COD</div>

            <form method="post" enctype="multipart/form-data" action="{{ route('careem_store_bank') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Rider id</label>
                        <select id="zds_code" name="zds_code" class="form-control cod_zds_code" required>
                            <option value="">Select option</option>
                            @foreach ($rider_ids as $rider_id)
                                <option value="{{ $rider_id->passport_id }}" >{{ $rider_id->platform_code }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group mb-3" id="unique_div1" >
                        <label for="repair_category">Name</label><br>
                        <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Date</label>
                        <input class="form-control" id="date" name="date" type="date" placeholder="Enter Date" max="<?php echo date("Y-m-d"); ?>" />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Time</label>
                        <input class="form-control" id="time" name="time"type="time" placeholder="Enter Time" required />
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Amount </label>
                        <input class="form-control" id="amount" name="amount" type="number" placeholder="Enter Amount" step="0.01" required/>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="repair_category">Message/Remarks</label>
                        <textarea id="message" name="message" cols="30" rows="5" class="form-control" placeholder="Enter Message Or Remarks"></textarea>
                    </div>
                    <div class="col-md-4">
                        <label for="repair_category" id="copy_label">COD Slip Image</label>
                        <input class="form-control" id="picture" type="file" name="picture"/>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
       var date = new Date();
       var time = date.getHours() + ":" + date.getMinutes();
       document.getElementById('time').value = time;
       document.getElementById('date').valueAsDate = date;
       });
   </script>
    <script>
        $('.cod_zds_code').select2({
            placeholder: 'Select an option'
        });
    </script>
     <script>
        $('#zds_code').on('change', function(){
            var zds_code = $(this).val();

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('cod_get_passport_detail') }}",
                method: "POST",
                data:{zds_code: zds_code,_token: token},
                success:function(response){
                    var res = response.split('$');
                    $("#sur_name1").html(res[0]);
                }
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
@endsection
