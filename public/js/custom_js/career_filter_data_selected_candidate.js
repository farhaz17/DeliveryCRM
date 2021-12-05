
$("#company_bike_btn").click(function () {
    $("#action_btn_click_filter").val("1");

    var action_btn =  $("#action_btn_click_filter").val();

    $(".company_visa_cls").removeClass('active_cls_visa');
    $(".company_apply_cls").removeClass('active_cls');
    $(this).addClass('active_cls');

    $(".company_visa_cls_div").hide(300);
    $(".company_visa_cls_div").show(500);


    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn, selected_company_only_apply:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });

    $(".company_visit_visa_cls_div").hide(300);
    $(".company_cancel_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").hide(300);

    $(".company_visit_visa_cls").removeClass("active_cls_visa");
    $(".company_cancel_visa_cls").removeClass("active_cls_visa");
    $(".company_own_visa_cls").removeClass("active_cls_visa");

    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_apply_for:"1",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#visit_visa_count").html(array.visit_visa_count);
            $("#cancel_visa_count").html(array.cancel_visa_count);
            $("#own_visa_count").html(array.own_visa_count);

        }
    });


});

$("#company_car_btn").click(function () {

    $(".company_visa_cls").removeClass('active_cls_visa');
    $(".company_apply_cls").removeClass('active_cls');
    $(this).addClass('active_cls');

    $("#action_btn_click_filter").val("2");

    var action_btn =  $("#action_btn_click_filter").val();

    $(".company_visa_cls_div").hide(300);
    $(".company_visa_cls_div").show(500);

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn, selected_company_only_apply:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });


    $(".company_visit_visa_cls_div").hide(300);
    $(".company_cancel_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").hide(300);

    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_apply_for:"1",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#visit_visa_count").html(array.visit_visa_count);
            $("#cancel_visa_count").html(array.cancel_visa_count);
            $("#own_visa_count").html(array.own_visa_count);

        }
    });

    $(".company_visit_visa_cls").removeClass("active_cls_visa");
    $(".company_cancel_visa_cls").removeClass("active_cls_visa");
    $(".company_own_visa_cls").removeClass("active_cls_visa");





});

$("#company_both_btn").click(function () {

    $(".company_visa_cls").removeClass('active_cls_visa');
    $(".company_apply_cls").removeClass('active_cls');
    $(this).addClass('active_cls');

    $("#action_btn_click_filter").val("3");

    var action_btn =  $("#action_btn_click_filter").val();

    $(".company_visa_cls_div").hide(300);
    $(".company_visa_cls_div").show(500);

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn, selected_company_only_apply:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });

    $(".company_visit_visa_cls_div").hide(300);
    $(".company_cancel_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").hide(300);

    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_apply_for:"1",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#visit_visa_count").html(array.visit_visa_count);
            $("#cancel_visa_count").html(array.cancel_visa_count);
            $("#own_visa_count").html(array.own_visa_count);

        }
    });

    $(".company_visit_visa_cls").removeClass("active_cls_visa");
    $(".company_cancel_visa_cls").removeClass("active_cls_visa");
    $(".company_own_visa_cls").removeClass("active_cls_visa");
});

$("#company_visit_visa").click(function(){
    var action_btn = $("#action_btn_click_filter").val();

    $(".company_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,only_visa_status:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("1");
    $(".company_cancel_visa_cls_div").hide();
    $(".company_own_visa_cls_div").hide();

    $(".company_visit_visa_cls_div").hide(300);
    $(".company_visit_visa_cls_div").show(500);


    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_visa_status:"1",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#one_month_count").html(array.one_month_count);
            $("#three_month_count").html(array.three_month_count);


        }
    });


    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(".company_visit_visa_cls").removeClass('active_cls_visa');
    $(".company_own_visa_cls").removeClass('active_cls_visa');


});


$("#company_visit_one_month_btn").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_visit_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"1",visa_month:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("1");
    $(".company_visit_visa_cls_div").show(300);
    $(".company_visit_visa_cls_div").show(500);
    $(".company_cancel_visa_cls_div").hide();

});


$("#company_visit_three_month").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_visit_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"1", visa_month:"2", tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("1");
    $(".company_visit_visa_cls_div").show(300);
    $(".company_visit_visa_cls_div").show(500);
    $(".company_cancel_visa_cls_div").hide();


});



$("#company_cancel_visa").click(function (){

    var action_btn = $("#action_btn_click_filter").val();

    $(".company_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        dataType: 'json',
        data: {type:"selected_company", apply_for:action_btn,only_visa_status:"2",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });

    $("#action_btn_visa_filter").val("2");
    $(".company_visit_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").hide(300);

    $(".company_cancel_visa_cls_div").hide(300);
    $(".company_cancel_visa_cls_div").show(500);


    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_visa_status:"2",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#free_zone_count").html(array.free_zone_count);
            $("#company_visa_count").html(array.company_visa_count);
            $("#waiting_cancellation_count").html(array.waiting_cancellation_count);

        }
    });

    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(".company_visit_visa_cls").removeClass('active_cls_visa');
    $(".company_own_visa_cls").removeClass('active_cls_visa');


});



$("#company_cancel_free_zone").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"2",cancel_type:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("2");
    $(".company_cancel_visa_cls_div").show(300);
    $(".company_cancel_visa_cls_div").show(500);

});

$("#company_cancel_company_visa").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"2",cancel_type:"2",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("2");
    $(".company_cancel_visa_cls_div").show(300);
    $(".company_cancel_visa_cls_div").show(500);

});

$("#company_cancel_waiting_cancel").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"2",cancel_type:"3",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("2");
    $(".company_cancel_visa_cls_div").show(300);
    $(".company_cancel_visa_cls_div").show(500);

});





$("#company_own_visa").click(function(){


    var action_btn = $("#action_btn_click_filter").val();
    $(".company_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');


    $.ajax({
        url: carer_filter_data,
        type: "GET",
        data: { type:"selected_company",apply_for: action_btn,only_visa_status:"3",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });

    $("#action_btn_visa_filter").val("3");
    $(".company_visit_visa_cls_div").hide(300);
    $(".company_cancel_visa_cls_div").hide(300);

    $(".company_cancel_visa_cls").removeClass('active_cls_visa');
    $(".company_visit_visa_cls").removeClass('active_cls_visa');
    $(".company_own_visa_cls").removeClass('active_cls_visa');


    $.ajax({
        url: carer_filter_data_count,
        method: 'get',
        data: {type:"selected_company",apply_for: action_btn, only_visa_status:"3",tab:"1"},
        success: function(response) {
            var  array = JSON.parse(response);


            $("#noc_count").html(array.noc_count);
            $("#without_noc_count").html(array.without_noc_count);


        }
    });

    $(".company_own_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").show(300);



});

$("#company_own_noc").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_own_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"3",own_visa_type:"1",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("3");

    $(".company_own_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").show(500);

});

$("#company_own_without_no").click(function(){
    var action_btn = $("#action_btn_click_filter").val();
    var action_btn_visa_filter = $("#action_btn_visa_filter").val();

    $(".company_own_visa_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company",apply_for: action_btn,visa_status:"3",own_visa_type:"2",tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });
    $("#action_btn_visa_filter").val("3");

    $(".company_own_visa_cls_div").hide(300);
    $(".company_own_visa_cls_div").show(500);

});

 // four pl work start



$("#four_pl_bike_btn").click(function (){

    $(".four_pl_apply_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        dataType: 'json',
        data: {type:"selected_fourpl", apply_for:"1",fourpl_only_apply:"1",tab:"2"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career_referals",response.html);

        }
    });

});

$("#four_pl_car_btn").click(function (){



    $(".four_pl_apply_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url: carer_filter_data,
        dataType: 'json',
        data: {type:"selected_fourpl", apply_for:"2",fourpl_only_apply:"1",tab:"2"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career_referals",response.html);

        }
    });
});

$("#four_pl_both_btn").click(function (){

    $(".four_pl_apply_cls").removeClass('active_cls_visa');
    $(this).addClass('active_cls_visa');

    $.ajax({
        url:  carer_filter_data,
        dataType: 'json',
        data: {type:"selected_fourpl", apply_for:"3",fourpl_only_apply:"1",tab:"2"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career_referals",response.html);

        }
    });
});


// pkg dropdown filter work start


$("#first_pkg").change(function () {

    var pkg_id = $(this).val();



    $.ajax({
        url: filter_data_for_package,
        type: "GET",
        dataType: 'json',
        data: { type:"selected_company", pkg_id:pkg_id,tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career",response.html);

        }
    });

});

$("#second_pkg").change(function () {

    var pkg_id = $(this).val();



    $.ajax({
        url: filter_data_for_package,
        type: "GET",
        dataType: 'json',
        data: { type:"fourpl_rider", pkg_id:pkg_id,tab:"1"},
        success: function(response)
        {
            $("body").removeClass("loading");
            make_table_search_table("datatable_career_referals",response.html);

        }
    });

});


//pkg dropwdown filter work end
