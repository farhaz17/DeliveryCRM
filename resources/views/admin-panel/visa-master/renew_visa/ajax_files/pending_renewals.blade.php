<table class="table table-striped tab-border mt-1" id="datatable-{{$step_id}}" width="100%">
    <thead class="thead-dark">
    <tr>
        <th scope="col">&nbsp</th>
        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
        <th scope="col">Agreed Amount</th>
        <th scope="col">Advance</th>
        <th scope="col">Discount</th>
        <th scope="col">Final</th>
        <th scope="col">Payrol Deduction</th>
        <th scope="col">Action</th>

    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)

        <tr>
            <td class="details-control">
                <button class="btn btn-s btn-success btn-icon rounded-circle m-1 gone" style="font-size: 16px" id="go-{{ $row['passport_id'] }}"  type="button">
                    <span class="ul-btn__icon"><i class="i-Add" id="ico-{{ $row['passport_id'] }}"></i></span>
                </button>
               </td>

            <td> {{$row['name']}}
                <div id='nested_table-{{$row['passport_id']}}'  style="display: none; margin-top:5px; margin-bottom:5px">

                </div>
            </td>
            <td> {{$row['pass_no']}}</td>
            <td> {{$row['pp_uid']}}</td>
            <td> {{$row['agreed_amount']}}</td>
            <td> {{$row['advance_amount']}}</td>
            <td> {{$row['discount_amount']}}</td>
            <td> {{$row['final_amount']}}</td>
            <td> {{$row['payroll_deduct_amount']}}</td>
                <td>
                    <a class="btn btn-primary btn-sm start-visa" href="{{ url('renew_visa_process') }}?passport_id={{$row['pass_no']}}" target="_blank">
                        @if($step_id=='9')
                        Completed Renewals
                        @else
                        Start Visa Process
                        @endif
                        </a>
                </td>
            </td>
        </tr>

    @endforeach



    </tbody>
</table>
