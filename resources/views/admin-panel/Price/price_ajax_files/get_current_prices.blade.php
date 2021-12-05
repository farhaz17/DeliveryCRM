<div class="card text-left">
    <div class="card-body">
        <div class="table-responsive">
            <table  id="datatable" class="table table-sm table-hover table-striped text-11 data_table_cls " >

                <thead class="thead-dark">
                <tr>
                    <th scope="col">Serial No</th>
                    <th scope="col">Part No</th>
                    <th scope="col">Part Number</th>
                    <th scope="col">Current Price</th>
                    <th scope="col">Prices Added Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>


                </tr>
                </thead>
                <tbody>
                    <?php $count =0; ?>
                @foreach($current_price   as $row)
                    <tr>

                        <th scope="row">{{$count}}</th>
                        <td>{{$row->parts->part_name}}</td>
                        <td>{{$row->parts->part_number}}</td>
                        <td>{{$row->price}}</td>
                        <td>{{$row->updated_at}}</td>
                        <td>

                            <label class="switch">
                                <input id="{{$row->id}}" class="status"  type="checkbox"  @if($row->status==0) checked @else unchecked @endif>
                                <span class="slider round"></span>
                            </label>
                    </td>

                    <td>
                        <a class="text-success mr-2" href="{{route('price.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                    </td>


                    </tr>
                    <?php $count = $count+1; ?>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>

    $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 5,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });
</script>

<script>
    $(".status").change(function(){
        if($(this).prop("checked") == true){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            var status = '0';
            $.ajax({
                url: "{{ route('activate_deactivate') }}",
                method: 'POST',
                data: {id: id, _token:token,status:status},
                success: function(response) {

                }
            });

        }else{
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            var status = '1';
            $.ajax({
                url: "{{ route('activate_deactivate') }}",
                method: 'POST',
                data: {id: id, _token:token,status:status},
                success: function(response) {

                }
            });

        }
    });

</script>

