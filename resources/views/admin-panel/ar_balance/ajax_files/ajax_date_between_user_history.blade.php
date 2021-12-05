<style>
    .col.company-details.float-right {
        position: relative;
        left: 1176px;
    }
    i.fa.fa-print {
        font-size: 20px;
    }
</style>



    <table class="table table-bordered" id="datatable_ar_detail" style="width: 100%">
        <thead class="thead-dark bg-dark text-white" >
        <div class="col company-details float-right">
            <h5 class="name">
                <a target="_blank">
                    {{$name}}
                </a>
            </h5>
            <div></div>
            <divp><b>ZDS Code:</b> &nbsp&nbsp&nbsp {{$zds_code}}</divp>

            <div><b>Platform Code:</b> &nbsp&nbsp&nbsp {{$rider_id}}</div>
            <div><b>Opening Balance:</b> &nbsp&nbsp&nbsp {{$opening_balance}}</div>
            <div><b>Closing:</b> &nbsp&nbsp&nbsp {{$closing_balance}}</div>
{{--            <div>--}}
{{--                <a class="attachment_display" href="{{ $rout_first  }}"target="_blank"><i class="fa fa-print" target="_blank"></i></a>--}}
{{--            </div>--}}
        </div>


        <tr style="font-size: 13px">
            <th scope="col">Platform </th>
            <th scope="col">Date From</th>
            <th scope="col">Date To</th>
            <th scope="col">Description</th>
            <th scope="col">Addition</th>
            <th scope="col">Adjustment</th>
            <th scope="col">Subtraction</th>
            <th scope="col">Other</th>
            <th scope="col">Amount Paid</th>
            <th scope="col">Balance </th>
        </tr>
        </thead>
        <tbody>
        <?php

        //      $current_balance=$first_balance->balance;
        ?>
        @foreach($statement as $res)
            <tr style="font-size: 13px">


                <td>{{$res['platform']}}</td>
                <td>{{$res['date_from']}}</td>
                <td>{{$res['date_to']}}</td>
                <td>{{$res['description']}}</td>
                <td>{{$res['addition']}}</td>
                <td>{{$res['adjustment']}}</td>
                <td>{{$res['subs']}}</td>
                <td>{{$res['other']}}</td>
                <td>{{$res['amount_paid']}}</td>
                <td>{{$res['balance']}}</td>
                {{--                <td>{{$res['balance']}}</td>--}}


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

            "scrollY": true,
            "scrollX": true,
        });

    });
</script>
