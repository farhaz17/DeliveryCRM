@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
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
        <li><a href="">Carrefour</a></li>
        <li>Balance COD</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="col-md-4"></div>
                <div class="form-group col-4 float-right">
                    <label for="dc_id">DC List</label>
                    <select name="dc_id" id="dc_id" class="form-control form-control-sm select2">
                        <option value=""></option>
                        <option value="all">All</option>
                        @foreach ($dc_users as $user)
                            <option value="{{ $user->id }}">{{ ucFirst($user->name ?? "") }}</option>
                        @endforeach
                    </select>
                </div>
            </div><br>
            <div class="button_div"></div>
            <hr>
            <div class="append_div">
            </div>

        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: "Select a DC for DC wise filter"
        });
        $('#dc_id').change(function(){
            var dc = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_get_carrefour_button') }}",
                method: 'POST',
                data: {_token:token,dc:dc},
                success: function(response) {
                    $('.button_div').empty();
                    $('.button_div').append(response);
                    $('.append_div').empty();
                }
            });
        });
    </script>
    <script>
        function getid(value) {
            var btnValue = value.id;
            var token = $("input[name='_token']").val();
            var dc = $('#dc_id').val();

            $.ajax({
                url: "{{ route('ajax_balance_carrefour') }}",
                method: 'POST',
                data: {_token:token,btnValue:btnValue,dc:dc},
                success: function(response) {
                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        }
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
