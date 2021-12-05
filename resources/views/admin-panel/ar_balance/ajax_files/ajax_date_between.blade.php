<style>
    .col.company-details.float-right {
        position: relative;
        left: 11px;
    }
    i.fa.fa-print {
        font-size: 20px;
    }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 800;
    }
    .dataTableLayout {
        table-layout:fixed;
        width:100%;
    }
</style>

<div class="col company-details float-right mb-3">
    <a  href="{{route('ar_balance_second_pdf',['date_from'=>$date_from,'date_to'=>$date_to])}}" target="_blank"><i class="fa fa-print"></i></a>
</div>
<br>

<div class="table-responsive">
    <table class="display table table-striped table-bordered" id="datatable3"  style="width: 100%">
        <thead class="thead-dark bg-dark text-white" >
        <tr style="font-size: 13px">
            <th scope="col">PPID</th>
            <th scope="col">Platform </th>
            <th scope="col">Name</th>
            <th scope="col">Date </th>
            <th scope="col">Description</th>
            <th scope="col">Amount </th>
            <th scope="col">Addition</th>
            <th scope="col">Subtraction</th>
            <th scope="col">Balance</th>
        </tr>
        </thead>
        <tbody>

        @foreach($statement as $res)
            <tr style="font-size: 13px">


                <td>{{$res['ppuid']}}</td>
                <td>{{$res['platform']}}</td>
                <td>{{$res['name']}}</td>
                <td>{{$res['date']}}</td>
                <td>{{$res['description']}}</td>
                <td>{{$res['amount']}}</td>
                <td>{{$res['addition']}}</td>
                <td>{{$res['subs']}}</td>
                <td>{{$res['balance']}}</td>

            </tr>

        @endforeach
        </tbody>
    </table>



</div>

<script>
    $(document).ready(function () {
        'use strict';

        $('#datatable3').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Date Between A/R Balance',
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
            ],
            "scrollY": true,
            "scrollX": true,
        });


    });

</script>

