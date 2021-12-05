<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::get('hiring_pool_dashboard', 'Career\CareerDashboardController@hiring_pool_dashboard')->name('hiring_pool_dashboard');
    Route::resource('career_dashboard', 'Career\CareerDashboardController');

    Route::GET('new_career_report','Career\CareerDashboardController@new_career_report')->name('new_career_report');
    Route::GET('get_new_report_user_ajax','Career\CareerDashboardController@get_new_report_user_ajax')->name('get_new_report_user_ajax');

    Route::GET('career_from_social_media','Career\NewCareerController@career_from_social_media')->name('career_from_social_media');
    Route::POST('save_career_from_social_media','Career\NewCareerController@save_career_from_social_media')->name('save_career_from_social_media');

    Route::GET('career_from_international','Career\NewCareerController@career_from_international')->name('career_from_international');
    Route::POST('save_career_from_international','Career\NewCareerController@save_career_from_international')->name('save_career_from_international');

    Route::GET('career_from_on_call','Career\NewCareerController@career_from_on_call')->name('career_from_on_call');
    Route::POST('save_career_from_on_call','Career\NewCareerController@save_career_from_on_call')->name('save_career_from_on_call');

    Route::GET('career_from_walk','Career\NewCareerController@career_from_walk')->name('career_from_walk');





    Route::POST('save_driving_license','Career\FrontDeskController@save_driving_license')->name('save_driving_license');
    Route::POST('send_to_wait_list_only','Career\FrontDeskController@send_to_wait_list_only')->name('send_to_wait_list_only');

    Route::GET('career_frontdesk','Career\FrontDeskController@index')->name('career_frontdesk');
    Route::GET('get_front_desk_table','Career\FrontDeskController@get_front_desk_table')->name('get_front_desk_table');
    Route::POST('search_result_career','Career\FrontDeskController@search_result_career')->name('search_result_career');
    Route::POST('search_result_career_wait_list','Career\FrontDeskController@search_result_career_wait_list')->name('search_result_career_wait_list');
    Route::POST('search_result_career_selected','Career\FrontDeskController@search_result_career_selected')->name('search_result_career_selected');

    Route::POST('career_frontdesk_save','Career\FrontDeskController@store')->name('career_frontdesk_save');
    Route::POST('save_status_send_to_selected','Career\FrontDeskController@save_status_send_to_selected')->name('save_status_send_to_selected');

    Route::POST('rejoin_follow_up','Career\FrontDeskController@rejoin_follow_up')->name('rejoin_follow_up');
    Route::POST('rejoin_follow_up_save','Career\FrontDeskController@rejoin_follow_up_save')->name('rejoin_follow_up_save');
    Route::POST('rejoin_follow_up_on_board','Career\FrontDeskController@rejoin_follow_up_on_board')->name('rejoin_follow_up_on_board');
    Route::POST('ajax_view_edit_detail','Career\FrontDeskController@ajax_view_edit_detail')->name('ajax_view_edit_detail');
    Route::POST('update_the_career/{id}','Career\FrontDeskController@update')->name('update_the_career');
    Route::POST('career_follow_up','Career\FrontDeskController@follow_up_save')->name('career_follow_up');


    Route::GET('frontdesk_follow_up','Career\CareerFollowupController@frontdesk_follow_up')->name('frontdesk_follow_up');
    Route::GET('waitlist_follow_up','Career\CareerFollowupController@waitlist_follow_up')->name('waitlist_follow_up');
    Route::GET('selected_follow_up','Career\CareerFollowupController@selected_follow_up')->name('selected_follow_up');
    Route::GET('onboard_follow_up','Career\CareerFollowupController@onboard_follow_up')->name('onboard_follow_up');
    Route::POST('frontdesk_follow_up_save','Career\CareerFollowupController@frontdesk_follow_up_save')->name('frontdesk_follow_up_save');
    Route::POST('waitlist_follow_up_save','Career\CareerFollowupController@waitlist_follow_up_save')->name('waitlist_follow_up_save');
    Route::POST('selected_follow_up_save','Career\CareerFollowupController@selected_follow_up_save')->name('selected_follow_up_save');
    Route::POST('onboard_follow_up_save','Career\CareerFollowupController@onboard_follow_up_save')->name('onboard_follow_up_save');
    Route::GET('frontdesk_follow_up_edit/{id}','Career\CareerFollowupController@frontdesk_follow_up_edit')->name('frontdesk_follow_up_edit');
    Route::PUT('frontdesk_follow_up_update/{id}','Career\CareerFollowupController@frontdesk_follow_up_update')->name('frontdesk_follow_up_update');
    Route::GET('waitlist_follow_up_edit/{id}','Career\CareerFollowupController@waitlist_follow_up_edit')->name('waitlist_follow_up_edit');
    Route::PUT('waitlist_follow_up_update/{id}','Career\CareerFollowupController@waitlist_follow_up_update')->name('waitlist_follow_up_update');
    Route::GET('selected_follow_up_edit/{id}','Career\CareerFollowupController@selected_follow_up_edit')->name('selected_follow_up_edit');
    Route::PUT('selected_follow_up_update/{id}','Career\CareerFollowupController@selected_follow_up_update')->name('selected_follow_up_update');
    Route::GET('onboard_follow_up_edit/{id}','Career\CareerFollowupController@onboard_follow_up_edit')->name('onboard_follow_up_edit');
    Route::PUT('onboard_follow_up_update/{id}','Career\CareerFollowupController@onboard_follow_up_update')->name('onboard_follow_up_update');
    Route::POST('active_followup','Career\CareerFollowupController@active_followup')->name('active_followup');
    Route::GET('career_follow_up_dashboard','Career\CareerFollowupController@follow_up_dashboard')->name('career_follow_up_dashboard');

    Route::GET('career_selected_candidate','Career\FrontDeskController@create')->name('career_selected_candidate');
    Route::GET('get_single_interview_by_package','Career\FrontDeskController@get_single_interview_by_package')->name('get_single_interview_by_package');

    Route::GET('wait_list','Career\FrontDeskController@wait_list')->name('wait_list');
    Route::GET('need_to_take_licence','Career\FrontDeskController@need_to_take_licence')->name('need_to_take_licence');
    Route::GET('batch_detail','Career\FrontDeskController@batch_detail')->name('batch_detail');
    Route::GET('career_follow_ups','Career\FrontDeskController@follow_up_view')->name('career_follow_ups');
    Route::GET('view_frontdesk_follow_up','Career\FrontDeskController@view_frontdesk_follow_up')->name('view_frontdesk_follow_up');
    Route::GET('view_waitlist_follow_up','Career\FrontDeskController@view_waitlist_follow_up')->name('view_waitlist_follow_up');
    Route::GET('view_selected_follow_up','Career\FrontDeskController@view_selected_follow_up')->name('view_selected_follow_up');
    Route::GET('view_onboard_follow_up','Career\FrontDeskController@view_onboard_follow_up')->name('view_onboard_follow_up');
    Route::GET('ajax_frontdesk_follow_up','Career\FrontDeskController@ajax_frontdesk_follow_up')->name('ajax_frontdesk_follow_up');
    Route::GET('ajax_waitlist_follow_up','Career\FrontDeskController@ajax_waitlist_follow_up')->name('ajax_waitlist_follow_up');
    Route::GET('ajax_selected_follow_up','Career\FrontDeskController@ajax_selected_follow_up')->name('ajax_selected_follow_up');
    Route::GET('ajax_onboard_follow_up','Career\FrontDeskController@ajax_onboard_follow_up')->name('ajax_onboard_follow_up');
    Route::POST('waitlist_reject_save','Career\FrontDeskController@waitlist_reject_save')->name('waitlist_reject_save');
    Route::POST('waitlist_rejoin_reject_save','Career\FrontDeskController@waitlist_rejoin_reject_save')->name('waitlist_rejoin_reject_save');
    Route::POST('selected_rejoin_reject_save','Career\FrontDeskController@selected_rejoin_reject_save')->name('selected_rejoin_reject_save');
    Route::POST('onboard_reject_save','Career\FrontDeskController@onboard_reject_save')->name('onboard_reject_save');
    Route::POST('onboard_rejoin_reject_save','Career\FrontDeskController@onboard_rejoin_reject_save')->name('onboard_rejoin_reject_save');
    Route::POST('rejoin_reject_save','Career\FrontDeskController@rejoin_reject_save')->name('rejoin_reject_save');


    Route::GET('rejoin_ajax_passport_detail','Career\FrontDeskController@rejoin_ajax_passport_detail')->name('rejoin_ajax_passport_detail');
    Route::GET('filter_data_career','Career\FrontDeskController@filter_data_career')->name('filter_data_career');
    Route::GET('filter_data_counts','Career\FrontDeskController@filter_data_counts')->name('filter_data_counts');
    Route::GET('filter_data_by_package','Career\FrontDeskController@filter_data_by_package')->name('filter_data_by_package');

    Route::GET('career_report','Career\FrontDeskController@career_report')->name('career_report');
    Route::GET('career_report_ajax','Career\FrontDeskController@career_report_ajax')->name('career_report_ajax');

    Route::GET('career_report_rnder_slider','Career\FrontDeskController@career_report_rnder_slider')->name('career_report_rnder_slider');
    Route::POST('save_rejected_from_selected','Career\FrontDeskController@save_rejected_from_selected')->name('save_rejected_from_selected');
    Route::get('get_creeer_wise_report_agreed_amount_detail','Career\FrontDeskController@get_creeer_wise_report_agreed_amount_detail')->name('get_creeer_wise_report_agreed_amount_detail');




    Route::POST('career_send_interview','Career\FrontDeskController@career_send_interview')->name('career_send_interview');
    Route::POST('update_career_status_from_rejected','Career\FrontDeskController@update_career_status_from_rejected')->name('update_career_status_from_rejected');
    Route::POST('update_career_status_from_rejected_for_rejoin','Career\FrontDeskController@update_career_status_from_rejected_for_rejoin')->name('update_career_status_from_rejected_for_rejoin');

    Route::GET('get_reject_career_table','Career\CareerContrller@get_reject_career_table')->name('get_reject_career_table');
    Route::GET('get_reject_rejoin_career_table','Career\CareerContrller@get_reject_rejoin_career_table')->name('get_reject_rejoin_career_table');


    Route::GET('get_rejoin_candidate_rejected','Career\CareerContrller@get_rejoin_candidate_rejected')->name('get_rejoin_candidate_rejected');

    Route::GET('get_pacakges_ajax_list','Career\FrontDeskController@get_pacakges_ajax_list')->name('get_pacakges_ajax_list');
    Route::GET('get_pacakges_ajax_detail','Career\FrontDeskController@get_pacakges_ajax_detail')->name('get_pacakges_ajax_detail');







});
//auth end here

?>
