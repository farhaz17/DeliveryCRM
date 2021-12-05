<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::resource('dc_request', 'DcRequest\DcRequestController');
    Route::get('autocomplete_checkin_platform','DcRequest\DcRequestController@autocomplete_checkin_platform')->name('autocomplete_checkin_platform');
    Route::get('request_for_teamleader','DcRequest\DcRequestController@request_for_teamleader')->name('request_for_teamleader');
    Route::get('request_for_checkout_defaulter_manager','DcRequest\DcRequestController@request_for_checkout_defaulter_manager')->name('request_for_checkout_defaulter_manager');

    Route::get('get_request_ajax','DcRequest\DcRequestController@get_request_ajax')->name('get_request_ajax');
    Route::get('checkout_type_report','DcRequest\DcRequestController@checkout_type_report')->name('checkout_type_report');
    Route::get('autocomplete_checkout_type_report','DcRequest\DcRequestController@autocomplete_checkout_type_report')->name('autocomplete_checkout_type_report');
    Route::post('get_autocomplete_detail_checkout_report','DcRequest\DcRequestController@get_autocomplete_detail_checkout_report')->name('get_autocomplete_detail_checkout_report');


    Route::get('get_checkout_report_type_ajax','DcRequest\DcRequestController@get_checkout_report_type_ajax')->name('get_checkout_report_type_ajax');
    Route::post('after_accept_reject_send_onboard','DcRequest\DcRequestController@after_accept_reject_send_onboard')->name('after_accept_reject_send_onboard');

//    Route::get('dc_request_for_checkin','DcRequest\DcRequestController@dc_request_for_checkin')->name('dc_request_for_checkin');

    Route::get('autocomplete_checkout_platform','DcRequest\DcRequestController@autocomplete_checkout_platform')->name('autocomplete_checkout_platform');
    Route::get('ajax_onboard_checkin','DcRequest\DcRequestController@ajax_onboard_checkin')->name('ajax_onboard_checkin');
    Route::post('dc_request_for_checkin_save','DcRequest\DcRequestController@dc_request_for_checkin_save')->name('dc_request_for_checkin_save');
    Route::get('checkin_request_for_teamleader','DcRequest\DcRequestController@checkin_request_for_teamleader')->name('checkin_request_for_teamleader');
    Route::get('checkin_request_for_defaulter_manager','DcRequest\DcRequestController@checkin_request_for_defaulter_manager')->name('checkin_request_for_defaulter_manager');
    Route::get('get_checkin_request_render_defaulter_manager','DcRequest\DcRequestController@get_checkin_request_render_defaulter_manager')->name('get_checkin_request_render_defaulter_manager');



    Route::get('get_checkout_request_render','DcRequest\DcRequestController@get_checkout_request_render')->name('get_checkout_request_render');
    Route::get('get_checkout_request_render_defaulter_manager','DcRequest\DcRequestController@get_checkout_request_render_defaulter_manager')->name('get_checkout_request_render_defaulter_manager');

    Route::get('get_defaulter_checkout_request_render','DcRequest\DcRequestController@get_defaulter_checkout_request_render')->name('get_defaulter_checkout_request_render');

    Route::get('get_checkin_request_ajax','DcRequest\DcRequestController@get_checkin_request_ajax')->name('get_checkin_request_ajax');
    Route::get('get_checkin_request_ajax_defaulter_manager','DcRequest\DcRequestController@get_checkin_request_ajax_defaulter_manager')->name('get_checkin_request_ajax_defaulter_manager');

    Route::get('get_checkout_report_by_platform','DcRequest\DcRequestController@get_checkout_report_by_platform')->name('get_checkout_report_by_platform');
    Route::get('get_checkin_request_render','DcRequest\DcRequestController@get_checkin_request_render')->name('get_checkin_request_render');

    Route::post('save_checkin_request','DcRequest\DcRequestController@save_checkin_request')->name('save_checkin_request');
    Route::get('send_to_checkout_report','DcRequest\DcRequestController@send_to_checkout_report')->name('send_to_checkout_report');
    Route::get('autocomplete_send_checkout_report','DcRequest\DcRequestController@autocomplete_send_checkout_report')->name('autocomplete_send_checkout_report');
    Route::post('send_to_direct_checkout_save','DcRequest\DcRequestController@send_to_direct_checkout_save')->name('send_to_direct_checkout_save');


    Route::get('dc_sent_request_checkin','DcRequest\DcRequestController@dc_sent_request_checkin')->name('dc_sent_request_checkin');
    Route::get('dc_sent_request_checkout','DcRequest\DcRequestController@dc_sent_request_checkout')->name('dc_sent_request_checkout');
    Route::get('dc_to_accept_rider','DcRequest\DcRequestController@dc_to_accept_rider')->name('dc_to_accept_rider');
    Route::POST('rider_to_accept_request_save','DcRequest\DcRequestController@rider_to_accept_request_save')->name('rider_to_accept_request_save');
    Route::get('get_dc_to_accept_rider_table','DcRequest\DcRequestController@get_dc_to_accept_rider_table')->name('get_dc_to_accept_rider_table');
    Route::get('get_dc_to_accept_rider_for_defautler_table','DcRequest\DcRequestController@get_dc_to_accept_rider_for_defautler_table')->name('get_dc_to_accept_rider_for_defautler_table');
    Route::get('team_leader_request_sent_for_dc','DcRequest\DcRequestController@team_leader_request_sent_for_dc')->name('team_leader_request_sent_for_dc');
    Route::get('get_team_leader_request_sent_for_dc','DcRequest\DcRequestController@get_team_leader_request_sent_for_dc')->name('get_team_leader_request_sent_for_dc');
    Route::get('get_rejected_request_ajax','DcRequest\DcRequestController@get_rejected_request_ajax')->name('get_rejected_request_ajax');
    Route::post('resend_rejected_requested_save','DcRequest\DcRequestController@resend_rejected_requested_save')->name('resend_rejected_requested_save');

    Route::get('get_checkout_request_render_for_dc','DcRequest\DcRequestController@get_checkout_request_render_for_dc')->name('get_checkout_request_render_for_dc');
    Route::get('get_checkin_request_render_for_dc','DcRequest\DcRequestController@get_checkin_request_render_for_dc')->name('get_checkin_request_render_for_dc');

    Route::POST('rider_to_accept_request_defaulter_save','DcRequest\DcRequestController@rider_to_accept_request_defaulter_save')->name('rider_to_accept_request_defaulter_save');





});
//auth end here

?>
