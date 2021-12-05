<div class="table-responsive">
    <table class="table table-sm table-striped table-bordered text-11" id="cash_cod" style="width:100%;">
        <thead>
            <tr>
                <th>Rider Id</th>
                <th>Name</th>
                <th>Date</th>
                {{-- <th>Time</th> --}}
                <th class="text-right">Amount</th>
                @if(auth()->user()->hasRole(['Admin', 'Cod Admin']))
                    <th class="text-center">Actions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($careem_cods as $cod)
                <tr>
                    <td>{{ $cod->passport->careem_plateform_code->platform_code}}</td>
                    <td>{{ $cod->passport->personal_info->full_name}}</td>
                    <td>{{ $cod->date ? dateToRead($cod->date) : '' }}</td>
                    {{-- <td>{{ $cod->time }}</td>
                    <td>{{ $cod->time ? date('h:m a',strtotime($cod->time)) : '' }}</td> --}}
                    <td class="text-right">{{ number_format($cod->amount, 2)  }}</td>
                    @if(auth()->user()->hasRole(['Admin', 'Cod Admin']))
                        <td class="text-center">
                            <a class="text-success mr-2 data-cash_cod_edit"
                                    data-cash_cod_id="{{  $cod->id }}"
                                    data-passport_id="{{  $cod->passport_id }}"
                                    data-rider_name="{{ $cod->passport->personal_info->full_name }}"
                                    data-date="{{  $cod->date }}"
                                    data-amount="{{  $cod->amount }}"
                                    data-toggle="modal"
                                    data-target="#UpdateCareemCashCODCenter"
                                >
                                <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                            </a>
                            <button type="submit" data-form_id='careem_cash_cod_id_{{$cod->id}}' class="text-danger mr-2 btn btn-link alert-confirm">
                                <i class="nav-icon i-Close-Window font-weight-bold"  data-form_id='careem_cash_cod_id_{{$cod->id}}'></i>
                            </button>
                            <form action="{{route('careem_delete_cash_cod')}}" method="post" id='careem_cash_cod_id_{{$cod->id}}'>
                                @csrf
                                <input type="hidden" name="careem_cash_cod_id" value="{{ $cod->id }}">
                                <input type="hidden" name="start_date" value="{{request('start_date')}}">
                                <input type="hidden" name="end_date" value="{{request('end_date')}}">
                            </form>
                        </td>
                    @endif
                </tr>
           @endforeach
        </tbody>
    </table>
      <!-- Modal for Careem Cash COD update -->
  <div class="modal fade" id="UpdateCareemCashCODCenter" role="dialog" aria-labelledby="UpdateCareemCashCODCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="UpdateCareemCashCODLongTitle">Update Careem Cash COD ( <span id="rider_name"></span> )</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{ route('careem_update_cash_cod') }}" id="careem_update_cash_cod_form">
                @csrf
                @method('put')
                <input type="hidden" name="start_date" value="{{request('start_date')}}">
                <input type="hidden" name="end_date" value="{{request('end_date')}}">
                <div class="row">
                    {{-- <div class="col-md-12 form-group">
                        <label for="passport_id">Careem Riders</label>
                        <select name="passport_id" id="passport_id" class="form-control form-control-sm select2">
                            <option value="">Select Careem Riders</option>
                            @foreach ($carrem_riders as $rider)
                                <option value="{{ $rider->id }}">PPUID: {{ $rider->pp_uid }} | Name: {{ $rider->personal_info->full_name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    <input type="hidden" name="careem_cash_cod_id" id="careem_cash_cod_id" >
                    <div class="col-md-6 form-group">
                        <label for="date">Date</label>
                        <input class="form-control form-control-sm" id="date" name="date" type="date" placeholder="Enter Date" value="{{ date("Y-m-d") }}" required />
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="amount">Amount </label>
                        <input class="form-control form-control-sm" id="amount" name="amount" type="number" placeholder="Enter Amount" step="0.01" required/>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" form="careem_update_cash_cod_form" class="btn btn-primary">Update careem cash cod</button>
        </div>
      </div>
    </div>
  </div>
<!-- Modal for Careem Cash COD update -->
</div>
<script>
    $('.data-cash_cod_edit').click(function(){
        $('#careem_cash_cod_id').val($(this).attr('data-cash_cod_id'));
        $('#date').val($(this).attr('data-date'));
        $('#amount').val($(this).attr('data-amount'));
        $("#passport_id").val($(this).attr('data-passport_id'));
        $("#rider_name").text($(this).attr('data-rider_name'));
    });
</script>
<script>
    $(document).ready(function () {
        'use strict';
        $('#cash_cod').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "10%"}
            ],
            scrollY: 300,
            responsive: true,
        });
    });
</script>
