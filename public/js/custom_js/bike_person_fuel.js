var path = web_url+"/autocomplete_passport_have_vehicle_only";
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

    $.ajax({
        url: web_url+"/get_passport_name_detail",
        method: 'POST',
        data:{passport_id:keyword,_token:token},
        success: function (response) {


            var  array = JSON.parse(response);
            $("#name_div").show();
            $("#name_passport").html(array.name);
            $("input[name='user_passport_id']").val(array.id);

        }
    });
});
