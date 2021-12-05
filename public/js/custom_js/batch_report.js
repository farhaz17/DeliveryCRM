
$('input.typeahead').typeahead({

    source:  function (query, process) {
        $(".overlay").css('z-index','999');
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
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>';
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type == 1){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type==2){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +  data.name +  '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        } else if (data.type==3){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==4){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.name + '</span> <span id="drop-ppuid" class="text-success">' + data.passport + '</span> <span id="drop-zds_code" class="text-primary">' + data.ppuid + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
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
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==6) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==7) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==8) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==9) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==10) {
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
            html += '<span id="type" style="display:none;">'  + data.type  + '</span>';
            html += '<span id="type_id"  style="display:none;">'  + data.id  + '</span>';
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
    var type =   $(this).find('#type').text();
    var id  =   $(this).find('#type_id').text();

    // console.log("type="+type);
    // console.log("id="+id);

    var type_now = type;

    if(type_now=="0" || type_now=="1" || type_now=="2" || type_now=="3"){
        type="passport";
    }else{
        type="career";
    }

    $(".overlay").css('z-index','999999');

    $.ajax({
        url: passport_detail_path,
        method: 'POST',
        data:{type_now:type ,primary_id:id ,_token:token},
        success: function (response) {
            $(".append_search_result").empty();


            // $(".append_search_result").append(response.html);
            $(".append_search_result").append(response.html);

        }
    });
});
