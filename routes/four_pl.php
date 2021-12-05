<?php
//4PL Api Routes
Route::post('register', "Api\FourPl\RegisterController@register");
Route::post('verify', "Api\FourPl\RegisterController@verify");
Route::post('login', "Api\FourPl\RegisterController@login");
Route::get('logout', "Api\FourPl\RegisterController@logout");
Route::post('forgot-password', "Api\FourPl\RegisterController@forgot_password");
Route::post('password-reset', "Api\FourPl\RegisterController@password_reset");

Route::middleware('auth:api')->group(function () {
    Route::get('test', "Api\FourPl\RegisterController@test");
    Route::post('registration', "Api\FourPl\RegistrationControlle@register");
    Route::get('four-pl-details', "Api\FourPl\RegisterController@four_pl_details");
    Route::get('four-pl-resubmit', "Api\FourPl\RegisterController@four_pl_resubmit");
    Route::post('add-rider', "Api\FourPl\RegistrationControlle@add_rider");
    Route::get('get-rider-list', "Api\FourPl\ManageRiderController@get_rider_list");
    Route::get('get-approved-rider-status', "Api\FourPl\ManageRiderController@approved_rider_status");
    Route::get('edit-rider', "Api\FourPl\ManageRiderController@edit_rider");
    Route::get('auth', "Api\FourPl\RegisterController@auth");
    Route::get('approved-vendor', "Api\FourPl\RegisterController@approved_vendor");
    Route::get('cod-report', "Api\FourPl\CodReportController@cod_report");
});
