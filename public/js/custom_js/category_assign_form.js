var path = "autocomplete-fetch-category-assign-passport";
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
        }  else if(data.type==3){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +  data.name +  '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if (data.type==4){
            html += '<div class="col-lg-12 sugg-drop">';
            html += '<span id="drop-labour" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">'  + data.full_name  + '</span><span class="ml-1 id="drop-name">'  + data.passport  + '</span>';
            html += '<div><br></div>';
            html += '<div><hr></div>';
            html += '</div>';
        }

        return html;
    }
});

$(document).on('click', '.sugg-drop', function() {
    var token = $("input[name='_token']").val();
    var keyword = $(this).find('#drop-name').text();
    $.ajax({
        url: "category_assign_get_rider_details",
        method: 'POST',
        data:{passport_id:keyword,_token:token},
        success: function (response) {
            $("#pp_uid").html(response.pp_uid);
            $(".avatar img").attr('src',response.image);
            $("#passport_no").html(response.passport_no);
            $("#passport_id").val(response.passport_id);
            $("#driving_license").html(response.license_number);
            $("#full_name").text(response.name);
            $("#sim_card").html(response.sim_card);
            $("#main_cate").html(response.main_cate);
            $("#main_cate_arrow").css('display' , response.main_cate ? 'inline-block' : 'none');
            $("#sub_cate1").html(response.sub_cate1);
            $("#sub_cate1_arrow").css('display' , response.sub_cate1 ? 'inline-block' : 'none');
            $("#sub_cate2").html(response.sub_cate2).addClass('float-right');
        }
    });
});
