
var path_gamer = path_autocomplete;
var checked_or_not = "0";

$('#keyword').typeahead({

    source:  function (query, process) {
        if($("#search_all_over").prop('checked') == true){
            checked_or_not = "1";
        }else{
            checked_or_not = "0";
        }

        return $.get(path_gamer, { query: query,checked_or_not: checked_or_not }, function (data) {

            return process(data);
        });
    },
    highlighter: function (item, data) {
        var parts = item.split('#'),
            html = '<div class="row drop-row">';
        if (data.type == 0) {
            html += '<div class="col-lg-12 sugg-drop">';
            html += '<span id="drop-name"  data-name="'+data.id+'" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.email + '</span> <span id="drop-zds_code" class="text-primary">' + data.whatsapp + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
            html += '<div><br></div>';
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type == 1){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" data-name="'+data.id+'" class="font-weight-bold">' + data.name + '</span> <span id="drop-ppuid" class="text-success">' + data.whatsapp + '</span> <span id="drop-zds_code" class="text-primary">' + data.phone + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +data.full_name+ '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type==2){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" data-name="'+data.id+'" class="font-weight-bold">' + data.name + '</span> <span id="drop-ppuid" class="text-success">' + data.email + '</span> <span id="drop-zds_code" class="text-primary">' + data.phone + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +  data.full_name +  '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }else if (data.type==3){
            html += '<div class="col-lg-12 sugg-drop" >';
            html += '<span id="drop-name" data-name="'+data.id+'" class="font-weight-bold">' + data.name + '</span> <span id="drop-ppuid" class="text-success">' + data.email + '</span> <span id="drop-zds_code" class="text-primary">' + data.phone + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name" class="font-weight-bold">'  + data.whatsapp + '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }


        return html;
    }
});

$(document).on('click', '.sugg-drop', function(){
    var token = $("input[name='_token']").val();
    var keyword  =   $(this).find('#drop-name').text();
    var ids =  $(this).find('#drop-name').data("name");

    var token = $("input[name='_token']").val();

    var action = $("#update_form").attr('action');

    var now_action = action.split("career/");

    var fina_url = now_action[0]+"career/"+ids;

    $("#update_form").attr('action',fina_url);

        $("#career_id").val(ids);

    $.ajax({
        url: get_information_path,
        method: 'POST',
        dataType: 'json',
        data: {primary_id: ids ,_token:token},
        success: function(response) {

            var len = 0;
            if(response['data'] != null){
                len = response['data'].length;
            }

            $(".already_pics").hide();

            if(len > 0){
                for(var i=0; i<len; i++){
                    var id = response['data'][i].id;
                    var name = response['data'][i].name;
                    var platform_code = response['data'][i].platform_code;

                    $("#phone").val("");
                    $("#whatsapp").val("");

                    // destroy_init("phone");
                    // destroy_init("whatsapp");

                   // var input = document.querySelector("#phone");
                   //
                   //  var iti = intlTelInput(input);
                   //  iti.setCountry("pk");


                    if(response['data'][i].phone_country_code!=""){
                        make_phone_country_code(response['data'][i].phone_country_code);
                    }else{
                        make_phone_country_code("");
                    }

                    if(response['data'][i].whatsapp_country_code!=""){
                        make_whatsapp_country_code(response['data'][i].whatsapp_country_code);
                    }else{
                        make_whatsapp_country_code("");
                    }

                    if(response['data'][i].refered_passport_name!=""){
                        $(".refer_by_div").show();
                        $("#refer_by_link").html(response['data'][i].refered_passport_name);
                        $("#refer_by_link").attr('href',response['data'][i].refer_passport_id);
                    }else{
                        $(".refer_by_div").hide();
                    }



                    $("#name").val(response['data'][i].name);
                    $("#email").val(response['data'][i].email);
                    $('#phone').val(response['data'][i].phone).trigger('change');

                    // $('#update_form').on('change', '#phone');

                    $('#phone').trigger('keydown');
                    // $("#phone").val(response['data'][i].phone);
                    $("#whatsapp").val(response['data'][i].whatsapp);
                    // $("#edit_facebook_html").val(response['data'][i].facebook);
                    $("#dob").val(response['data'][i].dob);


                    $("#company_employee_type").prop("checked",true);
                    $("#experience").val(response['data'][i].experience).trigger("change");
                    $("#exp_month").val(response['data'][i].exp_month).trigger("change");

                    $("#apply_for_bike").prop('checked',false);
                    $("#apply_for_car").prop('checked',false);
                    $("#apply_for_both").prop('checked',false);


                    if(response['data'][i].vehicle_type=="Bike"){
                        $("#apply_for_bike").prop('checked',true);
                    }else if(response['data'][i].vehicle_type=="Car"){
                        $("#apply_for_car").prop('checked',true);
                    }else if(response['data'][i].vehicle_type=="Both"){
                        $("#apply_for_both").prop('checked',true);
                    }

                    if(response['data'][i].medical_type=="1"){
                        $("#medical_company").prop('checked',true);
                    }else if(response['data'][i].medical_type=="2"){
                        $("#medical_own").prop('checked',true);
                    }else{
                        $("#medical_own").prop('checked',false);
                        $("#medical_company").prop('checked',true);
                    }




                    document.getElementById("licence_front_pic").value = null;
                    document.getElementById("licence_back_pic").value = null;


                    // $("#cv_attached_html").html(response['data'][i].cv);

                    $("#licence_yes").prop('checked',false);
                    $("#licence_no").prop('checked',false);
                    $("#licence_city").val(null).trigger('change');

                    if(response['data'][i].licence_status==1){
                        $("#licence_yes").prop('checked',true);
                        $(".driving_licence_div_cls").css('display','block');

                        $("#licence_number").val(response['data'][i].licence_no);
                        $("#licence_issue_date").val(response['data'][i].licence_issue);
                        $("#licence_expiry_date").val(response['data'][i].licence_expiry);
                        $("#traffic_no").val(response['data'][i].traffic_code_no);

                        $(".select2-container").css('width','100%');


                        if(response['data'][i].licence_city_id!=null){
                            var name_city = response['data'][i].licence_city_name;
                            var name_city_id = response['data'][i].licence_city_id;

                            var html = '<option value="'+name_city_id+'" selected>'+name_city+'</option>';

                            $("#licence_city").html(html);

                        }else{
                            $("#licence_city").html("");
                        }






                        if(response['data'][i].licence_attach!=""){
                            $(".already_pics").show();

                            $("#thumbnil_front_pic").attr('src',response['data'][i].licence_attach);
                            $("#thumbnil_front_back").attr('src',response['data'][i].licence_attach_back);
                          }


                    }else{
                        $("#licence_no").prop('checked',true);
                        $(".driving_licence_div_cls").css('display','none');

                        $("#licence_number").val("");
                        $("#licence_issue_date").val("");
                        $("#licence_expiry_date").val("");
                        $("#traffic_no").val("");
                    }

                    $("#license_have_bike").prop('checked',false);
                    $("#license_have_car").prop('checked',false);
                    $("#license_have_both").prop('checked',false);

                    if(response['data'][i].licence_status_vehicle==1){
                        $("#license_have_bike").prop('checked',true);
                    }else if(response['data'][i].licence_status_vehicle==2){
                        $("#license_have_car").prop('checked',true);
                    }else if(response['data'][i].licence_status_vehicle==3){
                        $("#license_have_both").prop('checked',true);
                    }

                    if(response['data'][i].company_visa=="1"){
                        $("#company_visa_yes").prop('checked',true);
                    }else if(response['data'][i].company_visa==2){
                        $("#company_visa_no").prop('checked',true);
                    }else{
                        $("#company_visa_yes").prop('checked',false);
                        $("#company_visa_no").prop('checked',false);
                    }

                    $('#platform_id').select2({
                        placeholder: 'Select an option'
                    });

                    $('#cities').select2({
                        placeholder: 'Select an option'
                    });


                    $("#platform_id").val(null).trigger('change');
                    $("#cities").val(null).trigger('change');

                    $("#nic_expiry").val(response['data'][i].nic_expiry);

                    $('#platform_id').val(response['data'][i].platform_id).trigger("change");
                    $('#cities').val(response['data'][i].cities).trigger("change");
                    $('#national_id').val(response['data'][i].nation_id).trigger("change");

                    $("#nationality").val(response['data'][i].nationality);

                    $("#passport_no").val(response['data'][i].passport_no);
                    $("#passport_expiry").val(response['data'][i].passport_expiry);
                    // $("#passport_attach_html").html(response['data'][i].passport_attach);


                    $("#visa_status_visit").prop("checked",false);
                    $("#visa_status_cancel").prop("checked",false);
                    $("#visa_status_own").prop("checked",false);

                    $(".edit_visa_visit_block").hide();
                    $(".edit_own_visit_block").hide();
                    $(".edit_cancel_visit_block").hide();

                    $("#visa_status_html").html(response['data'][i].visa_status);

                    $("#visit_exit_date").val("");
                    $("#cancel_fine_date").val("");

                    if(response['data'][i].visa_status==1){
                        $("#visa_status_visit").prop('checked',true);
                        $("#waiting_cancellation").prop("checked",false);
                        $(".visit_visa_status_cls").show();
                        $(".cancel_visa_status_cls").hide();
                        $(".own_visa_status_cls").hide();

                        if(response['data'][i].visa_status_visit==1){
                            $("#visit_one_month").prop("checked",true);
                        }else if(response['data'][i].visa_status_visit==2){
                            $("#visit_three_month").prop("checked",true);
                        }
                        $("#visit_exit_date").val(response['data'][i].exit_date);

                    }else if(response['data'][i].visa_status==2){
                        $("#visa_status_cancel").prop('checked',true);
                        $("#waiting_cancellation").prop("checked",false);
                        $(".cancel_visa_status_cls").show();
                        $(".visit_visa_status_cls").hide();
                        $(".own_visa_status_cls").hide();

                        if(response['data'][i].visa_status_cancel==1){
                            $("#cancel_free_zone").prop("checked",true);
                        }else if(response['data'][i].visa_status_cancel==2){
                            $("#cancel_company_visa").prop("checked",true);
                        }else if(response['data'][i].visa_status_cancel==3){
                            $("#cancel_waiting_cancel").prop("checked",true);
                        }
                        $("#cancel_fine_date").val(response['data'][i].exit_date);


                    }else if(response['data'][i].visa_status==3){
                        $("#visa_status_own").prop('checked',true);
                        $("#waiting_cancellation").prop("checked",false);
                        $('input[type=radio][name=visa_status]').trigger('change');

                        $(".own_visa_status_cls").show();
                        $(".cancel_visa_status_cls").hide();
                        $(".visit_visa_status_cls").hide();

                        if(response['data'][i].visa_status_own==1){
                            $("#own_visa_noc").prop("checked",true);
                        }else if(response['data'][i].visa_status_own==2){
                            $("#own_visa_without_noc").prop("checked",true);
                        }

                    }else if(response['data'][i].visa_status==4){
                        $("#edit_visit_visa").prop("checked",false);
                        $("#cancel_visit_visa").prop("checked",false);
                        $("#own_visit_visa").prop("checked",false);
                        $("#waiting_cancellation").prop("checked",true);

                        $(".own_visa_status_cls").hide();
                        $(".cancel_visa_status_cls").hide();
                        $(".visit_visa_status_cls").hide();
                    }else{
                        $("#edit_visit_visa").prop("checked",false);
                        $("#cancel_visit_visa").prop("checked",false);
                        $("#own_visit_visa").prop("checked",false);
                        $('input[type=radio][name=visa_status]').trigger('change');

                        $(".own_visa_status_cls").hide();
                        $(".cancel_visa_status_cls").hide();
                        $(".visit_visa_status_cls").hide();
                    }

                    $("#promotion_type").val(null).trigger('change');
                    $("#social_id_name").val("");
                    $("#care_of").val(null).trigger('change');

                    if(response['data'][i].promotion_type!=""){
                        $("#promotion_type").val(response['data'][i].promotion_type).trigger('change');
                    }

                    if(response['data'][i].social_media_id_name!=""){
                        $("#social_id_name").val(response['data'][i].social_media_id_name);
                    }

                    if(response['data'][i].care_of!=null){
                        var name_optoin = response['data'][i].care_of_name;
                        var name_optoin_value = response['data'][i].care_of;

                        var html = '<option value="'+name_optoin_value+'" selected>'+name_optoin+'</option>';

                        $("#care_of").html(html);

                    }else{
                        $("#care_of").html("");
                    }

                    if(response['data'][i].passport_id!=null){
                        $('.visa_status_div').find('input, textarea, button, radio, select').attr('disabled','disabled');
                        $(".visa_status_div").addClass('color-overlay');
                    }else{
                        $('.visa_status_div').find('input, textarea, button, radio, select').attr('disabled',false);
                        $(".visa_status_div").removeClass('color-overlay');
                    }
                    if(response['data'][i].remarks!=null){
                        $("#remarks").text(response['data'][i].remarks);
                    }else{
                        $("#remarks").text(response['data'][i].remarks);
                    }

                    if(response['data'][i].physical_documents!=null){
                        // var len_now = response['data'][i].physical_documents.length;
                        // var servers = parseJSON(response['data'][i].physical_documents);

                        $.each(response['data'][i].physical_documents, function(idx, obj) {
                            // alert(obj.tagName);
                            console.log("ashir"+obj.name);

                            $(".existing_physical_doc").append(make_physical_doc_name(obj.name));

                            var image_htmls = "";

                            $.each(obj.image, function (i, v) {
                                image_htmls +=  make_physical_doc_image(v);
                            });

                            $(".existing_physical_doc").append(make_div_physical_images(image_htmls));


                        });

                    }else{
                        $(".existing_physical_doc").html("");
                    }




                }
            }

        }
    });





});

var path = only_passport_suggest;


$('input.typeahead_passport').typeahead({
    source:  function (query, process) {
        return $.get(path, { query: query}, function (data) {

            return process(data);
        });
    },
    highlighter: function (item, data) {
        var parts = item.split('#'),
            html = '<div class="row drop-row">';
        if (data.type == 0) {
            html += '<div class="col-lg-12 sugg-drop_only_passport">';
            html += '<span id="drop-name_two"  data-name="'+data.id+'" class="font-weight-bold">' + data.name+'</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
            html += '<div><br></div>';
            html += '<div><hr></div>';
            html += '</div>';
        }
        else if(data.type == 1){
            html += '<div class="col-lg-12 sugg-drop_only_passport" >';
            html += '<span id="drop-name_two" data-name="'+data.id+'" class="font-weight-bold">' + data.name + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +data.full_name+ '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }else if (data.type==3){
            html += '<div class="col-lg-12 sugg-drop_only_passport" >';
            html += '<span id="drop-name_two" data-name="'+data.id+'" class="font-weight-bold">' + data.name + '</span>';
            html += '<div><br></div>';
            html += '<span id="drop-full_name">' +data.full_name+ '</span>';
            html += '<div><br></div>'
            html += '<div><hr></div>';
            html += '</div>';
        }


        return html;
    }
});


$(document).on('click', '.sugg-drop_only_passport', function(){

    var keyword  =   $(this).find('#drop-name_two').text();



    $.ajax({
        url: ajax_check_the_passport_info,
        method: 'GET',
        data: {passport_no: keyword},
        success: function(response) {
                $("#msg_passport").html(response);
                $("#status_passport_modal").modal('show');

        }
    });
});

$("#passport_no").change(function(){

    var keyword  =   $(this).val();
    aler

    $.ajax({
        url: ajax_check_the_passport_info,
        method: 'GET',
        data: {passport_no: keyword},
        success: function(response) {
                $("#msg_passport").html(response);
                $("#status_passport_modal").modal('show');

        }
    });

});
