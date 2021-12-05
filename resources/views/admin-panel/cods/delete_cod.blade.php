@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
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
        <li><a href="">COD</a></li>
        <li>Delete Cods</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row">
    <div class="col-md-2 mb-3"></div>
    <div class="col-md-8 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <form  id="deleteform" >
                    @csrf
                    <div class="row" style="text-align:center;">
                        <div class="col-md-4"></div>
                        <div class="col-md-4 form-group">
                            <label for="">Select Cod Date</label>
                            <input type="date" name="date" class="form-control form-control-sm" id="" required>
                        </div>
                    </div>
                    <div class="row" style="text-align:center;">
                        <div class="col-md-12 form-group">
                            <label for="">Select Cod Type</label><br>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="cod_type" id="" value="1"><span>Cash Cod</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="cod_type" id="" value="2"><span>Bank Cod</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-info">
                                    <input type="radio" name="cod_type" id="" value="3"><span>Adjustment</span><span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="text-align:center;">
                        <div class="col-md-12 form-group"><br>
                            <button class="btn btn-info ml-2" type="submit">Search</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<div class="append_div" style="width: 100%"></div>

<div class="modal fade bd-example-modal-sm" id="delete_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="{{ route('delete_cods_by_date') }}" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    @csrf
                    Are you sure want to delete all data?
                </div>
                <input type="hidden" name="type" id="type">
                <input type="hidden" name="dates" id="dates">
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger ml-2 " type="submit" >Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $('#deleteform').on('submit',(function(e){
                e.preventDefault();
            $.ajax({
                url: "{{ route('get_delete_cods') }}",
                method: 'post',
                data:  new FormData(this),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function () {
                    $("body").addClass("loading");
                },
                success:function(response){
                    console.log(response);
                    if(response.code == 100) {
                        toastr.error(response.message.message, { timeOut:10000 , progressBar : true });
                        $('#UploadDocuments').modal('hide');
                        $("body").removeClass("loading");
                    }else if(response.code == 101) {
                        $('.append_div').empty();
                        $('.append_div').append(response.html);
                        $('#type').val(response.type);
                        $('#dates').val(response.date);
                    }
                }
            });
        }));
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
