<style>

    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }
</style>
<table class="display table table-striped table-bordered" id="datatable" style="width: 100px">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Company</th>
        <th scope="col">PPUID</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">Account Number</th>
        <th scope="col">Party Id</th>
        <th scope="col">Product Type</th>
        <th scope="col">Invoice Number</th>
        <th scope="col">Invoice Date</th>
        <th scope="col">Service Rentals</th>
        <th scope="col">Usage Charges</th>
        <th scope="col">One Time Charges</th>
        <th scope="col">Other Credit And Charges</th>
        <th scope="col">VAT on Taxable Services</th>
        <th scope="col">Billed Amount</th>
        <th scope="col">Total Amount Due</th>
        <th scope="col">Amount To Pay</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
        <tr>


            <td>{{isset($row->sim_detail->get_current_sim->passport->agreement->fourpl_contractor->name)?$row->sim_detail->get_current_sim->passport->agreement->fourpl_contractor->name :"N/A"}}</td>
            <td>{{ $row->sim_detail->get_current_sim->passport->pp_uid ?$row->sim_detail->get_current_sim->passport->pp_uid :""}}</td>
            <td>{{ $row->sim_detail->get_current_sim->passport->zds_code->zds_code ?$row->sim_detail->get_current_sim->passport->zds_code->zds_code :""}}</td>
            <td>{{$row->acccount_no}}</td>
            <td>{{$row->party_id}}</td>
            <td>{{$row->product_type}}</td>
            <td>{{$row->invoice_number}}</td>
            <td>{{$row->invoice_date}}</td>
            <td>{{$row->service_rental}}</td>
            <td>{{$row->usage_charge}}</td>
            <td>{{$row->one_time_charges}}</td>
            <td>{{$row->other_credit_and_charges}}</td>
            <td>{{$row->vat_on_taxable_services}}</td>
            <td>{{$row->billed_amount}}</td>
            <td>{{$row->total_amount_due}}</td>
            <td>{{$row->amount_to_pay}}</td>

        </tr>
    @endforeach

    </tbody>
</table>



<script>
    $(document).ready(function () {

        'use strict';

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all'

                        }

                    }
                },
                'pageLength',
            ],
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });

    });





</script>
