@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        input#current_price {
    height: 28px;
    background: #ffffff;
}
button#submit {
    height: 27px;
    padding-top: 4px;
}
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Price</a></li>
            <li>Price Master</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Price Details</div>
                    <form method="post" class=""  @if(isset($current_price_edit)) id="price_form_edit" @else id="price_form" @endif>
                        {!! csrf_field() !!}
                        @if(isset($current_price_edit))
                        {{ method_field('POST') }}
                        <input type="hidden" value="{{isset($current_price_edit->id)?$current_price_edit->id:""}}" name="id">
                    @endif

                        <div class="row ">
                            <div class="col-md-3">

                            </div>
                            <div class="col-md-3  form-group mb-3">
                                <label for="repair_category" class="font-weight-bold text-11">Part</label>
                                <select id="parts_id" required name="parts_id" class="form-control form-css">
                                    <option value="" disabled selected>Select Plate No</option>
                                    @foreach($parts as $row)
                                        @php
                                            $isSelected=(isset($current_price_edit)?$current_price_edit->id:"")==$row->id;
                                        @endphp
                                        <option value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>{{$row->part_name}} | {{$row->part_number}}</option>
                                    @endforeach
                                </select>
                            </div>
                        <div class="col-md-3 form-group  mb-3 ">
                                <label for="repair_category" class="font-weight-bold text-11" >Current Price</label>
                                <input type="number"  class="form-control" value="{{isset($current_price_edit)?$current_price_edit->price:""}}" name="current_price" id="current_price">
                        </div>
                        <div class="col-md-3 mt-4" >
                                <button class="btn btn-primary" type="submit" id="submit">Add</button>
                         </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div  class="row row3">
        <div class="col-md-12">
            <div class="ajax_table_load">
            </div>
        </div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $( document ).ready(function() {
                $.ajax({
                        url: "{{ route('price_view') }}",
                        dataType: 'json',
                        success: function (response) {
                            $(".ajax_table_load").empty();
                            $('.ajax_table_load').append(response.html);
                        }
                    });
    });

        function refresh(){
                $.ajax({
                        url: "{{ route('price_view') }}",
                        dataType: 'json',
                        success: function (response) {
                            $(".ajax_table_load").empty();
                            $('.ajax_table_load').append(response.html);
                        }
                    });
    }
    </script>

    <script>
        $(document).ready(function (e){
        $("#price_form").on('submit',(function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('price.store') }}",
                type: "POST",
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                success: function(response){
                    $("#price_form").trigger("reset");
                    $("#price_form_edit").trigger("reset");
                    if(response.code == 100) {
                        refresh();
                        toastr.success("Price Saved Successfully!", { timeOut:10000 , progressBar : true});
                    }
                    else if(response.code == 101){
                        refresh();
                        toastr.error("Price is Still Active! Deactivate Before Add New", { timeOut:10000 , progressBar : true});
                    }
                    else if(response.code == 102){
                        refresh();
                        toastr.success("New Price Have Been Added", { timeOut:10000 , progressBar : true});
                    }
                    else {
                        refresh();
                        toastr.error("Something Went Wrong! Try Again", { timeOut:10000 , progressBar : true});

                    }
                },
                error: function(){}
            });
        }));
    });
            </script>




<script>
    $(document).ready(function (e){
    $("#price_form_edit").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('price_update') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#price_form_edit").trigger("reset");
                $("#price_form").trigger("reset");
                if(response.code == 100) {
                    refresh();
                    window.location.href = "{{ route('price')}}";
                    toastr.success("Price Updated Successfully!", { timeOut:10000 , progressBar : true});
                }
                else {
                    refresh();
                    toastr.error("Something Went Wrong! Try Again", { timeOut:10000 , progressBar : true});

                }
            },
            error: function(){}
        });
    }));
});
        </script>



    <script>
        $('#parts_id').select2();
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
