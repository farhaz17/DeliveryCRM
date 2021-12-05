
    <table class="display table table-striped table-bordered table-sm text-10" id="datatable2" width="100%">
    <thead>
    <tr>

        <th scope="col">&nbsp</th>
        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
        <th scope="col">Fine State/Days Remaining</th>
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
    {{-- @if($row['visa_status']=='1') --}}
        <tr>
            <td class="details-control">
                <button class="btn btn-success btn-icon rounded-circle m-1 gone" style="font-size: 16px" id="go-{{ $row['passport_id'] }}"  type="button">
                    <span class="ul-btn__icon"><i class="i-Add" id="ico-{{ $row['passport_id'] }}"></i></span>
                </button>
               </td>

            <td>
                {{$row['name']}}
                <div id='nested_table-{{$row['passport_id']}}'  style="display: none; margin-top:5px; margin-bottom:5px" >

                </div>
            </td>
            <td> {{$row['pass_no']}}</td>
            <td> {{$row['pp_uid']}}</td>

            <td> {{$row['fine_start']}}</td>
            <td> {{$row['agreed_amount']}}</td>
            <td> {{$row['advance_amount']}}</td>
            <td> {{$row['discount_details']}}</td>
            <td> {{$row['final_amount']}}</td>
            <td> {{$row['payroll_deduct_amount']}}</td>
            <td>
                @if($row['career_id']!='N/A')
                <button class="btn btn-success btn-s  btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                 data-target=".bd-example-modal-lg3" onclick="startVisa3({{$row['career_id']}})" id="start-{{ $row['career_id'] }}"
                  type="button">
                  Start
                </button>
                @else
                <button class="btn btn-success btn-s  btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                 data-target=".bd-example-modal-lg4" onclick="startVisa4({{$row['passport_id']}})" id="start-{{ $row['passport_id'] }}"
                  type="button">
                  Start
                </button>
                @endif
            </td>
        </tr>
        {{-- @endif --}}
    @endforeach



    </tbody>
</table>

       <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable2').DataTable( {
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
                                page : 'all',
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
        <script>
            $(document).ready(function(){

                $(".gone").button().click(function(){
                var data_id = $(this).attr('id');
                var splt_v = data_id.split("-");

                //  alert(splt_v[1]);

                 if($("#nested_table-"+splt_v[1]).is(":visible")){
                    $('#nested_table-'+splt_v[1]).empty();
                    $("#nested_table-"+splt_v[1]).hide();
                    $('#ico-'+splt_v[1]).addClass("i-Add");
                    $('#go-'+splt_v[1]).removeClass("btn-danger");
                    $('#go-'+splt_v[1]).addClass("btn-success");


                 }
                 else{
                    var url = '{{ route('get_nested_info_visa_process_report', ":id") }}';
                    var token = $("input[name='_token']").val();

                $.ajax({
                            url: url,
                            method: 'POST',
                            dataType: 'json',
                            data: {id: splt_v[1], _token: token},
                            success: function (response) {
                                $('#nested_table-'+splt_v[1]).empty();
                                $('#nested_table-'+splt_v[1]).append(response.html);
                                $('#ico-'+splt_v[1]).addClass("i-Close");
                                $('#go-'+splt_v[1]).removeClass("btn-success");
                                $('#go-'+splt_v[1]).addClass("btn-danger");
                                $("#nested_table-"+splt_v[1]).show();
                            }
                        });
                 }
        });

            });



        </script>

