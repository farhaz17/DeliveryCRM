@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        p.text-muted.mt-2.mb-0 {
            white-space: nowrap;
        }
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


    {{-- --------------------tickets---------------------}}
    <div class="row">
        <div class="col-12 mb-2">
            <div class="card-body">
                <div class="row row-xs">
                    <div class="col-md-4 offset-4 mt-3 mt-md-0">
                        <select class="form-control form-control-sm select2" id="date_range">
                            <option value="latest" selected >Current COD</option>
                            @foreach ($date_range['end_dates'] as $key => $date)
                                <option value="{{ $date_range['start_dates'][$key]."_".$date }}">From {{ $date_range['start_dates'][$key] }} To {{ $date }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" id="collection_report_holder"></div>
    <!--------Companny employee detail modal------------->
    <div class="col-md-12">
        <div class="modal fade" id="emp_modal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="row">

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verifyModalContent_title">Dummy</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12 form-group mb-3 " id="emp_div">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
    <!--------Companny employee detail modal Ends------------->

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('.select2').select2({
            placeholder: "Check previous closing months"
        })
    </script>
    <script>
        $(document).ready(function(){
            $('body').addClass('loading')
            var date_range = $('#date_range').val();
            var url = "{{ route('carrefour_ajax_dashboard') }}";
            $.ajax({
                url,
                data : { date_range },
                method : "GET",
                success: function(response){
                    $('#collection_report_holder').empty()
                    $('#collection_report_holder').append(response.html)
                    $('body').removeClass('loading')
                }
            });
        });
        $('#date_range').change(function(){
            $('body').addClass('loading')
            var date_range = $(this).val();
            var url = "{{ route('carrefour_ajax_dashboard') }}";
            $.ajax({
                url,
                data : { date_range },
                method : "GET",
                success: function(response){
                    $('#collection_report_holder').empty()
                    $('#collection_report_holder').append(response.html)
                    $('body').removeClass('loading')
                }
            });
        });
    </script>
@endsection
