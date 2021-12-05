
var path = "autocomplete_fetch_complete_passport";
$('input.typeahead').typeahead({
    source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {

            return process(data);
        });
    },
    highlighter: function (item, data) {
        var parts = item.split('#'),
            html = '<div class="row drop-row">';
        if (data.type == 0) {
            html += '<div class="col-lg-12 sugg-drop">';
            html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
            html += '<div><br></div>';
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type == 1){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type==2){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +  data.name +  '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }  else if(data.type==2){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +  data.name +  '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==3){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==4){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==5)
        {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==6) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==7) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==8) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==9) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==10) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }

        return html;
    }
});

// $(document).on('click', '.sugg-drop', function(){
//     $("input[name='passport_id']").text("hello");
// });

// onclick suggestion list

$(document).on('click', '.sugg-drop', function(){
    var token = $("input[name='_token']").val();
    var keyword  =   $(this).find('#drop-name').text();

    console.log("hello")

    $.ajax({
        url: "get_passport_name_detail",
        method: 'POST',
        data:{passport_id:keyword,_token:token},
        success: function (response) {

            var  array = JSON.parse(response);
            $("input[name='passport_id']").val(array.id);

            $(".selected_passport").show();

            $("#pp_uid").html(array.pp_uid);
            $("#passport_no").html(array.passport_no);
            $("#full_name").html(array.name);
            $("#zds_code").html(array.zds_code);

            $("#passport_id").trigger('change');

        }
    });
});

$("#passport_id").change(function () {

    var token = $("input[name='_token']").val();
    var passport_id  =   $(this).val();

    $.ajax({
        url: "search_report_rider",
        method: 'POST',
        dataType: 'json',
        data:{passport_id:passport_id,_token:token},
        success: function (response) {

            $('#all-row').html('');
            $('#all-row').append(response.html);
            $('#all-row').show();

        }
    });

});

$(document).on('click', '#working_days_div', function(){

    $("#check_detail_modal_platform").modal('show');
    // var table2 = $('#datatable_platform').DataTable({
    //     paging: true,
    //     info: true,
    //     searching: true,
    //     autoWidth: false,
    //     retrieve: true
    // });
    //
    // table2.columns.adjust().draw();

});

$(document).on('click', '#sim_days_div', function(){

    $("#check_detail_modal_sim").modal('show');
    // var table2 = $('#datatable_platform').DataTable({
    //     paging: true,
    //     info: true,
    //     searching: true,
    //     autoWidth: false,
    //     retrieve: true
    // });
    //
    // table2.columns.adjust().draw();

});

$(document).on('click', '#bike_days_div', function(){

    $("#bike_detail_modal").modal('show');
    // var table2 = $('#datatable_platform').DataTable({
    //     paging: true,
    //     info: true,
    //     searching: true,
    //     autoWidth: false,
    //     retrieve: true
    // });
    //
    // table2.columns.adjust().draw();

});






