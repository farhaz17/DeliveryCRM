<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {



    Route::GET('accident_rider_request','AccidenRider\AccidentRiderController@create')->name('accident_rider_request');
    Route::POST('save_accident_request','AccidenRider\AccidentRiderController@save_accident_request')->name('save_accident_request');
    Route::GET('accident_request_for_teamleader','AccidenRider\AccidentRiderController@accident_request_for_teamleader')->name('accident_request_for_teamleader');
    Route::GET('get_accident_request_ajax','AccidenRider\AccidentRiderController@get_accident_request_ajax')->name('get_accident_request_ajax');
    Route::POST('save_request_teamlader_action','AccidenRider\AccidentRiderController@save_request_teamlader_action')->name('save_request_teamlader_action');
    Route::GET('get_teamleader_request','AccidenRider\AccidentRiderController@get_teamleader_request')->name('get_teamleader_request');

    Route::GET('after_approved_requests','AccidenRider\AccidentRiderController@after_approved_requests')->name('after_approved_requests');
    Route::GET('after_accept_get_accident_request_ajax','AccidenRider\AccidentRiderController@after_accept_get_accident_request_ajax')->name('after_accept_get_accident_request_ajax');
    Route::POST('save_after_accepte_request','AccidenRider\AccidentRiderController@save_after_accepte_request')->name('save_after_accepte_request');

    Route::POST('save_after_accepte_request_for_bike_only','AccidenRider\AccidentRiderController@save_after_accepte_request_for_bike_only')->name('save_after_accepte_request_for_bike_only');














});
//auth end here

?>
