<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::resource('agreed_amount', 'AgreedAmount\AgreedAmountController');

    Route::resource('rider_step_log', 'RiderLog\RiderLogController');

    Route::POST('rider_log_show_ajax','RiderLog\RiderLogController@rider_log_show_ajax')->name('rider_log_show_ajax');
    Route::GET('missing_agreed_amount','AgreedAmount\AgreedAmountController@missing_agreed_amount')->name('missing_agreed_amount');
    Route::GET('render_view_agreement_table','AgreedAmount\AgreedAmountController@render_view_agreement_table')->name('render_view_agreement_table');
    Route::GET('render_view_agreement_count_block','AgreedAmount\AgreedAmountController@render_view_agreement_count_block')->name('render_view_agreement_count_block');
    Route::POST('upload_missing_agreed_amount','AgreedAmount\AgreedAmountController@upload_missing_agreed_amount')->name('upload_missing_agreed_amount');
    Route::POST('save_update_status_taken','AgreedAmount\AgreedAmountController@save_update_status_taken')->name('save_update_status_taken');

    Route::GET('renew_agreed_amount','AgreedAmount\AgreedAmountController@renew_agreed_amount');
    Route::GET('render_view_renew_agreement_count_block','AgreedAmount\AgreedAmountController@render_view_renew_agreement_count_block')->name('render_view_renew_agreement_count_block');

    Route::GET('render_view_renew_agreement_table','AgreedAmount\AgreedAmountController@render_view_renew_agreement_table')->name('render_view_renew_agreement_table');

    Route::POST('save_update_renew_status_taken','AgreedAmount\AgreedAmountController@save_update_renew_status_taken')->name('save_update_renew_status_taken');


});
//auth end here

?>
