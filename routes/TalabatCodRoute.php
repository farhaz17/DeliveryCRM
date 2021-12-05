<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::get('talabat_cod_internal', 'TalabatCod\TablabatCodController@talabat_cod_internal')->name('talabat_cod_internal');
    Route::post('talabat_cod_internal', 'TalabatCod\TablabatCodController@talabat_cod_internal_store')->name('talabat_cod_internal');
    Route::post('render_calender_talabat_internal_cod', 'TalabatCod\TablabatCodController@render_calender_talabat_internal_cod')->name('render_calender_talabat_internal_cod');
    Route::resource('talabat_cod', 'TalabatCod\TablabatCodController', [
        'names' => [
            'index' => 'talabat_cod',
            'create' => 'talabat_cod.create',
            'store' => 'talabat_cod.store',
            'edit' => 'talabat_cod.edit',
            'show' => 'talabat_cod.show',
            'update' => 'talabat_cod.update',
            'delete' => 'talabat_cod.delete'
        ]
    ]);

    Route::post('talabat_cod_deduction', 'TalabatCod\TablabatCodDeductionController@talabat_cod_deduction')->name('talabat_cod_deduction');
    Route::POST('render_calender_talabat_cod','TalabatCod\TablabatCodController@render_calender_talabat_cod')->name('render_calender_talabat_cod');
    Route::get('rider_wise_cod_statement','TalabatCod\TablabatCodController@rider_wise_cod_statement')->name('rider_wise_cod_statement');
    Route::post('ajax_talabat_rider_statement_report','TalabatCod\TablabatCodController@ajax_talabat_rider_statement_report')->name('ajax_talabat_rider_statement_report');
    Route::get('get_rider_list_for_cod_statement','TalabatCod\TablabatCodController@get_rider_list_for_cod_statement')->name('get_rider_list_for_cod_statement');

    Route::get('talabat_user_wise_riders_cod_analysis','TalabatCod\TablabatCodController@talabat_user_wise_riders_cod_analysis')->name('talabat_user_wise_riders_cod_analysis');
    Route::get('ajax_talabat_user_wise_riders_cod_analysis','TalabatCod\TablabatCodController@ajax_talabat_user_wise_riders_cod_analysis')->name('ajax_talabat_user_wise_riders_cod_analysis');
    Route::get('ajax_talabat_user_wise_riders_cod_buttons','TalabatCod\TablabatCodController@ajax_talabat_user_wise_riders_cod_buttons')->name('ajax_talabat_user_wise_riders_cod_buttons');

    Route::get('talabat_user_wise_riders_cod_follow_up','TalabatCod\TablabatCodController@talabat_user_wise_riders_cod_follow_up')->name('talabat_user_wise_riders_cod_follow_up');
    Route::get('ajax_talabat_user_wise_riders_cod_follow_up','TalabatCod\TablabatCodController@ajax_talabat_user_wise_riders_cod_follow_up')->name('ajax_talabat_user_wise_riders_cod_follow_up');
    Route::get('ajax_talabat_user_wise_riders_cod_follow_up_buttons','TalabatCod\TablabatCodController@ajax_talabat_user_wise_riders_cod_follow_up_buttons')->name('ajax_talabat_user_wise_riders_cod_follow_up_buttons');

    Route::get('talabat_cod_follow_up_calls', 'TalabatCod\TalabatCodFollowUpController@talabat_cod_follow_up_calls')->name('talabat_cod_follow_up_calls');
    Route::resource('talabat_cod_follow_ups', 'TalabatCod\TalabatCodFollowUpController')->only(['store']);


    Route::get('manage_rider_codes','TalabatCod\TablabatCodController@manage_rider_codes')->name('manage_rider_codes');
    Route::get('get_dc_rider_with_codes','TalabatCod\TablabatCodController@get_dc_rider_with_codes')->name('get_dc_rider_with_codes');
    Route::POST('add_rider_id_to_talabat_dc','TalabatCod\TablabatCodController@add_rider_id_to_talabat_dc')->name('add_rider_id_to_talabat_dc');
    Route::put('rider_code_update','TalabatCod\TablabatCodController@rider_code_update')->name('rider_code_update');

    Route::get('get_ajax_defaulter_rider_details', 'Riders\DefaulterRiderController@get_ajax_defaulter_rider_details')->name('get_ajax_defaulter_rider_details');
    Route::get('get_ajax_defaulter_rider_comments', 'Riders\DefaulterRiderController@get_ajax_defaulter_rider_comments')->name('get_ajax_defaulter_rider_comments');
    Route::post('defaulter_rider_comments', 'Riders\DefaulterRiderController@defaulter_rider_comments')->name('defaulter_rider_comments');
    Route::post('defaulter_rider_accept_reject', 'Riders\DefaulterRiderController@defaulter_rider_accept_reject')->name('defaulter_rider_accept_reject');
    Route::post('defaulter_rider_reassign_request_to_dc', 'Riders\DefaulterRiderController@defaulter_rider_reassign_request_to_dc')->name('defaulter_rider_reassign_request_to_dc');
    Route::get('rider_platform_wise_dc_list', 'Riders\DefaulterRiderController@rider_platform_wise_dc_list')->name('rider_platform_wise_dc_list');

    Route::post('reassign_rider_accept_reject', 'Riders\DefaulterRiderController@reassign_rider_accept_reject')->name('reassign_rider_accept_reject');

    Route::resource('defaulter_riders', 'Riders\DefaulterRiderController');

});//auth end here
?>
