@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
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
    /* Turn off scrollbar when body element has the loading class */
    body.loading{
        overflow: hidden;
    }
    /* Make spinner image visible when body element has the loading class */
    body.loading .overlay{
        display: block;
    }
    </style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">COD Reports</a></li>
        <li>Balance COD</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12 text-center" >
                    <a class="btn btn-info btn-sm" href="#"  id="Balancebelow500Cod">Below 500 (AED) Balance</a>
                    <a class="btn btn-info btn-sm" href="#"  id="BalanceAbove500Cod">Above 500 (AED) Balance</a>
                    <a class="btn btn-info btn-sm" href="#"  id="BalanceAbove1000Cod">Above 1000 (AED) Balance</a>
                    <a class="btn btn-info btn-sm" href="#"  id="BalanceAbove1500Cod">Above 1500 (AED) Balance</a>
                    <a class="btn btn-info btn-sm" href="#"  id="BalanceAbove2000Cod">Above 2000 (AED) Balance</a>
                    <a class="btn btn-info btn-sm" href="#"  id="BalanceAbove2500Cod">Above 2500 (AED) Balance</a>
                </div>
            </div><br>

            <div class="append_div">
            </div>

        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $('#Balancebelow500Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'b500';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
        $('#BalanceAbove500Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'a500';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
        $('#BalanceAbove1000Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'a1000';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
        $('#BalanceAbove1500Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'a1500';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
        $('#BalanceAbove2000Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'a2000';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
        $('#BalanceAbove2500Cod').on('click',function(){

            var platform_id = 4;
            var amt = 'a2500';
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_balance_cod') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id,amt:amt},
                success: function(response) {

                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
    </script>
    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>
@endsection
