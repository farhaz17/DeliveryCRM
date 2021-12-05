<div class="card card-profile-1">
    <div class="card-body text-center">
        <h5 class="">{{$name}}</h5>
        <p class=""> <span class="badge badge-danger">{{$ppuid}}</span></p>
        <p><span class="badge badge-primary">{{$passport_no}}</span></p>
        <p>@if($pay_roll!='')  <span class="badge badge-info"> Payrolled Agreed Amount = {{$pay_roll}} </span> @endif                                                                                                                   </p>

    </div>
</div>
<div class="row">
 <div class="col-md-2"></div>
 <div class="col-md-8"> <table class="table table-bordered" id="datatable_as_detail" style="width: 100%">
    <thead class="thead-dark bg-dark text-white" >
    <tr style="font-size: 13px">
        <th scope="col">Visa Process Step</th>
        <th scope="col">Amount</th>
        <th scope="col">Status</th>
        <th scope="col">Unpaid Status</th>
        <th scope="col">Remarks</th>
    </tr>
    </thead>
    <tbody>
    @foreach($assgin_amount as $res)
        <tr style="font-size: 13px">
            <td>
                @if ($res->master_step_id != null)
                {{isset($res->master->step_name)?$res->master->step_name:""}}
                    @else
                    <b> Renewed Visa Process - {{isset($res->master_renew->step_name)?$res->master_renew->step_name:""}}</b>
                @endif


                </td>
                </b>
            <td >
               <b>
                   {{isset($res->amount)?$res->amount:'0'}}
            </b>
            </td>
            <td>
                @if ($res->pay_status == '1')
                <span class="badge badge-success m-2">Paid</span>
                    @elseif ($res->pay_status == '2')
                    <span class="badge badge-danger m-2">Not Paid</span>
                    @else
                    <span class="badge badge-primary m-2">Pending</span>
                @endif
            </td>
                <td>
                    @if ($res->unpaid_status == '1' )
                    <span class="badge badge-success m-2"> Will Pay At {{isset($res->pay_later->step_name)?$res->pay_later->step_name:""}}</span>
                        @elseif ($res->pay_status == '2')
                        <span class="badge badge-success m-2"> Payroll Deduction</span>
                        @else
                        <span class="badge badge-primary m-2">N/A</span>
                    @endif
                </td>
             {{-- <td>{{isset($res->pay_later->step_name)?$res->pay_later->step_name:""}}</td> --}}
             <td><b>{{isset($res->remarks)?$res->remarks:'N/A'}} </b></td>
        </tr>
    @endforeach
    </tbody>

</table>
</div>
 <div class="col-md-2"></div>
</div>


{{-- <script>
    $(document).ready(function () {
        'use strict';

        $('#datatable_as_detail').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 5,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'A/R Balance Detail',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all'

                        }

                    }
                },
                'pageLength',
            ],

            "scrollY": true,
            "scrollX": true,
        });

    });
</script> --}}
