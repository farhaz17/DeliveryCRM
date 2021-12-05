<style>
    .col.company-details.float-right {
        position: relative;
        left: 1176px;
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

<table class="table table-bordered table-striped" id="datatable_ar_detail" style="width: 100%">
    <thead class="thead-dark bg-dark text-white" >
    <div class="col company-details float-right">
        <h2 class="name">
            <a target="_blank">
                {{$name}}
            </a>
        </h2>
        <div></div>

        <div><b>PPUID:</b> &nbsp&nbsp&nbsp {{$ppuid}}</div>

        <div><b>Opening Balance:</b> &nbsp&nbsp&nbsp {{$opening_balance}}</div>
        <div><b>Current Balance:</b> &nbsp&nbsp&nbsp {{$current_bal}}</div>
        <div>
            <a  href="{{route('ar_balance_third_pdf',['date_from'=>$date_from,'date_to'=>$date_to,'zds_code'=>$ppuid])}}" target="_blank"><i class="fa fa-print"></i></a>
        </div>
    </div>

        <tr style="font-size: 13px">



            <th scope="col">Platform </th>
            <th scope="col">Date </th>
            <th scope="col">Description</th>
            <th scope="col">Amount </th>
            <th scope="col">Addition</th>
            <th scope="col">Subtraction</th>
            <th scope="col">Balance</th>
        </tr>
        </thead>
        <tbody>
        <?php
        //      $current_balance=$first_balance->balance;
        ?>
        @foreach($statement as $res)
            <tr style="font-size: 13px">
                <td>{{$res['platform']}}</td>
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
<br>


<script>
    $(document).ready(function () {
        'use strict';

        $('#datatable_ar_detail').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 5,
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
