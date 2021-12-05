@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li>COD Adjustment</li>
        <li>Add COD Adjustment</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="row">
    <div class="col-md-12">
        <div class="card text-left">
            <div class="card-body">
                <div class="card-title mb-3">Add COD Adjustment</div>

                <form action="{{ route('cod_adjust_save') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">Rider Id</label>
                            <select id="zds_code" name="zds_code" class="form-control cod_zds_code" required>
                                <option value=""  >Select option</option>
                                @foreach ($rider_ids as $rider_id)
                                    <option value="{{ $rider_id->passport_id }}" >{{ $rider_id->platform_code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="">Name</label><br>
                            <span id="zname"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">Order Id</label>
                            <input type="number" name="order_id" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Date</label>
                            <input type="date" name="date" id="date" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="">Remark</label>
                            <textarea name="message" id="" cols="30" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="">Image</label>
                            <input type="file" name="image[]" id="aa" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <br>
                            <button class="btn btn-primary btn-sm" type="button" id="add_more">Add More Image</button>
                        </div>
                    </div>
                    <div class="hide">
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <button class="btn btn-primary">Save</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        var row = 1;
        $('#add_more').on('click',function(){
            if(row < "3"){
            var ab = `
                        <div class="row" id="row`+row+`">
                            <div class="col-md-4 mb-3 one">
                                <label for="">Image</label>
                                <input type="file" name="image[]" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <br>
                                <button class="btn btn-danger btn-sm delete_btn" type="button" data-row_id="row`+row+`" id="delete">Delete</button>
                            </div>
                        </div>
                    `;
            $('.hide').append(ab);
            row++
            }
        });
        $(document).ready(function(){
            $('.hide').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
            $("#"+ids).remove();
        });
    });
    </script>
    <script>
        $(document).ready(function(){
       var date = new Date();
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
                    $("#zname").html(res[0]);
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
