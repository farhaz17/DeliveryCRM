@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/sweetalert2.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        /* loading image css starts */
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
        /* loading image css ends */
    </style>
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
            <div class="row">
                <div class="col-md-2 form-group mb-3"></div>
                <div class="col-md-3 form-group mb-3">
                    <label for="start_date">Start Date</label>
                    <input type="text" name="start_date" autocomplete="off" class="form-control form-control-sm" id="start_date" value="{{ request('start_date') ?? date('Y-m-01') }}">
                </div>
                <div class="col-md-3 form-group mb-3">
                    <label for="end_date">End Date</label>
                    <input type="text" name="end_date" autocomplete="off" class="form-control form-control-sm" id="end_date" value="{{ request('end_date') ?? date('Y-m-t') }}">
                </div>
                <div class="col-md-1 form-group mb-3" style="margin-top: 20px;"  >
                    <button class="btn btn-info btn-icon m-1" id="apply_filter"  type="button">
                        <span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span>
                    </button>
                    {{-- <a class="btn btn-sm btn-danger btn-icon m-1 d-none" href="" id="remove_apply_filter" data="datatable"  type="button">Clear <span class="ul-btn__icon"><i class="i-Close"></i></span></a> --}}
                </div>
                <div class="col-md-3 form-group" style="margin-top: 25px">
                    <div class="total">
                        <div class="total"><h5><b> Total Amount: <span id="total_amount">0.00</span> <span class="badge badge-success">AED</span></b></h5></div>
                    </div>
                </div>
            </div>
            <div class="row" id="careem_bank_cod_holder"></div>

        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/sweetalert.script.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).on('click','.alert-confirm',function (e) {
            var form_id = e.target.getAttribute('data-form_id')
          swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#0CC27E',
          cancelButtonColor: '#FF586B',
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          confirmButtonClass: 'btn btn-sm btn-success mr-5',
          cancelButtonClass: 'btn btn-sm btn-danger',
          buttonsStyling: false
          }).then(function () {
            $('body').addClass('loading')
            swal('Deleted!', 'Careem Bank Cod has been deleted.', 'success').then(function(){
                  $('#' + form_id).submit();
              });
          }, function (dismiss) {
          // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
          if (dismiss === 'cancel') {
              swal('Cancelled', 'Bank cod is not deleted :)', 'error');
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
    <script>
        $("input[name='start_date']").change(function(){
            $("input[name='end_date']").val('')
        });
    </script>

    <script>
        $(document).ready(function(){
            $("#apply_filter").trigger('click');
        });
        $("#apply_filter").click(function () {
            var start_date = $("input[name='start_date']").val();
            var end_date = $("input[name='end_date']").val();
            if(start_date == '' || end_date == ""){
                tostr_display('error', "Please select start and end date")
                return false;
            }else{
                $.ajax({
                    url: "{{ route('careem_bank_cod') }}",
                    method: 'GET',
                    data: { start_date, end_date },
                    success: function(response) {
                        $('#total_amount').text(response.total_amount)
                        $("#careem_bank_cod_holder").empty(response);
                        $("#careem_bank_cod_holder").append(response.html);
                        selectRefresh();
                    }
                });
            }

        });
    </script>

    <script>
        function selectRefresh() {
            $('#careem_bank_cod_holder .select2').select2({
                tags: true,
                placeholder: "Select an Option",
                allowClear: true,
                width: '100%'
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
    <script>
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
            }
        }
    </script>
@endsection
