




  <div class="col-md-12">
    <div class="row">

            <div class="card" style="width: 100%">
                <div class="card-body">


                                <div class="table-responsive">
                                    <table class="table" id="datatable" width='100%'>
                                        <thead class="table-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Passport No</th>
                                                <th scope="col">PPUID</th>
                                                <th scope="col">Agreed Amount</th>
                                                <th scope="col">Amount Status</th>
                                                <th scope="col">Remarks</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $row )
                                        <tr>
                                            <td>{{$row['name']}}</td>
                                            <td>{{$row['pass_no']}}</td>
                                            <td>{{$row['pp_uid']}}</td>
                                            <td>{{$row['amount']}}</td>
                                            <td> @if($row['pay_status']=='1') <span class="badge badge-success m-2">Paid</span> @else <span class="badge badge-danger m-2">Unpaid</span>   @endif</td>
                                            <td>{{$row['remarks']}}</td>

                                        </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                            </div>
                        </div>
                     
                    </div>
    </div>
</div>
</div>

<script>
$(document).ready(function () {
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        var currentTab = $(e.target).attr('id'); // get current tab

        var split_ab = currentTab;
        // alert(split_ab[1]);

        if(split_ab=="home-basic-tab"){
            var table = $('#datatable').DataTable();
            $('#container').css( 'display', 'block' );
            table.columns.adjust().draw();
        }


        else{
            var table = $('#datatable2').DataTable();
            $('#container').css( 'display', 'block' );
            table.columns.adjust().draw();



        }
    }) ;
});

</script>
