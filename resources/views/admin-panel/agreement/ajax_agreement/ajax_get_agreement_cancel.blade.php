<div class="row">
    <div class="col-md-2">

    </div>

    <div class="col-md-8">
        <div class="table-responsive">
            <table class="table table-borderless">

                <tbody>
                <tr>
                    <th scope="row">Platform</th>
                    <td>
                        @if($platform == 'N/A')
                            <span><i class="fa fa-check-square"></i></span><br>
                        @else
                            <span><i class="fa fa-window-close"></i></span><br>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th scope="row">SIM</th>
                    <td>
                        @if($sim == 'N/A')
                            <span><i class="fa fa-check-square"></i></span><br>
                        @else
                            <span><i class="fa fa-window-close"></i></span><br>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th scope="row">Bike</th>
                    <td>
                        @if($bike == 'N/A')
                            <span><i class="fa fa-check-square"></i></span><br>
                        @else
                            <span><i class="fa fa-window-close"></i></span><br>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th scope="row">COD Remain amount</th>
                    <td>
                        {{$remain_amount}}
                    </td>
                </tr>

                <tr>
                    <th scope="row">AR Balance Amount</th>
                    <td>
                        {{$current_balance}}
                    </td>
                </tr>

                </tbody>
            </table>
        </div>

    </div>


    <div class="col-md-2">

    </div>
</div>




        <div class="row">
            <div class="col-md-12">
                @if($platform == 'N/A' &&  $sim == 'N/A' && $bike == 'N/A' && $remain_amount=='0.00' && $current_balance=='0' )

                    <form   action="{{url('agreement_cancel_save')}}"   method="post">
                        {!! csrf_field() !!}

                    <div class="col-md-12  mb-3">
                        <label for="repair_category">Cancellation Reason</label>
                        <select id="cancel_reason" name="cancel_reason" class="form-control form-control" required>
                            <option value="" selected disabled>Select Platform</option>
                            <option value="1">Reason 1</option>
                            <option value="2">Reason 2</option>
                            <option value="3">Reason 3</option>

                        </select>
                    </div>
                    <div class="col-md-12  mb-3">
                        <label for="repair_category">Cancellation Date</label>
                        <input type="date" class="form-control" autocomplete="off" required="" name="cancel_date" placeholder="dd-mm-YYYY" id="date_to_search">
                        <input type="hidden"  name="id" value="{{$id}}">
                    </div>
                        <div class="col-md-12  mb-3">
                            <label for="repair_category">Remarks</label>
                            <textarea  id="remarks" class="form-control" autocomplete="off" name="remarks" cols="5" rows="5" placeholder="Remarks"></textarea>
                        </div>
                    <div class="col-md-12 input-group  form-group mb-3">
                        <button class="btn btn-primary btn-sub" id="btn_date_search" type="submit">Cancel</button>
                    </div>
                    </form>
                @endif

            </div>
        </div>




