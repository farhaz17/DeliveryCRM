<table id="datatable_checkup_modal" class="table  table-striped text-11">
    <thead>
    <tr>
        <th>Serial No</th>
        <th>Checkup Point</th>
        {{-- <th>Action</th> --}}
    </tr>
    </thead>
    <tbody>


    @foreach ($gamer_array as $obj)
    <tr>

       <td id="sn-{{$obj['sn']}}" > {{$obj['sn']}}</td>
        <td id="point-{{$obj['sn']}}" class="point_checkup">
            <span id="point_span-{{$obj['sn']}}"> {{$obj['point']}}</span>
            <input id="text1_input-{{$obj['sn']}}" class="new_point" name="change" value="asfd" style="display:none"/>
            <input id="text2_input-{{$obj['sn']}}" class="new_point" name="main_id" value="{{$obj['id']}}" style="display:none"/>
        </td>
    </tr>
@endforeach
    </tbody>
</table>
<script>


$( ".point_checkup" ).dblclick(function() {

        var edit_id= $(this).attr('id');
        var spli_val = edit_id.split("-");
         var final_id = spli_val[1];
         var input_val = $("#point-"+final_id).text();

$( "#point_span-"+final_id ).hide();
document.getElementById('text1_input-'+final_id).value = input_val;
$( "#text1_input-"+final_id ).show();
$( "#text1_input-"+final_id ).focus();

});


$(".new_point").focus(function() {
}).blur(function() {
    var edit_id= $(this).attr('id');
        var spli_val = edit_id.split("-");
         var final_id = spli_val[1];
         var input_val = $("#text1_input-"+final_id).val();
         var checkup_id = $("#text2_input-"+final_id).val();

$( "#text1_input-"+final_id).hide();
$("#point_span-"+final_id).text(input_val);
$( "#point_span-"+final_id).show();
// Here update the database
var new_point = input_val;
var key = final_id;
var token = $("input[name='_token']").val();
$.ajax({
            url: "{{ route('checkup_points_update') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {new_point:new_point,key:key, _token: token,checkup_id:checkup_id},

                });

})


$('.new_point').bind("enterKey",function(e){
    var edit_id= $(this).attr('id');
        var spli_val = edit_id.split("-");
         var final_id = spli_val[1];
         var input_val = $("#text1_input-"+final_id).val();
         var checkup_id = $("#text2_input-"+final_id).val();

$( "#text1_input-"+final_id).hide();
$("#point_span-"+final_id).text(input_val);
$( "#point_span-"+final_id).show();
// Here update the database
var new_point = input_val;
var key = final_id;
var token = $("input[name='_token']").val();
$.ajax({
            url: "{{ route('checkup_points_update') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {new_point:new_point,key:key, _token: token,checkup_id:checkup_id},

                });
});
$('.new_point').keyup(function(e){
if(e.keyCode == 13)
{
  $(this).trigger("enterKey");
}
});

</script>



