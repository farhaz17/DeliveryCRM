<div class="card text-left">
    <div class="card-body">
        <div class="table-responsive">
            <table  id="datatable" class="table table-sm table-hover table-striped text-11 data_table_cls " >

                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Check</th>
                    <th scope="col">Repair No</th>
                    <th scope="col">Chassis No</th>
                    <th scope="col">Plate No</th>
                    <th scope="col">Name</th>
                    {{-- <th scope="col">Company/Own</th> --}}
                    <th scope="col">Type</th>
                    <th scope="col">Priorty</th>
                    {{-- <th scope="col">Advised By</th> --}}
                    {{-- <th scope="col">Parts/Invoice</th> --}}


                    {{-- <th scope="col">Action</th> --}}
                </tr>
                </thead>
                <tbody>
                    <?php $count =0; ?>
                @foreach($manage_repairs as $manage_repair)
                    <tr>
                        <input type="hidden" id="chassis_no-{{$count}}" value="{{$manage_repair->bike->chassis_no}}">
                        <input type="hidden" id="plate_no-{{$count}}" value="{{$manage_repair->bike->plate_no}}">
                        <input type="hidden" id="full_name-{{$count}}" value="{{$manage_repair->passport->personal_info->full_name}}">
                        <input type="hidden" id="repair_id-{{$count}}" value="{{$manage_repair->id}}">
                        <th scope="row">1</th>
                        <td> <input  id="part-{{ $count }}" type="checkbox" name="checked" class="form-group checkbox-check part_checkbox" value="{{ $manage_repair->id }}"></td>

                        <td>{{$manage_repair->repair_no}}</td>
                        <td>{{$manage_repair->bike->chassis_no}}</td>
                        <td>{{$manage_repair->bike->plate_no}}</td>
                        <td>
                            {{$manage_repair->passport->personal_info->full_name}}
                        </td>
                        {{-- <td>{{($manage_repair->company_or_own == '0')?"Own":"Company"}}</td> --}}
                        <td>{{($manage_repair->type == '1')?"Walk In":"Break Down"}}</td>
                        <td>
                        @if ($manage_repair->priorty=='1')
                        <span class="badge badge-success font-weight-bold text-10 m-2"> <b>Low</b></span>
                        @elseif($manage_repair->priorty=='2')
                        <span class="badge badge-info font-weight-bold m-2 text-10"><b>Medium</b></span>
                        @else
                        <span class="badge badge-danger font-weight-bold m-2 text-10"><b> High</b></span>
                        @endif

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

    $("input:checkbox").on('click', function() {

      var $box = $(this);
      if ($box.is(":checked")) {

        var group = "input:checkbox[name='" + $box.attr("name") + "']";

        $(group).prop("checked", false);
        $box.prop("checked", true);
      } else {
        $box.prop("checked", false);
      }



    });
    </script>
    <script>
        $('.ajax_table_load').on('click', '.part_checkbox', function() {
          if($(this).prop("checked") == true){
            var data_id = $(this).attr('id');
              var splt_v = data_id.split("-");




              var chasis_no = $("#chassis_no-"+splt_v[1]).val();
              var plate_no = $("#plate_no-"+splt_v[1]).val();
              var full_name = $("#full_name-"+splt_v[1]).val();
              var repair_id = $("#repair_id-"+splt_v[1]).val();

//-------------------------------------------------
                var token = $("input[name='_token']").val();
                var url = '{{ route('get_repair_id') }}';
                  $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {_token: token,repair_id:repair_id},
                        success: function (response) {
                            if(response.code == 100){
                                $("#checkup_points").prop('disabled', false);
                                $("#add_to_list").prop('disabled', false);
                                $('#checkup_statuss').text("Checkup Not Added Yet");

                                $('.card-right').show();
                            }
                                else if(response.code == 102){

                                    $("#checkup_points").prop('disabled', false);
                                    $("#add_to_list").prop('disabled', false);
                                    $('#checkup_statuss').text("Checkup Not Added Yet");
                                    $('.card-right').show();
                                }
                            else{
                                $("#checkup_points").prop('disabled', true);
                                $("#add_to_list").prop('disabled', true);
                                $('#checkup_statuss').text("Checkup Added");

                                $('.card-right').show();

                            }
                        }
                    });
                    //------------------------------------------

                    //-------------------------------------------------
                var token = $("input[name='_token']").val();
                var url = '{{ route('get_manage_repar_id') }}';
                  $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {_token: token,repair_id:repair_id},
                        success: function (response) {
                            if(response.code == 100){
                                $("#parts_id").prop('disabled', false);
                                $("#comments").prop('disabled', false);
                                $("#manage_repair_del_btn").prop('disabled', false);
                                $('#manage_repair_current_status').text("Manage Repair Not Added Yet");
                                $('.card-right').show();

                            }

                            else if(response.code == 102){
                                $("#parts_id").prop('disabled', false);
                                $("#comments").prop('disabled', false);
                                $("#manage_repair_del_btn").prop('disabled', false);
                                $('#manage_repair_current_status').text("Manage Repair Not Added Yet");
                                $('.card-right').show();

                            }
                            else{
                                $("#parts_id").prop('disabled', true);
                                $("#comments").prop('disabled', true);
                                $('#manage_repair_current_status').text("Manage Repair Added");
                                $('.card-right').show();
                            }
                        }

                    });
                    //------------------------------------------


              $("#checkup_bike").text(plate_no);
              $("#checkup_chassis").text(chasis_no);
              $("#checkup_name").text(full_name);
              $('input[name=repair_id_checkup]').val(repair_id);



              $("#checkup_bike2").text(plate_no);
              $("#checkup_chassis2").text(chasis_no);
              $("#checkup_name2").text(full_name);
              $('input[name=repair_id_manage_repair]').val(repair_id);
              $('.card-left').show();


          }
            });
    </script>
