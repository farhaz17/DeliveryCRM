@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .c-three-card{
            background-color: beige;
        }
        .lulu-card{
            background-color: aquamarine;
        }

        .bank{
            background-color: darkkhaki;
        }
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Company</a></li>
        <li class="breadcrumb-item"><a href="{{ route('wps_dashboard',['active'=>'reports-menu-items']) }}">Reports</a></li>
      <li class="breadcrumb-item active" aria-current="page">Company Listed</li>
    </ol>
</nav>
<form id="wpsUpdate" action="{{ route('wps-individual-details-update', $details->id) }}" method="POST">
    {{ method_field('PUT') }}
    {{ csrf_field() }}
</form>
<div class="container">
    <div class="card col-lg-12 mb-2">
        <div class="card-body">
                <div class="card-title mb-3">WPS Details</div>
                <div class="row mb-3">
                    <table class="table table-sm table-hover text-12 data_table_cls">
                        <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Company</th>
                            <th>Passport No</th>
                            <th>PP UID</th>
                            <th>Labour Card No</th>
                            <th>Default Payment Method</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td> {{ $details->full_name ?? "NA" }}</td>
                                <td> {{ $details->name ?? "NA"}} </td>
                                <td> {{ $details->passport_no?? "NA" }} </td>
                                <td> {{ $details->pp_uid ?? "NA" }} </td>
                                <td> {{ $details->labour_card_no ?? "NA"}}</td>
                                <td>
                                    @if( $details->cash_or_exchange == 1)
                                        Office Cash
                                    @elseif($details->cash_or_exchange == 2)
                                        Exchange Cash(Lulu)
                                    @elseif($details->cash_or_exchange == 3)
                                        C3 Card
                                    @elseif($details->cash_or_exchange == 4)
                                        Lulu Card
                                    @elseif($details->cash_or_exchange == 5)
                                        Bank
                                    @endif
                                </td>
                            </tr>
                        </tbody>

                    </table>
                </div>
                <input form="wpsUpdate" name="wps_type" type="hidden">
                @if(count($details->c_three_details) > 0)
                <div class="">C3 Card Details</div>
                <div class="row  mb-3">
                    <table class="table table-sm table-hover text-12 data_table_cls c-three-card">
                        <thead>
                        <tr>
                            <th>Card No</th>
                            <th>Code No</th>
                            <th>Expiry</th>
                            <th>Active</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($details->c_three_details as $obj)
                            <tr>
                                <td> {{ $obj->card_no ?? "NA" }}</td>
                                <td> {{ $obj->code_no ?? "NA"}} </td>
                                <td> {{ date('d-m-Y', strtotime($obj->expiry )) ?? "NA" }} </td>
                                <td>
                                    <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input form="wpsUpdate" data-id="c3" class="form-check-input" type="radio" name="wps_id" value="{{$obj->id}}" required
                                            @php if ($obj->id == $details->wps_payment_id) {
                                                echo "checked";
                                            }
                                            @endphp
                                        >
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endif

                @if(count($details->lulu_card_details) > 0)
                <div class="">Lulu Card Details</div>
                <div class="row  mb-3">
                    <table class="table table-sm table-hover text-12 data_table_cls lulu-card">
                        <thead>
                        <tr>
                            <th>Card No</th>
                            <th>Code No</th>
                            <th>Expiry</th>
                            <th>Active</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($details->lulu_card_details as $obj)
                            <tr>
                                <td> {{ $obj->card_no ?? "NA" }}</td>
                                <td> {{ $obj->code_no ?? "NA"}} </td>
                                <td> {{ date('d-m-Y', strtotime($obj->expiry )) ?? "NA" }} </td>
                                <td>
                                    <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input form="wpsUpdate" data-id="lulu" class="form-check-input" type="radio" name="wps_id" value="{{$obj->id}}" required
                                            @php if ($obj->id == $details->wps_payment_id) {
                                                echo "checked";
                                            }
                                            @endphp
                                        >
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endif

                @if(count($details->bank_details) > 0)
                <div class="">Bank Details</div>
                <div class="row  mb-3">
                    <table class="table table-sm table-hover text-12 data_table_cls bank">
                        <thead>
                        <tr>
                            <th>bank Name</th>
                            <th>IBAN No</th>
                            <th>Active</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($details->bank_details as $obj)
                            <tr>
                                <td> {{ $obj->bank_name ?? "NA" }}</td>
                                <td> {{ $obj->iban_no ?? "NA"}} </td>
                                <td>
                                    <div class="col-md-6 mt-2">
                                    <div class="form-check form-check-inline">
                                        <input form="wpsUpdate" data-id="bank" class="form-check-input" type="radio" name="wps_id" value="{{$obj->id}}" required
                                            @php if ($obj->id == $details->wps_payment_id) {
                                                echo "checked";
                                            }
                                            @endphp
                                        >
                                        <label class="form-check-label" for="inlineRadio1">Active</label>
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
                @endif
                <div><h5>Select Office Cash or Lulu</h5></div>
                <div class="form-check form-check-inline mb-2">
                    <input form="wpsUpdate" data-id="office" class="form-check-input" type="radio" name="wps_id" value="office_cash" required
                        @php if ($details->cash_or_exchange == 1) {
                            echo "checked";
                        }
                        @endphp
                    >
                <label class="form-check-label" for="inlineRadio1">Office Cash</label>
                </div><br>
                <div class="form-check form-check-inline mb-2">
                    <input form="wpsUpdate" data-id="exchange" class="form-check-input" type="radio" name="wps_id" value="exchange_cash" required
                    @php if ($details->cash_or_exchange == 2) {
                        echo "checked";
                    }
                    @endphp
                    >
                <label class="form-check-label" for="inlineRadio1">Exchange Cash (Lulu)</label>
                </div><br>
                <button form="wpsUpdate" type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</div>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
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

    $("input[name=wps_id]").on('change', function(e){
        var activeClass  =  $(this).attr('data-id');
        $("input[name='wps_type']").val(activeClass);
    });

</script>

@endsection
