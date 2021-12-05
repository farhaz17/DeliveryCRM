<?php

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::middleware('auth:api')->group(function () {
    Route::post('logout','Api\Auth\LoginController@logout');

    Route::get('profile', 'Ticket\ProfileRiderController@getProfile');
    Route::post('profile/{id}', 'Ticket\ProfileRiderController@updateProfile');
    Route::post('post_tickets', 'Ticket\TicketController@storeTicket');
    Route::get('get_departments', 'Ticket\TicketController@getDepartments');
    Route::get('get_platforms', 'Ticket\TicketController@getplatforms');
    Route::post('post_fcmtoken', 'Api\Auth\FcmTokenController@storeFcmToken');
    Route::get('get_tickets', 'Ticket\TicketController@getTicketDetails');
    Route::get('get_tickets_alt', 'Ticket\TicketController@getTicketDetails_competed');
    Route::get('get_ticket_in_process', 'Ticket\TicketController@getTicketInProcess');
    Route::get('get_ticket_in_rejected', 'Ticket\TicketController@getTicketInRejected');


    Route::get('update_message_read/{id}', 'Ticket\TicketController@update_message_read_app');


    //checkin detail
    Route::get('get_checkin_detail', 'Api\Auth\LoginController@get_checkin_detail');

    Route::get('interview_status', 'Api\Interview\InterviewController@index');
    Route::post('update_interview_status', 'Api\Interview\InterviewController@store');
    Route::get('get_interview_log', 'Api\Interview\InterviewController@get_interview_log');

    //cloth size
    Route::post('rider_cloth_size_save', 'Api\RiderSizeCloth\RiderSizeClothController@store');






    Route::post('post_message', 'Ticket\ManageTicketController@store_message_app');
    Route::post('get_message', 'Ticket\ManageTicketController@get_message_app');
    //cods api route
    Route::post('store_cods','Api\Cods\CodsController@store_cods');
    Route::post('store_bank_issue','Api\Cods\CodsController@store_bank_issue');
    Route::post('store_cash','Api\Cods\CodsController@store_cash');
    Route::get('cod_history','Api\Cods\CodsController@cod_history');
    Route::get('cod_rider_order_history','Api\Cods\CodsController@cod_rider_order_history');

    //cods close month
    Route::get('salary_close_month','Api\Cods\CodsController@salary_close_month');



    //adjustment reqeust
    Route::post('cod_adjust_request_store','Api\Cods\CodsController@cod_adjust_request_store');
    Route::get('get_cod_balance','Api\Cods\CodsController@get_cod_balance');
    Route::get('adjustment_history','Api\Cods\CodsController@adjustment_history');
    Route::get('adjustment_history_detail/{id}','Api\Cods\CodsController@adjustment_history_detail');
    Route::get('cod_detail','Api\Cods\CodsController@cod_detail');

 //verification
    Route::post('store_verification','Api\Verification\VerificationFormController@store');
    Route::post('update_verification_form/{id}', 'Api\Verification\VerificationFormController@update');
    Route::get('get_verify_form', 'Api\Verification\VerificationFormController@get_verify_form');
    Route::get('contact_list', 'Api\DepartmentContact\DepartmentContactController@contact_list');





    //Checkin

    Route::get('get_bike', 'Api\Assign\BikeAssignController@get_bike');
    Route::get('get_passport', 'Api\Assign\BikeAssignController@get_passport');
    Route::get('get_name', 'Api\Assign\BikeAssignController@get_name');
    Route::get('get_sim_no', 'Api\Assign\SimAssignController@get_sim_no');
    //post_urls for Checkin
    Route::post('assign_sim','Api\Assign\SimAssignController@assign_sim');
    Route::post('assign_bike','Api\Assign\BikeAssignController@assign_bike');
    Route::post('assign_platform','Api\Assign\PlatFormAssignController@assign_platform');

    //checkouts
            //get checked-in bike details
    Route::get('get_bike_checkout', 'Api\Assign\BikeAssignController@get_bike_checkout');
         //get checked-in SIM Details
    Route::get('get_sim_checkout','Api\Assign\SimAssignController@get_sim_checkout');
    //get check-in Platform details
    Route::get('get_platform_checkout','Api\Assign\PlatFormAssignController@get_platform_checkout');
            //post for checkout
    Route::post('bike_checkout/{id}','Api\Assign\BikeAssignController@bike_checkout');

    Route::post('sim_checkout/{id}','Api\Assign\SimAssignController@sim_checkout');

    Route::post('platform_checkout/{id}','Api\Assign\PlatFormAssignController@platform_checkout');

    Route::get('get_user_notification', 'Api\Notifications\NotifyController@get_user_notification');
    Route::get('notification_detail/{id}', 'Api\Notifications\NotifyController@update');


    Route::post('verify_sim_rider', 'Assign\AssignController@verify_sim_rider')->name('verify_sim_rider');
    Route::post('verify_platform_rider', 'Assign\AssignController@verify_platform_rider')->name('verify_platform_rider');
    Route::post('verify_bike_rider', 'Assign\AssignController@verify_bike_rider')->name('verify_bike_rider');

    Route::get('bike_history', 'Api\AssignHistory\AssignHistoryController@index')->name('bike_history');
    Route::get('sim_history', 'Api\AssignHistory\AssignHistoryController@sim_history')->name('sim_history');
    Route::get('platform_history', 'Api\AssignHistory\AssignHistoryController@platform_history')->name('platform_history');
    Route::get('get_passport_detail', 'Api\AssignHistory\AssignHistoryController@get_passport_detail')->name('get_passport_detail');
    Route::get('get_emirates_id_detail', 'Api\AssignHistory\AssignHistoryController@get_emirates_id_detail')->name('get_emirates_id_detail');
    Route::get('get_driving_license_detail', 'Api\AssignHistory\AssignHistoryController@get_driving_license_detail')->name('get_driving_license_detail');
    Route::get('get_user_codes', 'Api\AssignHistory\AssignHistoryController@get_user_codes')->name('get_user_codes');

    Route::get('get_performance', 'Api\Performance\DeliverooPerformanceController@get_performance');
    Route::get('get_performance_detail','Api\Performance\DeliverooPerformanceController@get_performance_detail');
    Route::get('get_dates','Api\Performance\DeliverooPerformanceController@get_dates');
    Route::post('get_week_rating','Api\Performance\DeliverooPerformanceController@get_week_rating');

   //rider order detail
    Route::post('save_rider_order_detail','Api\RiderOrderDetail\RiderOrderDetailController@store');
    Route::get('get_rider_order_detail','Api\RiderOrderDetail\RiderOrderDetailController@index');
    Route::get('rider_order_seven_days','Api\RiderOrderDetail\RiderOrderDetailController@rider_order_seven_days');
    Route::get('tick_under_days','Api\RiderOrderDetail\RiderOrderDetailController@tick_under_days');

    //unassigned order save
    Route::post('save_unassigned_order','Api\RiderOrderDetail\RiderOrderDetailController@save_unassigned_order');

    //admin dashboard
    Route::get('get_dashboard', 'Api\Dashboard\DashboardApiController@get_dashboard');
    Route::post('get_dashboard_search', 'Api\Dashboard\DashboardApiController@get_dashboard_search');
    Route::get('get_dashboard_detail/{id}','Api\Dashboard\DashboardApiController@get_dashboard_detail');
    Route::post('get_attendance','Api\Attendance\AttendanceApiController@get_attendance');
    Route::get('get_attendance_status','Api\Attendance\AttendanceApiController@get_attendance_status');

    //admin cod
    Route::get('get_cod_all_counts', 'Api\Dashboard\DashboardApiController@get_cod_all_counts');
    Route::get('get_cod_all_counts_by_platform/{id}', 'Api\Dashboard\DashboardApiController@get_cod_all_counts_by_platform');


    Route::post('get_dashboard_bike_search', 'Api\Dashboard\DashboardApiController@get_dashboard_bike_search');
    Route::get('get_the_bike/{id}', 'Api\Dashboard\DashboardApiController@get_the_bike');


    Route::get('get_ticket_problems', 'Api\TicketProblem\TicketProblemController@index');
    Route::get('get_ticket_issue/{id}', 'Api\TicketProblem\TicketProblemController@get_ticket_issue');

    //referal APIs
    Route::post('get_referal', 'Api\Referal\RefrealApiController@get_referal');
    Route::get('get_referal_history', 'Api\Referal\RefrealApiController@get_referal_history');
    //Passport Request APIs
    Route::post('get_passport_request', 'Api\PassportRequest\PassportRequestApiContoller@get_passport_request');
    Route::get('get_passport_request_detail', 'Api\PassportRequest\PassportRequestApiContoller@get_passport_request_detail');
    Route::get('get_company', 'Api\Dashboard\DashboardApiController@get_company');
    Route::get('get_the_passport/{id}', 'Api\Dashboard\DashboardApiController@get_the_passport');
    Route::get('get_bikes_category', 'Api\Dashboard\DashboardApiController@get_bikes_category');
    Route::get('get_bikes_detail/{id}', 'Api\Dashboard\DashboardApiController@get_bikes_detail');
    Route::get('get_bike_histories/{id}', 'Api\Dashboard\DashboardApiController@get_bike_histories');
    Route::get('get_sim_histories/{id}', 'Api\Dashboard\DashboardApiController@get_sim_histories');
    Route::get('get_platform_histories/{id}', 'Api\Dashboard\DashboardApiController@get_platform_histories');
    Route::get('get_sims_category', 'Api\Dashboard\DashboardApiController@get_sims_category');
    Route::get('get_sims_detail/{id}', 'Api\Dashboard\DashboardApiController@get_sims_detail');
    Route::post('get_dashboard_sim_search', 'Api\Dashboard\DashboardApiController@get_dashboard_sim_search');
    Route::get('get_the_sim/{id}', 'Api\Dashboard\DashboardApiController@get_the_sim');

    Route::get('get_the_platform', 'Api\Dashboard\DashboardApiController@get_the_platform');

    Route::get('get_platform_detail/{id}', 'Api\Dashboard\DashboardApiController@get_platform_detail');
    Route::get('get_compay_category/{id}', 'Api\Dashboard\DashboardApiController@get_compay_category');
    Route::get('get_rider_status/{id}', 'Api\Dashboard\DashboardApiController@get_rider_status');
    Route::get('get_company_category/{id}', 'Api\Dashboard\DashboardApiController@get_company_category');


    //get dashboard api's here-------------------------------------------------------------------

    //bike assign apis
    Route::get('get_dashboard_checkin_today','Api\Assign\BikeAssignController@assign_dashboard_count');
    Route::get('checkin_by_platform/{id}','Api\Assign\BikeAssignController@checkin_by_platform');
    Route::get('today_details_checkin/{id}','Api\Assign\BikeAssignController@today_details_checkin');

    Route::post('save_fuel','Api\FuelRiderController@save_fuel');
    Route::get('is_fuel_already_saved','Api\FuelRiderController@is_fuel_already_saved');
    Route::get('get_rider_fuel_history','Api\FuelRiderController@get_rider_fuel_history');
    Route::get('get_rider_fuel_search','Api\FuelRiderController@get_rider_fuel_search');
    Route::get('get_rider_fuel_date','Api\FuelRiderController@get_rider_fuel_date');

    Route::get('talabat_rider_cods','Api\Talabat\TalabatCodApiController@talabat_rider_cods');
    Route::get('delivero_rider_cods','Api\Delivero\DeliveroCodApiController@delivero_rider_cods');

    //new career status routes
    Route::get('interview_process', 'Api\Interview\InterviewController@interview_process');

});

//auth end here


//assing verification



//Route::post('register','Api\Auth\RegisterController@register');
Route::post('reg','Api\Auth\RegisterController@register_profile');
Route::post('contact_admin','Api\Auth\RegisterController@contact_admin');
Route::post('login','Api\Auth\LoginController@login');
Route::post('refresh','Api\Auth\LoginController@refresh');
Route::post('forget_password','Api\Auth\RegisterController@forget_password');
Route::post('update_password','Api\Auth\RegisterController@update_password');
Route::post('update_password_final','Api\Auth\RegisterController@update_password_final');
Route::post('career_apply','Api\Guest\CareerController@store_career');
Route::get('get_platforms_pub', 'Ticket\TicketController@getplatforms');
Route::get('get_experience', 'Api\Guest\CareerController@getExperiences');
Route::get('get_experience_month', 'Api\Guest\CareerController@get_experience_month');  // exprience months
Route::get('get_cities', 'Api\Guest\CareerController@get_cities');  // exprience months
Route::post('get_dashboard_search_old', 'Api\Dashboard\DashboardApiController@get_dashboard_search_old');
Route::get('get_dashboard_detail_test/{id}','Api\Dashboard\DashboardApiController@get_dashboard_detail_test');

Route::get('getPromotionType', 'Api\Guest\CareerController@getPromotionType');
// Route::post('get_company', 'Api\Referal\RefrealApiController@get_company');







//Route::get('get_performance_detail','Api\Performance\DeliverooPerformanceController@get_performance_detail');

//Route::get('get_ticket_problems', 'Api\TicketProblem\TicketProblemController@index');
//Route::get('get_checkin_detail', 'Api\Auth\LoginController@get_checkin_detail');


Route::post('career_form', "Api\Guest\CareerController@career_request_form_outside_uae");
Route::get('nationalities', "Api\Guest\CareerController@get_nationalities")->middleware(['cors']);

Route::get('get_current_version', "Api\Guest\CareerController@get_current_version");



// Talabat COD api starts



// Talabat COD api ends


//for trot get employee info

Route::get('get_employee_info/{keyword}', 'Api\EmployeeInfo\EmployeeInfoController@get_employee_info')->name('get_employee_info')->middleware('api_token_get_info');

//end trot end
