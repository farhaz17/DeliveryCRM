<?php

use App\Model\Passport\Passport;
use App\Http\Controllers\Controller;
use App\Model\BikesTracking\BikesTracking;
// use App\Http\Controllers\Riders\RiderPerformance\TalabatRiderPerformanceController;

Route::post('apply-job','Career\ApplyJobController@apply')->middleware('cors');
Route::post('vendor_registration','VendorRegistration\VendorRegistrationController@apply')->middleware('cors');
Route::post('vendor_onboard','VendorRegistration\VendorRegistrationController@vendor_on_board')->middleware('cors');

Route::get('/forgot-password', function () {
    return view('auth.passwords.reset');
})->middleware(['guest'])->name('password.request');

Route::post('forget_password_msp','Auth\ForgotPasswordController@forget_password_msp')->name('forget_password_msp');
Route::get('update_password_msp', 'Auth\ForgotPasswordController@update_password_msp')->name('update_password_msp');
Route::get('update_password_final', 'Auth\ForgotPasswordController@update_password_final')->name('update_password_final');

Route::get('/logout', function () {

    $redirect = '/login';
    if (isset(Auth::user()->user_group_id)){
        if (in_array(4, Auth::user()->user_group_id)) {
            $redirect = '/rider/rider_login';
        }
    }

    Auth::logout();
    return redirect($redirect);
});

Route::get('/', function () {
    return redirect('/login');
});


//Route::get('/email', function () {
//    return view('admin-panel.emails.ticket_email');
//});

Auth::routes();

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::resource('dashboard', 'DashboardController', [
        'names' => [
            'index' => 'dashboard',
            'create' => 'dashboard.create',
            'store' => 'dashboard.store',
            'edit' => 'dashboard.edit',
            'show' => 'dashboard.show',
            'update' => 'dashboard.update',
            'delete' => 'dashboard.delete'
        ]
    ]);

    Route::resource('roles','RoleController');
    Route::resource('permissions','Permission\PermissionController');
});

Route::group(['middleware' => ['auth', 'rider'],'prefix' => '/'], function () {


    Route::resource('bike', 'BikemasterController', [
        'names' => [
            'index' => 'bike',
            'create' => 'bike.create',
            'store' => 'bike.store',
            'edit' => 'bike.edit',
            'show' => 'bike.show',
            'update' => 'bike.update',
            'delete' => 'bike.delete'
        ]
    ]);




    Route::post('file/upload', 'BikemasterController@store')->name('file.upload');

    Route::resource('repair_category', 'RepairCategoryController', [
        'names' => [
            'index' => 'repair_category',
            'create' => 'repair_category.create',
            'store' => 'repair_category.store',
            'edit' => 'repair_category.edit',
            'show' => 'repair_category.show',
            'update' => 'repair_category.update',
            'delete' => 'repair_category.delete'
        ]
    ]);
    Route::resource('parts', 'PartsController', [
        'names' => [
            'index' => 'parts',
            'create' => 'parts.create',
            'store' => 'parts.store',
            'edit' => 'parts.edit',
            'show' => 'parts.show',
            'update' => 'parts.update',
            'delete' => 'parts.delete'
        ]
    ]);

    //ajax parts


    Route::get('get_parts_ajax_table','PartsController@get_vendor_attenance')->name('get_parts_ajax_table');


    Route::resource('inv_parts', 'InvPartsController', [
        'names' => [
            'index' => 'inv_parts',
            'create' => 'inv_parts.create',
            'store' => 'inv_parts.store',
            'edit' => 'inv_parts.edit',
            'show' => 'inv_parts.show',
            'update' => 'inv_parts.update',
            'delete' => 'inv_parts.delete'
        ]
    ]);

    Route::resource('manage_repair', 'ManageRepairController', [
        'names' => [
            'index' => 'manage_repair',
            'create' => 'manage_repair.create',
            'store' => 'manage_repair.store',
            'edit' => 'manage_repair.edit',
            'show' => 'manage_repair.show',
            'update' => 'manage_repair.update',
            'delete' => 'manage_repair.delete'
        ]
    ]);
    Route::post('manage_repair_parts_add', 'ManageRepairController@manage_repair_parts_add')->name('manage_repair_parts_add');
    Route::post('get_rider_repair_detail', 'ManageRepairController@get_rider_repair_detail')->name('get_rider_repair_detail');
    Route::get('rapair_view', 'ManageRepairController@rapair_view')->name('rapair_view');
    Route::get('rapair_invoice_view', 'ManageRepairController@rapair_invoice_view')->name('rapair_invoice_view');

    Route::get('rapair_pos', 'ManageRepairController@repair_pos')->name('rapair_pos');
    Route::post('repair_sale_save', 'ManageRepairController@repair_sale_save')->name('repair_sale_save');
    Route::post('repair_sale_payment', 'ManageRepairController@repair_sale_payment')->name('repair_sale_payment');
    Route::post('get_repair_checkup_detail', 'ManageRepairController@get_repair_checkup_detail')->name('get_repair_checkup_detail');
    Route::post('get_repair_manage_detail', 'ManageRepairController@get_repair_manage_detail')->name('get_repair_manage_detail');
    Route::post('get_pos_product', 'ManageRepairController@get_pos_product')->name('get_pos_product');
    Route::get('show_repairs', 'ManageRepairController@show_repairs')->name('show_repairs');
    Route::post('get_repair_sale_detail', 'ManageRepairController@get_repair_sale_detail')->name('get_repair_sale_detail');
    Route::post('get_add_form', 'ManageRepairController@get_add_form')->name('get_add_form');
    Route::post('save_repair_checkup', 'ManageRepairController@save_repair_checkup')->name('save_repair_checkup');
    Route::post('get_checkup_points', 'ManageRepairController@get_checkup_points')->name('get_checkup_points');
    Route::post('get_manage_parts', 'ManageRepairController@get_manage_parts')->name('get_manage_parts');
    Route::post('get_repair_id', 'ManageRepairController@get_repair_id')->name('get_repair_id');
    Route::post('get_manage_repar_id', 'ManageRepairController@get_manage_repar_id')->name('get_manage_repar_id');
    Route::post('checkup_points_update', 'ManageRepairController@checkup_points_update')->name('checkup_points_update');
    Route::post('start_manage_repair', 'ManageRepairController@start_manage_repair')->name('start_manage_repair');
    Route::post('complete_manage_repair', 'ManageRepairController@complete_manage_repair')->name('complete_manage_repair');


    //manage repair routes above

    Route::resource('inventory_controller', 'Maintenance\InventoryControlController', [
        'names' => [
            'index' => 'inventory_controller',
            'create' => 'inventory_controller.create',
            'store' => 'inventory_controller.store',
            'edit' => 'inventory_controller.edit',
            'show' => 'inventory_controller.show',
            'update' => 'inventory_controller.update',
            'delete' => 'inventory_controller.delete'
        ]
    ]);
    Route::post('get_inv_parts', 'Maintenance\InventoryControlController@get_inv_parts')->name('get_inv_parts');
    Route::post('very_inv', 'Maintenance\InventoryControlController@very_inv')->name('very_inv');
    Route::post('get_return_parts', 'Maintenance\InventoryControlController@get_return_parts')->name('get_return_parts');

    Route::get('get_inv_parts2','Maintenance\InventoryControlController@get_inv_parts2')->name('get_inv_parts2');

    //price module
    Route::resource('price', 'Price\CurrentPriceController', [
        'names' => [
            'index' => 'price',
            'create' => 'price.create',
            'store' => 'price.store',
            'edit' => 'price.edit',
            'show' => 'price.show',
            'update' => 'price.update',
            'delete' => 'price.delete'
        ]
    ]);
    Route::get('price_view', 'Price\CurrentPriceController@price_view')->name('price_view');

    Route::post('activate_deactivate', 'Price\CurrentPriceController@activate_deactivate')->name('activate_deactivate');
    Route::post('price_update', 'Price\CurrentPriceController@price_update')->name('price_update');

    Route::get('price_history', 'Price\CurrentPriceController@price_history');

    //price module ends





    Route::resource('manage_repair_parts', 'RepairUsedPartsController', [
        'names' => [
            'index' => 'manage_repair_parts',
            'create' => 'manage_repair_parts.create',
            'store' => 'manage_repair_parts.store',
            'edit' => 'manage_repair_parts.edit',
            'show' => 'manage_repair_parts.show',
            'update' => 'manage_repair_parts.update',
            'delete' => 'manage_repair_parts.delete'
        ]
    ]);

    Route::post('project_update_status', 'Project\ProjectController@update_status')->name('project_update_status');
    Route::post('update_issue_dep', 'Master\IssuesDepartmentController@update_issue_dep')->name('update_issue_dep');
    Route::resource('project', 'Project\ProjectController', [
        'names' => [
            'index' => 'project',
            'create' => 'project.create',
            'store' => 'project.store',
            'edit' => 'project.edit',
            'show' => 'project.show',
            'update' => 'project.update',
            'delete' => 'project.delete'
        ]
    ]);

    Route::get('projectview', 'Project\ProjectController@prview');

    Route::get('invoiceview', 'Project\InvoiceController@invoiceview');

    Route::resource('project_invoice', 'Project\InvoiceController', [
        'names' => [
            'index' => 'project_invoice',
            'create' => 'project_invoice.create',
            'store' => 'project_invoice.store',
            'edit' => 'project_invoice.edit',
            'show' => 'project_invoice.show',
            'update' => 'project_invoice.update',
            'delete' => 'project_invoice.delete'
        ]
    ]);

    Route::get('report', 'Project\InvoiceController@report');

    Route::get('assignproject', 'Project\InvoiceController@assign');

    Route::get('project_status', 'Project\InvoiceController@status');




    Route::resource('mplatform', 'Master\PlatformController', [
        'names' => [
            'index' => 'mplatform',
            'create' => 'mplatform.create',
            'store' => 'mplatform.store',
            'edit' => 'mplatform.edit',
            'show' => 'mplatform.show',
            'update' => 'mplatform.update',
            'delete' => 'mplatform.delete'
        ]
    ]);

    Route::resource('muser_group', 'Master\UserGroupsController', [
        'names' => [
            'index' => 'muser_group',
            'create' => 'muser_group.create',
            'store' => 'muser_group.store',
            'edit' => 'muser_group.edit',
            'show' => 'muser_group.show',
            'update' => 'muser_group.update',
            'delete' => 'muser_group.delete'
        ]
    ]);

    Route::resource('missue_department', 'Master\IssuesDepartmentController', [
        'names' => [
            'index' => 'missue_department',
            'create' => 'missue_department.create',
            'store' => 'missue_department.store',
            'edit' => 'missue_department.edit',
            'show' => 'missue_department.show',
            'update' => 'missue_department.update',
            'delete' => 'missue_department.delete'
        ]
    ]);
    Route::post('update_issue_dep', 'Master\IssuesDepartmentController@update_issue_dep')->name('update_issue_dep');


//    Route::resource('/', 'BikemasterController', [
//        'names' => [
//            'index' => 'manage_repair_parts'
//        ]
//    ]);


    Route::post('/import_parts', 'ImportPartsExcelController@import')->name('importParts');

    Route::get('manage_repair/invoice/{id}', 'ManageRepairController@pdfInvoice')->name('pdfInvoice');
    Route::get('parts_request/{id}', 'ManageRepairController@parts_request')->name('parts_request');


    Route::get('reports/bike', 'ReportsBikeController@index')->name('reports_bike');
    Route::get('reports/bike/summary', 'ReportsBikeController@showBikes')->name('reports_bike_summary');


    // Route::post('return_purchase_value', 'ReturnPurchaseController@update')->name('part_number');
    // Route::post('return_purchase_edit', 'ReturnPurchaseController@edit')->name('part_number');
    // Route::post('return_purchase_store', 'ReturnPurchaseController@store')->name('part_number');
    // Route::post('return_purchase_destroy', 'ReturnPurchaseController@destroy')->name('part_number');
    // Route::post('return_purchase_index', 'ReturnPurchaseController@index')->name('part_number');





    // Route::resource('return_purchase', 'ReturnPurchaseController', [
    //     'names' => [
    //         'index' => 'return_purchase',
    //         'create' => 'return_purchase.create',
    //         'store' => 'return_purchase.store',
    //         'edit' => 'return_purchase.edit',
    //         'show' => 'return_purchase.show',
    //         'update' => 'return_purchase.update',
    //         'delete' => 'return_purchase.delete'
    //     ]
    // ]);



    Route::resource('purchase', 'Maintenance\PurhcaseController', [
        'names' => [
            'index' => 'purchase',
            'create' => 'purchase.create',
            'store' => 'purchase.store',
            'edit' => 'purchase.edit',
            'show' => 'purchase.show',
            'update' => 'purchase.update',
            'delete' => 'purchase.delete'
        ]
    ]);

    Route::get('purchase_view', 'Maintenance\PurhcaseController@purchase_view');
    Route::get('get_purchase_view_table', 'Maintenance\PurhcaseController@get_purchase_view_table')->name('get_purchase_view_table');
    Route::get('purchase_pdf/{id}', 'Maintenance\PurhcaseController@purchase_pdf')->name('purchase_pdf');
    Route::post('verify_purchase', 'Maintenance\PurhcaseController@verify_purchase')->name('verify_purchase');


    Route::post('return_purchase', 'Maintenance\PurhcaseController@return_purchase')->name('return_purchase');
    Route::post('very_purchase',  'Maintenance\PurhcaseController@very_purchase')->name('very_purchase');

    //return purchase view
    Route::get('return_purchase_view', 'Maintenance\PurhcaseController@return_purchase_view');








    Route::post('image/upload', 'ManagepurchaseController@store')->name('image.upload');

    Route::put('read_done/{id}', 'Header\NotificationController@read_done')->name('read_done');
    Route::put('read_done2/{id}', 'Header\NotificationController@read_done2')->name('read_done2');

//Route::post('edit_invoice', 'ManagepurchaseController@edit_invoice')->name('edit_invoice');
    Route::resource('manage_purchase', 'ManagepurchaseController', [
        'names' => [
            'index' => 'manage_purchase',
            'create' => 'manage_purchase.create',
            'store' => 'manage_purchase.store',
            'edit' => 'manage_purchase.edit',
            'show' => 'manage_purchase.show',
            'update' => 'manage_purchase.update',
            'delete' => 'manage_purchase.delete',
            'edit_invoice'=>'manage_purchase.delete',

        ]
    ]);

    // Route::resource('save_invoice', 'BikeinvoicesController');


    Route::resource('save_invoice', 'BikeinvoicesController', [
        'names' => [
            'index' => 'save_invoice',
            'create' => 'save_invoice.create',
            'store' => 'save_invoice.store',
            'edit' => 'save_invoice.edit',
            'show' => 'save_invoice.show',
            'update' => 'save_invoice.update',
            'delete' => 'save_invoice.delete'
        ]
    ]);

    // Route::post('return_purchase_value', 'ReturnPurchaseController@update')->name('part_number');
    // Route::post('return_purchase_edit', 'ReturnPurchaseController@edit')->name('part_number');
    // Route::post('return_purchase_store', 'ReturnPurchaseController@store')->name('part_number');
    // Route::post('return_purchase_destroy', 'ReturnPurchaseController@destroy')->name('part_number');
    // Route::post('return_purchase_index', 'ReturnPurchaseController@index')->name('part_number');





    // Route::resource('return_purchase', 'ReturnPurchaseController', [
    //     'names' => [
    //         'index' => 'return_purchase',
    //         'create' => 'return_purchase.create',
    //         'store' => 'return_purchase.store',
    //         'edit' => 'return_purchase.edit',
    //         'show' => 'return_purchase.show',
    //         'update' => 'return_purchase.update',
    //         'delete' => 'return_purchase.delete'
    //     ]
    // ]);

//new route

    // Route::post('report_purchase_value', 'ReportsPurchaseController@show')->name('vendor_name');
    // Route::post('report_purchase_date', 'ReportsPurchaseController@showReport')->name('to_date');
    // Route::post('report_purchase_data', 'ReportsPurchaseController@showDetail');

    Route::resource('reports/report_purchase', 'ReportsPurchaseController', [
        'names' => [
            'index' => 'report_purchase',
            'create' => 'report_purchase.create',
            'store' => 'report_purchase.store',
            'edit' => 'report_purchase.edit',
            'show' => 'report_purchase.show',
            'update' => 'report_purchase.update',
            'delete' => 'report_purchase.delete'
        ]
    ]);


    Route::get('/getUserInfo', 'User\ManageUserController@getUserinfo')->name('getUserInfo');

    Route::get('user-activities-audit', 'User\ManageUserController@user_activities_audit');
    Route::get('ajax_get_user_activities_report', 'User\ManageUserController@ajax_get_user_activities_report')->name('ajax_get_user_activities_report');
    Route::resource('manage_user', 'User\ManageUserController', [
        'names' => [
            'index' => 'manage_user',
            'create' => 'manage_user.create',
            'store' => 'manage_user.store',
            'edit' => 'manage_user.edit',
            'show' => 'manage_user.show',
            'update' => 'manage_user.update',
            'delete' => 'manage_user.delete',
        ]
    ]);



    Route::post('get_user_department_wise', 'User\ManageUserController@get_user_department_wise')->name('get_user_department_wise');
    Route::post('get_user_internal_department_wise', 'User\ManageUserController@get_user_internal_department_wise')->name('get_user_internal_department_wise');

    //get agreement designation license info
    Route::post('get_agreement_designation', 'Agreement\AgreementController@get_agreement_designation')->name('get_agreement_designation');

    //get driving license info
    Route::post('ajax_get_driving_license', 'Agreement\AgreementController@ajax_get_driving_license')->name('ajax_get_driving_license');


    //manage user route modified
//    Route::get('agreement', 'Agreement\AgreementController@agreement')->name('agreement');
    Route::post('ajax_get_unique_passport', 'Agreement\AgreementController@ajax_get_unique_passport')->name('ajax_get_unique_passport');

    //employee type change
    Route::post('ajax_employee_type', 'Agreement\AgreementController@ajax_employee_type')->name('ajax_employee_type');

    //agreement category
    Route::get('category', 'Agreement\AgreementController@category')->name('category');
    Route::post('save_category', 'Agreement\AgreementController@save_category')->name('save_category');
    Route::get('testing_blade', 'Agreement\AgreementController@testing_blade')->name('testing_blade');

    //agreement Selection routes
    Route::post('ajax_render_child', 'Agreement\AgreementController@ajax_render_child')->name('ajax_render_child');
    Route::post('save_agreement_selection', 'Agreement\AgreementController@save_agreement_selection')->name('save_agreement_selection');
    Route::get('agreement_selection', 'Agreement\AgreementController@agreement_selection')->name('agreement_selection');


    //check amount agreement selection
    Route::post('ajax_check_amount_current_status', 'Agreement\AgreementController@ajax_check_amount_current_status')->name('ajax_check_amount_current_status');
    Route::post('ajax_check_amount_driving_license', 'Agreement\AgreementController@ajax_check_amount_driving_license')->name('ajax_check_amount_driving_license');
    Route::post('ajax_check_child_driving_license', 'Agreement\AgreementController@ajax_check_child_driving_license')->name('ajax_check_child_driving_license');
    Route::post('ajax_edit_amount_agreement', 'Agreement\AgreementController@ajax_edit_amount_agreement')->name('ajax_edit_amount_agreement');
    Route::post('update_amount_agreement', 'Agreement\AgreementController@update_amount_agreement')->name('update_amount_agreement');



    //medical routes
    Route::post('ajax_check_child_medical_company', 'Agreement\AgreementController@ajax_check_child_medical_company')->name('ajax_check_child_medical_company');
    Route::post('ajax_check_amount_medical_amount', 'Agreement\AgreementController@ajax_check_amount_medical_amount')->name('ajax_check_amount_medical_amount');

    //emirates id
    Route::post('ajax_check_amount_emirates_id', 'Agreement\AgreementController@ajax_check_amount_emirates_id')->name('ajax_check_amount_emirates_id');

    //status change
    Route::post('ajax_check_amount_status_change', 'Agreement\AgreementController@ajax_check_amount_status_change')->name('ajax_check_amount_status_change');

    //in case fine
    Route::post('ajax_check_amount_case_fine', 'Agreement\AgreementController@ajax_check_amount_case_fine')->name('ajax_check_amount_case_fine');

    // Rta Permit
    Route::post('ajax_check_amount_rta_permit', 'Agreement\AgreementController@ajax_check_amount_rta_permit')->name('ajax_check_amount_rta_permit');

    //agreement pdf
    Route::get('agreement_pdf/{id}', 'Agreement\AgreementController@agreement_pdf')->name('agreement_pdf');

    //agreement complete pdf
    Route::get('agreement_complete_pdf/{id}', 'Agreement\AgreementController@agreement_complete_pdf')->name('agreement_complete_pdf');

    //upload signed Agreement
    Route::post('upload_signed_agreement', 'Agreement\AgreementController@upload_signed_agreement')->name('upload_signed_agreement');

    //get arr balance for balance
    Route::post('get_ar_balance_agreement', 'Agreement\AgreementController@get_ar_balance_agreement')->name('get_ar_balance_agreement');




//    Route::resource('agreement','Agreement\AgreementController',[
//        'names' => [
//            'index' => 'agreement',
//            'create' => 'agreement.create',
//            'store' => 'agreement.store',
//            'edit' => 'agreement.edit',
//            'show' => 'agreement.show',
//            'update' => 'agreement.update',
//            'delete' => 'agreement.delete',
//        ]
//    ]);


    Route::resource('agreement_amendment','Agreement\AmendmentController',[
        'names' => [
            'index' => 'agreement_amendment',
            'create' => 'agreement_amendment.create',
            'store' => 'agreement_amendment.store',
            'edit' => 'agreement_amendment.edit',
            'show' => 'agreement_amendment.show',
            'update' => 'agreement_amendment.update',
            'delete' => 'agreement_amendment.delete',
        ]
    ]);

    Route::get('amendment_complete_pdf/{id}', 'Agreement\AmendmentController@amendment_complete_pdf')->name('amendment_complete_pdf');
    Route::post('get_amendment_history_ajax', 'Agreement\AmendmentController@get_amendment_history_ajax')->name('get_amendment_history_ajax');



//    passport handler status routes

    Route::post('ajax_get_current_passport_status', 'PassportHandlerStatus\PassportHandlerStatusController@ajax_get_current_passport_status')->name('ajax_get_current_passport_status');

    Route::resource('passport_handler','PassportHandlerStatus\PassportHandlerStatusController',[
        'names' => [
            'index' => 'passport_handler',
            'create' => 'passport_handler.create',
            'store' => 'passport_handler.store',
            'edit' => 'passport_handler.edit',
            'show' => 'passport_handler.show',
            'update' => 'passport_handler.update',
            'delete' => 'passport_handler.delete',
        ]
    ]);

    Route::post('save_passport_handle_with_ajax', 'Passport\PassportCollectController@save_passport_handle_with_ajax')->name('save_passport_handle_with_ajax');


    //    Driving License Steps routes

    Route::post('ajax_get_driving_current_status', 'DrivingLicenseStep\DrivingLicenseStepController@ajax_get_driving_current_status')->name('ajax_get_driving_current_status');

    Route::resource('driving_license_step','DrivingLicenseStep\DrivingLicenseStepController',[
        'names' => [
            'index' => 'driving_license_step',
            'create' => 'driving_license_step.create',
            'store' => 'driving_license_step.store',
            'edit' => 'driving_license_step.edit',
            'show' => 'driving_license_step.show',
            'update' => 'driving_license_step.update',
            'delete' => 'driving_license_step.delete',
        ]
    ]);

   //on Board Controller Routes

    Route::resource('onboard','OnBoard\OnBoardController',[
        'names' => [
            'index' => 'onboard',
            'create' => 'onboard.create',
            'store' => 'onboard.store',
            'edit' => 'onboard.edit',
            'show' => 'onboard.show',
            'update' => 'onboard.update',
            'delete' => 'onboard.delete',
        ]
    ]);

    Route::get('vacation_accident_rider', 'OnBoard\OnBoardController@vacation_accident_rider')->name('vacation_accident_rider');
    Route::get('on_board_without_ppuid', 'OnBoard\OnBoardController@on_board_without_ppuid')->name('on_board_without_ppuid');
    Route::post('save_training_result', 'OnBoard\OnBoardController@save_training_result')->name('save_training_result');
    Route::get('waiting_for_training', 'OnBoard\OnBoardController@waiting_for_training')->name('waiting_for_training');
    Route::get('waiting_for_reservation', 'OnBoard\OnBoardController@waiting_for_reservation')->name('waiting_for_reservation');
    Route::get('render_vehicle_free_for_reservation', 'OnBoard\OnBoardController@render_vehicle_free_for_reservation')->name('render_vehicle_free_for_reservation');
    Route::POST('save_reservation', 'OnBoard\OnBoardController@save_reservation')->name('save_reservation');
    Route::GET('reserved_report', 'OnBoard\OnBoardController@reserved_report')->name('reserved_report');
    Route::POST('assigned_reserved_bikes', 'OnBoard\OnBoardController@assigned_reserved_bikes')->name('assigned_reserved_bikes');

    //    cods controller route
    Route::resource('cods','Cods\CodsController',[
        'names' => [
            'index' => 'cods',
            'create' => 'cods.create',
            'store' => 'cods.store',
            'edit' => 'cods.edit',
            'show' => 'cods.show',
            'update' => 'cods.update',
            'delete' => 'cods.delete',
        ]
    ]);

    Route::get('cod_dashboard', 'Cods\CodsController@cod_dashboard')->name('cod_dashboard');
    Route::get('ajax_cod_dashboard', 'Cods\CodsController@ajax_cod_dashboard')->name('ajax_cod_dashboard');
    Route::post('cod_amount_delete', 'Cods\CodsController@cod_amount_delete')->name('cod_amount_delete');
    Route::get('cod_close_month', 'Cods\CodsController@cod_close_month')->name('cod_close_month');
    Route::post('cod_close_month_ajax', 'Cods\CodsController@cod_close_month_ajax')->name('cod_close_month_ajax');
    Route::post('ajax_view_cod_message', 'Cods\CodsController@ajax_view_cod_message')->name('ajax_view_cod_message');
    Route::post('image_cods', 'Cods\CodsController@image_cod')->name('image_cods');
    Route::get('close_month_report','Cods\CodsController@close_month_report')->name('close_month_report');
    Route::get('ajax_close_month_report','Cods\CodsController@ajax_close_month_report')->name('ajax_close_month_report');
    Route::post('ajax_total_close_month','Cods\CodsController@ajax_total_close_month')->name('ajax_total_close_month');
    Route::get('view_balance_cod','Cods\CodsController@view_balance_cod')->name('view_balance_cod');
    Route::post('ajax_balance_cod','Cods\CodsController@ajax_balance_cod')->name('ajax_balance_cod');
    Route::post('save_deliveroo_followup','Cods\CodsController@save_followup')->name('save_deliveroo_followup');
    Route::get('deliveroo_follow_up_calls','Cods\CodsController@follow_up_calls')->name('deliveroo_follow_up_calls');
    //cod bank request addition
    Route::get('add_cod_bank_request', 'Cods\CodsController@add_cod_bank_request')->name('add_cod_bank_request');
    Route::get('add_cod_cash_request', 'Cods\CodsController@add_cod_cash_request')->name('add_cod_cash_request');
    Route::post('store_cod_cash_request', 'Cods\CodsController@store_cod_cash_request')->name('store_cod_cash_request');
    Route::post('cod_get_passport_detail', 'Cods\CodsController@cod_get_passport_detail')->name('cod_get_passport_detail');
    Route::post('add_cod_bank_store', 'Cods\CodsController@add_cod_bank_store')->name('add_cod_bank_store');
    Route::get('cod_edit/{id}', 'Cods\CodsController@cod_edit')->name('cod_edit');
    Route::get('edit_cod_bank/{id}', 'Cods\CodsController@edit_cod_bank')->name('edit_cod_bank');

    Route::post('get_rider_id_by_platform', 'Cods\CodsController@get_rider_id_by_platform')->name('get_rider_id_by_platform');
    Route::get('add_cod_adjust','Cods\CodAdjustController@add_cod_adjust')->name('add_cod_adjust');
    Route::post('cod_adjust_save','Cods\CodAdjustController@cod_adjust_save')->name('cod_adjust_save');
    Route::get('delete_cod_by_date','Cods\CodsController@delete_cod_by_date')->name('delete_cod_by_date');
    Route::post('get_delete_cods','Cods\CodsController@get_delete_cods')->name('get_delete_cods');
    Route::post('delete_cods_by_date','Cods\CodsController@delete_cods_by_date')->name('delete_cods_by_date');

    //    cods Adjust controller route
    Route::resource('cod_adjust','Cods\CodAdjustController',[
        'names' => [
            'index' => 'cod_adjust',
            'create' => 'cod_adjust.create',
            'store' => 'cod_adjust.store',
            'edit' => 'cod_adjust.edit',
            'show' => 'cod_adjust.show',
            'update' => 'cod_adjust.update',
            'delete' => 'cod_adjust.delete',
        ]
    ]);

    Route::get('cod_bank', 'Cods\CodsController@cod_bank')->name('cod_bank');
    Route::post('cod_adjust_amt_delete', 'Cods\CodAdjustController@cod_adjust_amt_delete')->name('cod_adjust_amt_delete');
    Route::get('cod_bank_issue', 'Cods\CodsController@cod_bank_issue')->name('cod_bank_issue');
    Route::get('cod_detail/{id}', 'Cods\CodsController@cod_detail')->name('cod_detail');
    Route::get('rider_cod', 'Cods\CodsController@rider_cod')->name('rider_cod');
    Route::get('cash_paid_detail/{id}', 'Cods\CodsController@cash_paid_detail')->name('cash_paid_detail');
    Route::get('bank_paid_detail/{id}', 'Cods\CodsController@bank_paid_detail')->name('bank_paid_detail');
    Route::post('ajax_cod_history', 'Cods\CodsController@ajax_cod_history')->name('ajax_cod_history');
    Route::post('cod_save_close_month', 'Cods\CodsController@cod_save_close_month')->name('cod_save_close_month');
    Route::post('ajax_total_cod','Cods\CodsController@cod_total')->name('ajax_total_cod');
    Route::post('ajax_total_cod_not','Cods\CodsController@cod_total_not')->name('ajax_total_cod_not');
    Route::post('ajax_total_cod_reject','Cods\CodsController@cod_total_reject')->name('ajax_total_cod_reject');

    Route::get('cod_rider_log/{id}', 'Cods\CodsController@cod_rider_log')->name('cod_rider_log');
    Route::get('rider_wise_cod_deliveroo', 'Cods\CodsController@rider_wise_cod_deliveroo')->name('rider_wise_cod_deliveroo');
    Route::get('active_rider_report', 'Cods\CodsController@active_rider_report')->name('active_rider_report');
    Route::get('render_riders', 'Cods\CodsController@render_riders')->name('render_riders');
    Route::post('filter_rider_report', 'Cods\CodsController@filter_rider_report')->name('filter_rider_report');
    Route::get('add_rider_followup','Cods\CodsController@add_rider_followup')->name('add_rider_followup');
    Route::post('save_followup_rider','Cods\CodsController@save_followup_rider')->name('save_followup_rider');
    Route::get('rider_followup_edit/{id}','Cods\CodsController@rider_followup_edit')->name('rider_followup_edit');
    Route::PUT('rider_followup_update/{id}','Cods\CodsController@rider_followup_update')->name('rider_followup_update');
    Route::post('change_status_follow','Cods\CodsController@change_status_follow')->name('change_status_follow');
    Route::post('add_remark_rider','Cods\CodsController@add_remark_rider')->name('add_remark_rider');
    Route::get('get_rider_followups','Cods\CodsController@get_rider_followups')->name('get_rider_followups');

    Route::get('get_rider_list_deliveroo', 'Cods\CodsController@get_rider_list_deliveroo')->name('get_rider_list_deliveroo');
    Route::post('ajax_rider_report_deliveroo', 'Cods\CodsController@ajax_rider_report_deliveroo')->name('ajax_rider_report_deliveroo');
    Route::post('cod_rider_log_ajax', 'Cods\CodsController@cod_rider_log_ajax')->name('cod_rider_log_ajax');
    Route::post('cod_rider_log_balance_ajax', 'Cods\CodsController@cod_rider_log_balance_ajax')->name('cod_rider_log_balance_ajax');
    Route::get('download_rider_log', 'Cods\CodsController@download_rider_log')->name('download_rider_log');
    Route::post('ajax_total_cod_cash','Cods\CodsController@ajax_total_cod_cash')->name('ajax_total_cod_cash');
    Route::post('ajax_total_cod_cash_not','Cods\CodsController@ajax_total_cod_cash_not')->name('ajax_total_cod_cash_not');
    Route::post('ajax_total_cod_cash_reject','Cods\CodsController@ajax_total_cod_cash_reject')->name('ajax_total_cod_cash_reject');
    Route::post('ajax_total_cod_adjust_approve','Cods\CodAdjustController@ajax_total_cod_adjust_approve')->name('ajax_total_cod_adjust_approve');
    Route::post('ajax_total_cod_adjust_reject','Cods\CodAdjustController@ajax_total_cod_adjust_reject')->name('ajax_total_cod_adjust_reject');
    Route::post('ajax_total_cod_adjust_pend','Cods\CodAdjustController@ajax_total_cod_adjust_pend')->name('ajax_total_cod_adjust_pend');
    Route::get('rider_sim_bike_report', 'Cods\CodsController@rider_sim_bike_report')->name('rider_sim_bike_report');
    Route::post('ajax_sim_bike_report', 'Cods\CodsController@ajax_sim_bike_report')->name('ajax_sim_bike_report');
    Route::post('get_city_button', 'Cods\CodsController@get_city_button')->name('get_city_button');
    Route::post('get_platforms_report', 'Cods\CodsController@get_platforms')->name('get_platforms_report');
    Route::post('get_platforms_checkout', 'Cods\CodsController@get_platforms_checkout')->name('get_platforms_checkout');
    Route::post('get_platforms_active', 'Cods\CodsController@get_platforms_active')->name('get_platforms_active');
    Route::get('get_platforms_checkin', 'Cods\CodsController@get_platforms_checkin')->name('get_platforms_checkin');
    Route::get('get_platforms_checkouts', 'Cods\CodsController@get_platforms_checkouts')->name('get_platforms_checkouts');
    Route::get('get_platforms_actives', 'Cods\CodsController@get_platforms_actives')->name('get_platforms_actives');
    Route::post('get_sim_checkin', 'Cods\CodsController@get_sim_checkin')->name('get_sim_checkin');
    Route::post('get_sim_checkout', 'Cods\CodsController@get_sim_checkout')->name('get_sim_checkout');
    Route::get('get_platforms_sim', 'Cods\CodsController@get_platforms_sim')->name('get_platforms_sim');

    //cod dashboard
    Route::get('cod_dashboard_new', 'DashboardController@cod_dashboard_new')->name('cod_dashboard_new');
    Route::get('visa_dashboard_new', 'DashboardController@visa_dashboard_new')->name('visa_dashboard_new');

    //cods uploads
    Route::resource('cod_uploads', 'CodUpload\CodUploadController', [
        'names' => [
            'index' => 'cod_uploads',
            'create' => 'cod_uploads.create',
            'store' => 'cod_uploads.store',
            'edit' => 'cod_uploads.edit',
            'show' => 'cod_uploads.show',
            'update' => 'cod_uploads.update',
            'delete' => 'cod_uploads.delete'
        ]
    ]);

    Route::get('missing_rider_id', 'CodUpload\CodUploadController@missing_rider_id')->name('missing_rider_id');
    Route::get('uploaded_data', 'CodUpload\CodUploadController@uploaded_data')->name('uploaded_data');
    Route::post('get_cod_total_amount_ajax', 'CodUpload\CodUploadController@get_cod_total_amount_ajax')->name('get_cod_total_amount_ajax');
    Route::post('ajax_total_amount', 'CodUpload\CodUploadController@ajax_total_amount')->name('ajax_total_amount');
    Route::post('render_calender', 'CodUpload\CodUploadController@render_calender')->name('render_calender');
    Route::post('get_plaform_batch_dates', 'CodUpload\CodUploadController@get_plaform_batch_dates')->name('get_plaform_batch_dates');

    //    careeer controller route

    Route::post('ajax_view_remarks', 'Career\CareerContrller@ajax_view_remarks')->name('ajax_view_remarks');
    Route::post('ajax_view_detail', 'Career\CareerContrller@ajax_view_detail')->name('ajax_view_detail');
    Route::post('ajax_career_remark', 'Career\CareerContrller@ajax_career_remark')->name('ajax_career_remark');
    Route::post('ajax_career_remark_rejoin', 'Career\CareerContrller@ajax_career_remark_rejoin')->name('ajax_career_remark_rejoin');
    Route::post('ajax_career_remark_rejon_remarks', 'Career\CareerContrller@ajax_career_remark_rejon_remarks')->name('ajax_career_remark_rejon_remarks');



    Route::post('ajax_read_more_remark', 'Career\CareerContrller@ajax_read_more_remark')->name('ajax_read_more_remark');
    Route::post('ajax_read_more_company_remark', 'Career\CareerContrller@ajax_read_more_company_remark')->name('ajax_read_more_company_remark');
    Route::post('ajax_search_career_table', 'Career\CareerContrller@ajax_search_career_table')->name('ajax_search_career_table');
    Route::post('ajax_search_license_count', 'Career\CareerContrller@ajax_search_license_count')->name('ajax_search_license_count');
    Route::post('ajax_search_visa_count', 'Career\CareerContrller@ajax_search_visa_count')->name('ajax_search_visa_count');
    Route::post('ajax_filter_color', 'Career\CareerContrller@ajax_filter_color')->name('ajax_filter_color');

    Route::post('get_ajax_filter_color_block_count', 'Career\CareerContrller@get_ajax_filter_color_block_count')->name('get_ajax_filter_color_block_count');

//    Route::post('ajax_filter_color_career_pending', 'Career\CareerContrller@ajax_filter_color_career_pending')->name('ajax_filter_color_career_pending');

    Route::get('career_shortlisted', 'Career\CareerContrller@career_shortlisted')->name('career_shortlisted');
    Route::get('career_rejected', 'Career\CareerContrller@career_rejected')->name('career_rejected');
    Route::get('career_document_pending', 'Career\CareerContrller@career_document_pending')->name('career_document_pending');
    Route::get('career_hired', 'Career\CareerContrller@career_hired')->name('career_hired');
    Route::get('career_wait_list', 'Career\CareerContrller@career_wait_list')->name('career_wait_list');
    Route::post('save_passport_passport', 'Career\CareerContrller@save_passport_passport')->name('save_passport_passport');
    Route::post('render_shortlist_tabs_table', 'Career\CareerContrller@render_shortlist_tabs_table')->name('render_shortlist_tabs_table');
    Route::post('update_after_short_list', 'Career\CareerContrller@update_after_short_list')->name('update_after_short_list');
    Route::get('career_change_status', 'Career\CareerContrller@change_status')->name('career_change_status');
    Route::get('career_add_ppuid', 'Career\CareerContrller@career_add_ppuid')->name('career_add_ppuid');
    Route::post('ajax_filter_report_change_status', 'Career\CareerContrller@ajax_filter_report_change_status')->name('ajax_filter_report_change_status');
    Route::post('ajax_filter_report_add_ppuid', 'Career\CareerContrller@ajax_filter_report_add_ppuid')->name('ajax_filter_report_add_ppuid');
    Route::post('get_color_block_count_ajax_change_status', 'Career\CareerContrller@get_color_block_count_ajax_change_status')->name('get_color_block_count_ajax_change_status');

    Route::resource('career','Career\CareerContrller',[
        'names' => [
            'index' => 'career',
            'create' => 'career.create',
            'store' => 'career.store',
            'edit' => 'career.edit',
            'show' => 'career.show',
            'update' => 'career.update',
            'delete' => 'career.delete',
        ]
    ]);

    Route::post('save_passport_id_ajax', 'Career\CareerContrller@save_passport_id_ajax')->name('save_passport_id_ajax');
    Route::post('save_passport_id_four_pl_ajax', 'Career\CareerContrller@save_passport_id_four_pl_ajax')->name('save_passport_id_four_pl_ajax');

    //verification controller

    Route::post('ajax_verification_detail', 'Verification\VerificationController@ajax_verification_detail')->name('ajax_verification_detail');

    Route::resource('verification','Verification\VerificationController',[
        'names' => [
            'index' => 'verification',
            'create' => 'verification.create',
            'store' => 'verification.store',
            'edit' => 'verification.edit',
            'show' => 'verification.show',
            'update' => 'verification.update',
            'delete' => 'verification.delete',
        ]
    ]);

    //document selection

    Route::resource('document_selection','Agreement\DocumentTreeController',[
        'names' => [
            'index' => 'document_selection',
            'create' => 'document_selection.create',
            'store' => 'document_selection.store',
            'edit' => 'document_selection.edit',
            'show' => 'document_selection.show',
            'update' => 'document_selection.update',
            'delete' => 'document_selection.delete',

        ]
    ]);

    //department controller routes

    Route::post('ajax_edit_contact', 'DepartmentContact\DepartmentContactController@ajax_edit_contact')->name('ajax_edit_contact');

    Route::resource('department_contact','DepartmentContact\DepartmentContactController',[
        'names' => [
            'index' => 'department_contact',
            'create' => 'department_contact.create',
            'store' => 'department_contact.store',
            'edit' => 'department_contact.edit',
            'show' => 'department_contact.show',
            'update' => 'department_contact.update',
            'delete' => 'department_contact.delete',

        ]
    ]);


    //document_check_document_exist
    Route::post('ajax_check_document_current_status', 'Agreement\DocumentTreeController@ajax_check_document_current_status')->name('ajax_check_document_current_status');
    Route::post('ajax_check_document_driving_license', 'Agreement\DocumentTreeController@ajax_check_document_driving_license')->name('ajax_check_document_driving_license');
    Route::post('ajax_check_document_document_process', 'Agreement\DocumentTreeController@ajax_check_document_document_process')->name('ajax_check_document_document_process');
    Route::post('ajax_check_document_emirates_id', 'Agreement\DocumentTreeController@ajax_check_document_emirates_id')->name('ajax_check_document_emirates_id');
    Route::post('ajax_check_document_status_change', 'Agreement\DocumentTreeController@ajax_check_document_status_change')->name('ajax_check_document_status_change');
    Route::post('ajax_check_document_case_fine', 'Agreement\DocumentTreeController@ajax_check_document_case_fine')->name('ajax_check_document_case_fine');
    Route::post('ajax_check_document_rta_permit', 'Agreement\DocumentTreeController@ajax_check_document_rta_permit')->name('ajax_check_document_rta_permit');



    Route::resource('ticket', 'Ticket\TicketController', [
        'names' => [
            'index' => 'ticket',
            'create' => 'ticket.create',
            'store' => 'ticket.store',
            'edit' => 'ticket.edit',
            'show' => 'ticket.show',
            'update' => 'ticket.update',
            'delete' => 'ticket.delete',

        ]
    ]);

    Route::get('approve_tickets', 'Ticket\TicketController@approve_tickets')->name('approve_tickets');
    Route::get('approve_tickets_teamlead', 'Ticket\TicketController@approve_tickets_teamlead')->name('approve_tickets_teamlead');
    Route::get('approve_tickets_manager', 'Ticket\TicketController@approve_tickets_manager')->name('approve_tickets_manager');
    Route::post('approve_ticket_save', 'Ticket\TicketController@approve_ticket_save')->name('approve_ticket_save');
    Route::post('get_ticket_chat', 'Ticket\TicketController@get_ticket_chat')->name('get_ticket_chat');
    Route::post('ajax_ticket_filter_count_colors', 'Ticket\TicketController@ajax_ticket_filter_count_colors')->name('ajax_ticket_filter_count_colors');
    Route::post('ajax_tickets_color_wise', 'Ticket\TicketController@ajax_tickets_color_wise')->name('ajax_tickets_color_wise');




//    Route::post('ticket_start', 'Ticket\TicketController@ticket_start')->name('ticket_start');
//    Route::get('ticket_start/{id}', 'Ticket\TicketController@ticket_start')->name('ticket_start');
//    Route::resource('ticket_start', 'Ticket\TicketController@ticket_start');
    Route::get('ticket_start', 'Ticket\TicketController@ticket_start');


    Route::resource('rider_profile', 'Ticket\ProfileRiderController', [
        'names' => [
            'index' => 'rider_profile',
            'create' => 'rider_profile.create',
            'store' => 'rider_profile.store',
            'edit' => 'rider_profile.edit',
            'show' => 'rider_profile.show',
            'update' => 'rider_profile.update',
            'delete' => 'rider_profile.delete'
        ]
    ]);

    Route::resource('manage_ticket', 'Ticket\ManageTicketController', [
        'names' => [
            'index' => 'manage_ticket',
            'create' => 'manage_ticket.create',
            'store' => 'manage_ticket.store',
            'edit' => 'manage_ticket.edit',
            'show' => 'manage_ticket.show',
            'update' => 'manage_ticket.update',
            'delete' => 'manage_ticket.delete'
        ]
    ]);

    Route::post('ajax_ticket_info', 'Ticket\ManageTicketController@ajax_ticket_info')->name('ajax_ticket_info');

    Route::post('internal_ticket_assign', 'Ticket\ManageTicketController@internal_ticket_assign')->name('internal_ticket_assign');

    Route::get('ticket_share', 'Ticket\TicketController@ticket_share');

    Route::get('show_shared/{id}', 'Ticket\ManageTicketController@show_shared')->name('show_shared');

    Route::post('ajax_ticket_log', 'Ticket\ManageTicketController@ajax_ticket_log')->name('ajax_ticket_log');


    Route::resource('manage_alerts', 'Alert\RegisterAlertsController', [
        'names' => [
            'index' => 'manage_alerts',
            'create' => 'manage_alerts.create',
            'store' => 'manage_alerts.store',
            'edit' => 'manage_alerts.edit',
            'show' => 'manage_alerts.show',
            'update' => 'manage_alerts.update',
            'delete' => 'manage_alerts.delete'
        ]
    ]);

    Route::post('send_ticket_message', 'Ticket\ManageTicketController@store_message')->name('send_ticket_message');
    Route::post('send_ticket_voice_note', 'Ticket\ManageTicketController@send_ticket_voice_note')->name('send_ticket_voice_note');

    Route::get('get_updated_notification', 'Header\NotificationController@get_notification')->name('get_updated_notification');
    Route::get('get_updated_notification2', 'Header\NotificationController@get_notification2')->name('get_updated_notification2');

   Route::get('ticket/download/{filename}', 'Ticket\TicketController@fileDownload')->name('download-voice');

    // form upload routes
    Route::resource('upload_form', 'UploadFormsController', [
        'names' => [
            'index' => 'upload_form',
            'create' => 'upload_form.create',
            'store' => 'upload_form.store',
            'edit' => 'upload_form.edit',
            'show' => 'upload_form.show',
            'update' => 'upload_form.update',
            'delete' => 'upload_form.delete'
        ]
    ]);

    Route::post('/form_upload', 'ImportUploadFormsController@import')->name('form_upload');
    Route::post('/form_upload2', 'ImportUploadFormsController@import2')->name('form_upload2');
    Route::post('/form_upload3', 'ImportUploadFormsController@import3')->name('form_upload3');
    Route::post('/form_upload4', 'ImportUploadFormsController@import4')->name('form_upload4');

    Route::post('/ppuid', 'ImportUploadFormsController@ppuid')->name('ppuid');

//view forms routes
    Route::resource('view_form', 'ViewFormsController', [
        'names' => [
            'index' => 'view_form',
            'create' => 'view_form.create',
            'store' => 'view_form.store',
            'edit' => 'view_form.edit',
            'show' => 'view_form.show',
            'update' => 'view_form.update',
            'delete' => 'view_form.delete'
        ]
    ])->middleware(['sim_inventory']);

    Route::post('view_forms', 'ViewFormsController@show')->name('view_forms');
    Route::get('fine_edit/{id}', 'ViewFormsController@fine_edit')->name('fine_edit');
    Route::get('fuel_edit/{id}', 'ViewFormsController@fuel_edit')->name('fuel_edit');
    Route::get('fuel_rta/{id}', 'ViewFormsController@rta_edit')->name('rta_edit');
    Route::get('ubereats_edit/{id}', 'ViewFormsController@ubereats_edit')->name('ubereats_edit');
    Route::get('employee_edit/{id}', 'ViewFormsController@employee_edit')->name('employee_edit');
    Route::get('uber_edit/{id}', 'ViewFormsController@uber_edit')->name('uber_edit');
    Route::get('telecome_edit/{id}', 'ViewFormsController@telecome_edit')->name('telecome_edit');
    Route::get('bikedetail_edit/{id}', 'ViewFormsController@bikedetail_edit')->name('bikedetail_edit');

    Route::post('ajax_bike_history', 'ViewFormsController@ajax_bike_history')->name('ajax_bike_history');
    Route::post('ajax_bike_cencel', 'ViewFormsController@ajax_bike_cencel')->name('ajax_bike_cencel');
    Route::post('cencel_plate_no_store', 'ViewFormsController@cencel_plate_no_store')->name('cencel_plate_no_store');


//-----------------------------------------------delete forms---------------------------------
    Route::get('fine_destroy/{id}', 'ViewFormsController@fine_destroy')->name('fine_destroy');
    Route::get('feul_destroy/{id}', 'ViewFormsController@fuel_destroy')->name('fuel_destroy');
    Route::get('rta_destroy/{id}', 'ViewFormsController@rta_destroy')->name('rta_destroy');
    Route::get('ubereats_destroy/{id}', 'ViewFormsController@ubereats_destroy')->name('ubereats_destroy');
    Route::get('employee_destroy/{id}', 'ViewFormsController@employee_destroy')->name('employee_destroy');
    Route::get('uber_destroy/{id}', 'ViewFormsController@uber_destroy')->name('uber_destroy');

//upload category
    Route::resource('upload_category', 'UploadCategoryController', [
        'names' => [
            'index' => 'upload_category',
            'create' => 'upload_category.create',
            'store' => 'upload_category.store',
            'edit' => 'upload_category.edit',
            'show' => 'upload_category.show',
            'update' => 'upload_category.update',
            'delete' => 'upload_category.delete'
        ]
    ]);

    Route::post('/upload_category', 'UploadCategoryController@store')->name('upload_category');

//workpermit routes
    Route::resource('work_permit', 'WorkPermitController', [
        'names' => [
            'index' => 'work_permit',
            'create' => 'work_permit.create',
            'store' => 'work_permit.store',
            'edit' => 'work_permit.edit',
            'show' => 'work_permit.show',
            'update' => 'work_permit.update',
            'delete' => 'work_permit.delete'
        ]
    ]);
//e-visa routes
    Route::resource('e_visa', 'E_visaController', [
        'names' => [
            'index' => 'e_visa',
            'create' => 'e_visa.create',
            'store' => 'e_visa.store',
            'edit' => 'e_visa.edit',
            'show' => 'e_visa.show',
            'update' => 'e_visa.update',
            'delete' => 'e_visa.delete'
        ]
    ]);
//status-change
    Route::resource('change_status', 'ChangeStatusController', [
        'names' => [
            'index' => 'change_status',
            'create' => 'change_status.create',
            'store' => 'change_status.store',
            'edit' => 'change_status.edit',
            'show' => 'change_status.show',
            'update' => 'change_status.update',
            'delete' => 'change_status.delete'
        ]
    ]);
    Route::resource('medical_info', 'MedicalInfoController', [
        'names' => [
            'index' => 'medical_info',
            'create' => 'medical_info.create',
            'store' => 'medical_info.store',
            'edit' => 'medical_info.edit',
            'show' => 'medical_info.show',
            'update' => 'medical_info.update',
            'delete' => 'medical_info.delete'
        ]
    ]);
    Route::resource('labour_approval', 'LabourApprovalController', [
        'names' => [
            'index' => 'labour_approval',
            'create' => 'labour_approval.create',
            'store' => 'labour_approval.store',
            'edit' => 'labour_approval.edit',
            'show' => 'labour_approval.show',
            'update' => 'labour_approval.update',
            'delete' => 'labour_approval.delete'
        ]
    ]);

    Route::resource('residence_visa', 'ResidenceVisaController', [
        'names' => [
            'index' => 'residence_visa',
            'create' => 'residence_visa.create',
            'store' => 'residence_visa.store',
            'edit' => 'residence_visa.edit',
            'show' => 'residence_visa.show',
            'update' => 'residence_visa.update',
            'delete' => 'residence_visa.delete'
        ]
    ]);
    Route::resource('eid_reg', 'EidRegistrationController', [
        'names' => [
            'index' => 'eid_reg',
            'create' => 'eid_reg.create',
            'store' => 'eid_reg.store',
            'edit' => 'eid_reg.edit',
            'show' => 'eid_reg.show',
            'update' => 'eid_reg.update',
            'delete' => 'eid_reg.delete'
        ]
    ]);
//Route::resource('star', 'StarController');

    Route::resource('star', 'StarController', [
        'names' => [
            'index' => 'star',
            'create' => 'star.create',
            'store' => 'star.store',
            'edit' => 'star.edit',
            'show' => 'star.show',
            'update' => 'star.update',
            'delete' => 'star.delete'
        ]
    ]);
//Route::resource('star_menu', 'StarMenuController');
    Route::resource('star_menu', 'StarMenuController', [
        'names' => [
            'index' => 'star_menu',
            'create' => 'star_menu.create',
            'store' => 'star_menu.store',
            'edit' => 'star_menu.edit',
            'show' => 'star_menu.show',
            'update' => 'star_menu.update',
            'delete' => 'star_menu.delete'
        ]
    ]);
//visa Master Routes
    Route::resource('visa_master', 'VisaProcess\VisaStepsController', [
        'names' => [
            'index' => 'visa_master',
            'create' => 'visa_master.create',
            'store' => 'visa_master.store',
            'edit' => 'visa_master.edit',
            'show' => 'visa_master.show',
            'update' => 'visa_master.update',
            'delete' => 'visa_master.delete'
        ]
    ]);
//additoinal Passport
    Route::resource('addtional_passport', 'Passport\PassportAddtionalController', [
        'names' => [
            'index' => 'addtional_passport',
            'create' => 'addtional_passport.create',
            'store' => 'addtional_passport.store',
            'edit' => 'addtional_passport.edit',
            'show' => 'addtional_passport.show',
            'update' => 'addtional_passport.update',
            'delete' => 'addtional_passport.delete'
        ]
    ]);
//passport Routes
    Route::resource('passport', 'Passport\PassportController', [
        'names' => [
            'index' => 'passport',
            'create' => 'passport.create',
            'store' => 'passport.store',
            'edit' => 'passport.edit',
            'show' => 'passport.show',
            'update' => 'passport.update',
            'delete' => 'passport.delete'
        ]
    ]);

    Route::get('passport_dashboard', 'Passport\PassportController@passport_dashboard')->name('passport_dashboard');
    Route::get('get_the_designation_by_subcategory', 'Passport\PassportController@get_the_designation_by_subcategory')->name('get_the_designation_by_subcategory');
    Route::get('rider_dont_have_visa', 'Passport\PassportController@rider_dont_have_visa')->name('rider_dont_have_visa');

    Route::POST('passport_update_only_visa_status', 'Passport\PassportController@passport_update_only_visa_status')->name('passport_update_only_visa_status');

//passport Routes
    Route::resource('country', 'Passport\CountryController', [
        'names' => [
            'index' => 'country',
            'create' => 'country.create',
            'store' => 'country.store',
            'edit' => 'country.edit',
            'show' => 'country.show',
            'update' => 'country.update',
            'delete' => 'country.delete'
        ]
    ]);



    Route::resource('passport_add', 'Passport\PassportAddtionalInfoController', [
        'names' => [
            'index' => 'passport_add',
            'create' => 'passport_add.create',
            'store' => 'passport_add.store',
            'edit' => 'passport_add.edit',
            'show' => 'passport_add.show',
            'update' => 'passport_add.update',
            'delete' => 'passport_add.delete'
        ]
    ]);
    Route::resource('offer_letter', 'VisaProcess\OfferLetterController', [
        'names' => [
            'index' => 'offer_letter',
            'create' => 'offer_letter.create',
            'store' => 'offer_letter.store',
            'edit' => 'offer_letter.edit',
            'show' => 'offer_letter.show',
            'update' => 'offer_letter.update',
            'delete' => 'offer_letter.delete'
        ]
    ]);
    //passport history
    Route::get('passport_history', 'Passport\ViewPassportController@passport_history');
    Route::post('ajax_additional_info_remains', 'Passport\ViewPassportController@ajax_additional_info_remains')->name('ajax_additional_info_remains');

    Route::resource('offer_letter_sub', 'VisaProcess\OfferLetterSubmissionController', [
        'names' => [
            'index' => 'offer_letter_sub',
            'create' => 'offer_letter_sub.create',
            'store' => 'offer_letter_sub.store',
            'edit' => 'offer_letter_sub.edit',
            'show' => 'offer_letter_sub.show',
            'update' => 'offer_letter_sub.update',
            'delete' => 'offer_letter_sub.delete'
        ]
    ]);

    //passport Hnadler Routes (incoming transfer)
    Route::post('passport_collect/transfer', 'Passport\PassportCollectController@transfer')->name('passport_collect.transfer');
    Route::put('passport_collect/cancel_transfer/{id}', 'Passport\PassportCollectController@cancel_transfer')->name('passport_collect.cancel_transfer');
    Route::post('passport_collect/locker', 'Passport\PassportCollectController@locker')->name('passport_collect.locker');
    Route::get('passport_collect/report', 'Passport\PassportCollectController@report')->name('passport_collect.report');
    Route::get('passport_collect/userwise_report', 'Passport\PassportCollectController@userwise_report')->name('passport_collect.userwise_report');
    Route::post('passport_collect/get_passport_name_detail','Assign\AssginBikeController@get_passport_name_detail');
    Route::post('get_passport_details','Passport\PassportCollectController@passport_details')->name('get_passport_details');
    Route::get('passport_collect/autocomplete_fetch_complete_passport', 'Passport\PassportCollectController@autocomplete')->name('passport_collect_autocomplete');
    Route::post('passport_collect/get_full_passport_detail','Passport\PassportCollectController@get_full_passport_detail')->name('get_full_passport_detail');
    Route::resource('passport_collect', 'Passport\PassportCollectController', [
        'names' => [
            'index' => 'passport_collect',
            'create' => 'passport_collect.create',
            'store' => 'passport_collect.store',
            'edit' => 'passport_collect.edit',
            'show' => 'passport_collect.show',
            'update' => 'passport_collect.update',
            'delete' => 'passport_collect.delete'
        ]
    ]);

    //passport Hnadler Routes (outgoing transfer)
    Route::get('request_passport', 'Passport\PassportRequestController@request')->name('request_passport.request');
    Route::post('request_passport', 'Passport\PassportRequestController@store')->name('request_passport.store');
    Route::get('request_passport/list', 'Passport\PassportRequestController@list')->name('request_passport.list');
    Route::put('request_passport/update/{id}', 'Passport\PassportRequestController@update')->name('request_passport.update');
    Route::get('request_passport/locker_transfer', 'Passport\PassportRequestController@locker_transfer')->name('request_passport.locker_transfer');
    Route::post('request_passport/locker_transfer', 'Passport\PassportRequestController@post_locker_transfer')->name('request_passport.post_locker_transfer');
    Route::get('request_passport/outgoing_transfer', 'Passport\PassportRequestController@outgoing_transfer')->name('request_passport.outgoing_transfer');
    Route::put('request_passport/transfer_update/{id}', 'Passport\PassportRequestController@transfer_update')->name('request_passport.update_transfer');
    Route::put('request_passport/cancel_transfer/{id}', 'Passport\\PassportRequestController@cancel_transfer')->name('request_passport.cancel_transfer');
    Route::post('request_passport/post_transfer', 'Passport\PassportRequestController@post_transfer')->name('request_passport.post_transfer');
    Route::post('request_passport/transfer_to_manager', 'Passport\PassportRequestController@transfer_to_manager')->name('request_passport.transfer_to_manager');
    Route::post('request_passport/rider', 'Passport\PassportRequestController@rider')->name('request_passport.rider');
    Route::post('request_passport/locker', 'Passport\PassportRequestController@locker')->name('request_passport.locker');
    Route::get('request_passport/notify_return', 'Passport\PassportRequestController@notify_return')->name('request_passport.notify_return');
    Route::get('autocomplete_request_passport', 'Passport\PassportRequestController@autocomplete')->name('request_passport_autocomplete');


    Route::resource('electronic_pre_app', 'VisaProcess\ElectronicPreApprovalController', [
        'names' => [
            'index' => 'electronic_pre_app',
            'create' => 'electronic_pre_app.create',
            'store' => 'electronic_pre_app.store',
            'edit' => 'electronic_pre_app.edit',
            'show' => 'electronic_pre_app.show',
            'update' => 'electronic_pre_app.update',
            'delete' => 'electronic_pre_app.delete'
        ]
    ]);

    Route::get('ppuid', 'Passport\PassportController@ppuid');

    Route::post('ppuid_store', 'Passport\PassportController@ppuid_store')->name('ppuid_store');
    Route::get('ppuid_edit/{id}', 'Passport\PassportController@ppuid_edit')->name('ppuid_edit');

    Route::get('ppuid_update/{id}', 'Passport\PassportController@ppuid_update')->name('ppuid_update');

    Route::post('elec_pre_app_payment', 'VisaProcess\ElectronicPreApprovalController@elec_pre_app_payment')->name('elec_pre_app_payment');
    Route::get('passport_addition_show', 'Passport\PassportAddtionalInfoController@show')->name('passport_addition_show');
    Route::resource('passport_addition', 'Passport\PassportAddtionalInfoController', [
        'names' => [
            'index' => 'passport_addition',
            'create' => 'passport_addition.create',
            'store' => 'passport_addition.store',
            'edit' => 'passport_addition.edit',
            'show' => 'passport_addition.show',
            'update' => 'passport_addition.update',
            'delete' => 'passport_addition.delete'
        ]
    ]);






    Route::post('ajax_get_passport', 'StarMenuController@ajax_get_passport')->name('ajax_get_passport');

    Route::resource('master_steps', 'Master\MasterStepsController', [
        'names' => [
            'index' => 'master_steps',
            'create' => 'master_steps.create',
            'store' => 'master_steps.store',
            'edit' => 'master_steps.edit',
            'show' => 'master_steps.show',
            'update' => 'master_steps.update',
            'delete' => 'master_steps.delete'
        ]
    ]);
//Entry Print Visa Inside and outside
    Route::resource('entry_visa_inside', 'VisaProcess\EntryPrintVisaController', [
        'names' => [
            'index' => 'entry_visa_inside',
            'create' => 'entry_visa_inside.create',
            'store' => 'entry_visa_inside.store',
            'edit' => 'entry_visa_inside.edit',
            'show' => 'entry_visa_inside.show',
            'update' => 'entry_visa_inside.update',
            'delete' => 'entry_visa_inside.delete'
        ]
    ]);

    Route::post('entry_visa_outside', 'VisaProcess\EntryPrintVisaController@create')->name('entry_visa_outside');

//status change
    Route::resource('status_change', 'VisaProcess\StatusChangeController', [
        'names' => [
            'index' => 'status_change',
            'create' => 'status_change.create',
            'store' => 'status_change.store',
            'edit' => 'status_change.edit',
            'show' => 'status_change.show',
            'update' => 'status_change.update',
            'delete' => 'status_change.delete'
        ]
    ]);

    Route::post('inout_status_change', 'VisaProcess\StatusChangeController@create')->name('inout_status_change');

//Entry Date
    Route::resource('entry_date', 'VisaProcess\EntryDateController', [
        'names' => [
            'index' => 'entry_date',
            'create' => 'entry_date.create',
            'store' => 'entry_date.store',
            'edit' => 'entry_date.edit',
            'show' => 'entry_date.show',
            'update' => 'entry_date.update',
            'delete' => 'entry_date.delete'
        ]
    ]);
    Route::resource('medical', 'VisaProcess\MedicalController', [
        'names' => [
            'index' => 'medical',
            'create' => 'medical.create',
            'store' => 'medical.store',
            'edit' => 'medical.edit',
            'show' => 'medical.show',
            'update' => 'medical.update',
            'delete' => 'medical.delete'
        ]
    ]);
//Medical 48
    Route::post('medical48', 'VisaProcess\MedicalController@medical48')->name('medical48');
    Route::post('medical24', 'VisaProcess\MedicalController@medical24')->name('medical24');
    Route::post('medicalvip', 'VisaProcess\MedicalController@medicalvip')->name('medicalvip');
    Route::post('fit_unfit', 'VisaProcess\MedicalController@fit_unfit')->name('fit_unfit');
    Route::post('amount_pay', 'VisaProcess\VisaStepsController@amountstore')->name('amount_pay');
    Route::GET('visasteps', 'VisaProcess\VisaStepsController@visasteps')->name('visasteps');

//user codes

    Route::post('ajax_usercode_edit', 'UserCodes\UserCodesController@ajax_usercode_edit')->name('ajax_usercode_edit');
    Route::post('make_table_userodes', 'UserCodes\UserCodesController@make_table_userodes')->name('make_table_userodes');
    Route::post('get_specific_rider_plaform_code', 'UserCodes\UserCodesController@get_specific_rider_plaform_code')->name('get_specific_rider_plaform_code');


    Route::resource('emirates_app', 'VisaProcess\EmiratesIdController', [
        'names' => [
            'index' => 'emirates_app',
            'create' => 'emirates_app.create',
            'store' => 'emirates_app.store',
            'edit' => 'emirates_app.edit',
            'show' => 'emirates_app.show',
            'update' => 'emirates_app.update',
            'delete' => 'emirates_app.delete'
        ]
    ]);
    Route::post('finger_print', 'VisaProcess\EmiratesIdController@finger_print')->name('finger_print');

    Route::resource('new_contract', 'VisaProcess\NewContractAppTypingController', [
        'names' => [
            'index' => 'new_contract',
            'create' => 'new_contract.create',
            'store' => 'new_contract.store',
            'edit' => 'new_contract.edit',
            'show' => 'new_contract.show',
            'update' => 'new_contract.update',
            'delete' => 'new_contract.delete'
        ]
    ]);
    Route::post('tawjeeh_class', 'VisaProcess\NewContractAppTypingController@tawjeeh_class')->name('tawjeeh_class');
    Route::post('new_contract_sub', 'VisaProcess\NewContractAppTypingController@new_contract_sub')->name('new_contract_sub');

    Route::resource('labour_card_print', 'VisaProcess\LabourCardController', [
        'names' => [
            'index' => 'labour_card_print',
            'create' => 'labour_card_print.create',
            'store' => 'labour_card_print.store',
            'edit' => 'labour_card_print.edit',
            'show' => 'labour_card_print.show',
            'update' => 'labour_card_print.update',
            'delete' => 'labour_card_print.delete'
        ]
    ]);

    Route::resource('visa_stamp', 'VisaProcess\VisaStampingController', [
        'names' => [
            'index' => 'visa_stamp',
            'create' => 'visa_stamp.create',
            'store' => 'visa_stamp.store',
            'edit' => 'visa_stamp.edit',
            'show' => 'visa_stamp.show',
            'update' => 'visa_stamp.update',
            'delete' => 'visa_stamp.delete'
        ]
    ]);
    Route::post('approval', 'VisaProcess\VisaStampingController@approval')->name('approval');
    Route::post('zajeel', 'VisaProcess\VisaStampingController@zajeel')->name('zajeel');
    Route::post('visa_pasted', 'VisaProcess\VisaStampingController@visa_pasted')->name('visa_pasted');
    Route::post('unique', 'VisaProcess\VisaStampingController@unique')->name('unique');
    Route::post('handover', 'VisaProcess\VisaStampingController@handover')->name('handover');


    Route::post('add_new_platform_code', 'UserCodes\UserCodesController@add_new_platform_code')->name('add_new_platform_code');
    Route::resource('usercodes', 'UserCodes\UserCodesController', [
        'names' => [
            'index' => 'usercodes',
            'create' => 'usercodes.create',
            'store' => 'usercodes.store',
            'edit' => 'usercodes.edit',
            'show' => 'usercodes.show',
            'update' => 'usercodes.update',
            'delete' => 'usercodes.delete'
        ]
    ]);

    Route::post('update_zds_code/{id}', 'UserCodes\UserCodesController@update_zds_code')->name('update_zds_code');





    Route::resource('userids', 'UserCodes\UserIdsController', [
        'names' => [
            'index' => 'userids',
            'create' => 'userids.create',
            'store' => 'userids.store',
            'edit' => 'userids.edit',
            'show' => 'userids.show',
            'update' => 'userids.update',
            'delete' => 'userids.delete'
        ]
    ]);
    Route::GET('userids_passport', 'UserCodes\UserIdsController@userids_passport')->name('userids_passport');
//Assigning SIM

    Route::resource('assign', 'Assign\AssignController', [
        'names' => [
            'index' => 'assign',
            'create' => 'assign.create',
            'store' => 'assign.store',
            'edit' => 'assign.edit',
            'show' => 'assign.show',
            'update' => 'assign.update',
            'delete' => 'assign.delete'
        ]
    ]);

    Route::GET('autocomplete_assign_sim_users', 'Assign\AssignController@autocomplete_assign_sim_users')->name('autocomplete_assign_sim_users');
    Route::GET('autocomplete_assign_sim_users_to_checkout', 'Assign\AssignController@autocomplete_assign_sim_users_to_checkout')->name('autocomplete_assign_sim_users_to_checkout');
    Route::GET('get_asset_checkin_detail', 'Assign\AssignController@get_asset_checkin_detail')->name('get_asset_checkin_detail');



    Route::POST('getBikeData','Assign\AssginBikeController@getBikeData');
    Route::POST('get_passport_name_detail','Assign\AssginBikeController@get_passport_name_detail')->name('get_passport_name_detail');
    Route::get('assign_dashboard','Assign\AssginBikeController@assign_dashboard')->name('assign_dashboard');
    Route::get('download_total_bikes', 'Assign\AssginBikeController@download_total_bikes')->name('download_total_bikes');
    Route::get('download_lease_bikes', 'Assign\AssginBikeController@download_lease_bikes')->name('download_lease_bikes');
    Route::get('download_used_bikes', 'Assign\AssginBikeController@download_used_bikes')->name('download_used_bikes');
    Route::get('download_company_bikes', 'Assign\AssginBikeController@download_company_bikes')->name('download_company_bikes');
    Route::get('download_lease_free_bikes', 'Assign\AssginBikeController@download_lease_free_bikes')->name('download_lease_free_bikes');
    Route::get('download_lease_cancel_bikes', 'Assign\AssginBikeController@download_cancel_bikes')->name('download_lease_cancel_bikes');
    Route::get('download_company_used_bikes', 'Assign\AssginBikeController@download_company_used_bikes')->name('download_company_used_bikes');
    Route::get('download_company_free_bikes', 'Assign\AssginBikeController@download_company_free_bikes')->name('download_company_free_bikes');
    Route::get('download_company_cancel_bikes', 'Assign\AssginBikeController@download_company_cancel_bikes')->name('download_company_cancel_bikes');
    Route::get('download_total_sims', 'Assign\AssginBikeController@download_total_sims')->name('download_total_sims');
    Route::get('download_total_rider_sims', 'Assign\AssginBikeController@download_total_rider_sims')->name('download_total_rider_sims');
    Route::get('download_total_office_sims', 'Assign\AssginBikeController@download_total_office_sims')->name('download_total_office_sims');
    Route::get('download_total_free_sims', 'Assign\AssginBikeController@download_total_free_sims')->name('download_total_free_sims');






    Route::post('sim_get_passport', 'Assign\AssignController@sim_get_passport')->name('sim_get_passport');
    Route::post('bike_assign', 'Assign\AssignController@bike_assign')->name('bike_assign');
    Route::post('plateform_assign', 'Assign\AssignController@plateform_assign')->name('plateform_assign');
    Route::get('bike_assign_edit/{id}', 'Assign\AssignController@bike_assign_edit')->name('bike_assign_edit');
    Route::post('bike_checkout', 'Assign\AssignController@bike_checkout')->name('bike_checkout');
    Route::post('bike_assign', 'Assign\AssignController@bike_assign')->name('bike_assign');
    Route::get('bike_pdf/{id}', 'Assign\AssginBikeController@bike_pdf')->name('bike_pdf');
    Route::get('sim_pdf/{id}', 'Assign\AssignController@sim_pdf')->name('sim_pdf');
    Route::get('office_sim_pdf/{id}', 'Assign\AssignController@office_sim_pdf')->name('office_sim_pdf');
    Route::post('bike_detail', 'Assign\AssginBikeController@bike_detail')->name('bike_detail');



    Route::get('assign_plateform_edit/{id}', 'Assign\AssignController@assign_plateform_edit')->name('assign_plateform_edit');
    Route::get('autocomplete_assign_bike_users', 'Assign\AssginBikeController@autocomplete_assign_bike_users')->name('autocomplete_assign_bike_users');
    Route::get('autocomplete_checkin_bikes', 'Assign\AssginBikeController@autocomplete_checkin_bikes')->name('autocomplete_checkin_bikes');
    Route::get('autocomplete_checkin_bikes_only', 'Assign\AssginBikeController@autocomplete_checkin_bikes_only')->name('autocomplete_checkin_bikes_only');


    Route::resource('assign_bike', 'Assign\AssginBikeController', [
        'names' => [
            'index' => 'assign_bike',
            'create' => 'assign_bike.create',
            'store' => 'assign_bike.store',
            'edit' => 'assign_bike.edit',
            'show' => 'assign_bike.show',
            'update' => 'assign_bike.update',
            'delete' => 'assign_bike.delete'
        ]
    ]);

    Route::get('temp_assign_bike', 'Assign\AssginBikeController@temp_assign_bike');
    Route::get('get_latest_bike_time', 'Assign\AssginBikeController@get_latest_bike_time')->name('get_latest_bike_time');


    Route::post('ajax_get_passports', 'Assign\AssginBikeController@ajax_get_passports')->name('ajax_get_passports');
    Route::post('ajax_get_passports_platform', 'Assign\AssginBikeController@ajax_get_passports_platform')->name('ajax_get_passports_platform');
    Route::post('ajax_get_ppuid_platform', 'Assign\AssginBikeController@ajax_get_ppuid_platform')->name('ajax_get_ppuid_platform');
    Route::post('ajax_get_zds_platform', 'Assign\AssginBikeController@ajax_get_zds_platform')->name('ajax_get_zds_platform');
    Route::post('ajax_get_ppuid', 'Assign\AssginBikeController@ajax_get_ppuid')->name('ajax_get_ppuid');
    Route::post('ajax_get_zds', 'Assign\AssginBikeController@ajax_get_zds')->name('ajax_get_zds');


    Route::post('ajax_get_sim_passports', 'Assign\AssignController@ajax_get_sim_passports')->name('ajax_get_sim_passports');
    Route::post('ajax_get_sim_ppuid', 'Assign\AssignController@ajax_get_sim_ppuid')->name('ajax_get_sim_ppuid');
    Route::post('ajax_get_sim_zds', 'Assign\AssignController@ajax_get_sim_zds')->name('ajax_get_sim_zds');


    Route::post('office_sim_checkin', 'Assign\AssignController@office_sim_checkin')->name('office_sim_checkin');
    Route::get('office_sim_checkout/{id}', 'Assign\AssignController@office_sim_checkout')->name('office_sim_checkout');

    Route::get('office_sim_assign', 'Assign\AssignController@office_sim_assign');

    Route::get('platform_checkout', 'Assign\AssignController@platform_checkout')->name('platform_checkout');
    Route::get('autocomplete_from_checkin_platform', 'Assign\AssginPlateformController@autocomplete_from_checkin_platform')->name('autocomplete_from_checkin_platform');



    Route::resource('assign_plateform', 'Assign\AssginPlateformController', [
        'names' => [
            'index' => 'assign_plateform',
            'create' => 'assign_plateform.create',
            'store' => 'assign_plateform.store',
            'edit' => 'assign_plateform.edit',
            'show' => 'assign_plateform.show',
            'update' => 'assign_plateform.update',
            'delete' => 'assign_plateform.delete'
        ]
    ]);

    Route::resource('view_passport', 'Passport\ViewPassportController', [
        'names' => [
            'index' => 'view_passport',
            'create' => 'view_passport.create',
            'store' => 'view_passport.store',
            'edit' => 'view_passport.edit',
            'show' => 'view_passport.show',
            'update' => 'view_passport.update',
            'delete' => 'view_passport.delete'
        ]
    ]);
    Route::get('rider_no_platform', 'Passport\ViewPassportController@rider_no_platform')->name('rider_no_platform');

    Route::resource('view_passport', 'Passport\ViewPassportController', [
        'names' => [
            'index' => 'view_passport',
            'create' => 'view_passport.create',
            'store' => 'view_passport.store',
            'edit' => 'view_passport.edit',
            'show' => 'view_passport.show',
            'update' => 'view_passport.update',
            'delete' => 'view_passport.delete'
        ]
    ]);

    //cancel passport
    Route::resource('cancel_passport', 'CancelPassport\CancelPassportController', [
        'names' => [
            'index' => 'cancel_passport',
            'create' => 'cancel_passport.create',
            'store' => 'cancel_passport.store',
            'edit' => 'cancel_passport.edit',
            'show' => 'cancel_passport.show',
            'update' => 'cancel_passport.update',
            'delete' => 'cancel_passport.delete'
        ]
    ]);


    //passport edit
    Route::post('ajax_passport_edit', 'Passport\ViewPassportController@ajax_passport_edit')->name('ajax_passport_edit');

    Route::post('edit_get_passport', 'Passport\ViewPassportController@edit_get_passport')->name('edit_get_passport');


    // profile rider

    Route::resource('unique_profile', 'Profile\ProfileController', [
        'names' => [
            'index' => 'unique_profile/{id}',
            'create' => 'unique_profile.create',
            'store' => 'unique_profile.store',
            'edit' => 'unique_profile.edit',
            'show' => 'unique_profile.show',
            'update' => 'unique_profile.update',
            'delete' => 'unique_profile.delete'
        ]
    ]);

    // driving license
    Route::post('ajax_driving_license_detail', 'DrivingLicense\DrivingLicenseController@ajax_driving_license_detail')->name('ajax_driving_license_detail');
    Route::GET('autocomplete_driving_passport_passport', 'DrivingLicense\DrivingLicenseController@autocomplete_driving_passport_passport')->name('autocomplete_driving_passport_passport');

    Route::resource('driving_license', 'DrivingLicense\DrivingLicenseController', [
        'names' => [
            'index' => 'driving_license',
            'create' => 'driving_license.create',
            'store' => 'driving_license.store',
            'edit' => 'driving_license.edit',
            'show' => 'driving_license.show',
            'update' => 'driving_license.update',
            'delete' => 'driving_license.delete'
        ]
    ]);





    //driving license Amount

    Route::post('ajax_driving_license_selection_amount', 'LicenseAmount\LicenseAmountController@ajax_driving_license_selection_amount')->name('ajax_driving_license_selection_amount');

    Route::post('ajax_get_license_amount', 'LicenseAmount\LicenseAmountController@ajax_get_license_amount')->name('ajax_get_license_amount');

    Route::post('ajax_admin_license_amount', 'LicenseAmount\LicenseAmountController@ajax_admin_license_amount')->name('ajax_admin_license_amount');

    Route::resource('driving_license_amount', 'LicenseAmount\LicenseAmountController', [
        'names' => [
            'index' => 'driving_license_amount',
            'create' => 'driving_license_amount.create',
            'store' => 'driving_license_amount.store',
            'edit' => 'driving_license_amount.edit',
            'show' => 'driving_license_amount.show',
            'update' => 'driving_license_amount.update',
            'delete' => 'driving_license_amount.delete'
        ]
    ]);

    // Agreement Amount Fees

    Route::post('ajax_get_edit_detail', 'AgreementAmountFees\AgreementAmountFeesController@ajax_get_edit_detail')->name('ajax_get_edit_detail');

    Route::post('ajax_amounts_agreement', 'AgreementAmountFees\AgreementAmountFeesController@ajax_amounts_agreement')->name('ajax_amounts_agreement');
    Route::post('ajax_amounts_labour_fees', 'AgreementAmountFees\AgreementAmountFeesController@ajax_amounts_labour_fees')->name('ajax_amounts_labour_fees');

    Route::post('ajax_agreement_cancel', 'Agreement\AgreementController@ajax_agreement_cancel')->name('ajax_agreement_cancel');
    Route::post('agreement_cancel_save', 'Agreement\AgreementController@agreement_cancel_save')->name('agreement_cancel_save');


    Route::resource('agreement_amount_fees', 'AgreementAmountFees\AgreementAmountFeesController', [
        'names' => [
            'index' => 'agreement_amount_fees',
            'create' => 'agreement_amount_fees.create',
            'store' => 'agreement_amount_fees.store',
            'edit' => 'agreement_amount_fees.edit',
            'show' => 'agreement_amount_fees.show',
            'update' => 'agreement_amount_fees.update',
            'delete' => 'agreement_amount_fees.delete'
        ]
    ]);




    //passport reports

    Route::resource('passport_report', 'Passport\PassportReportController', [
        'names' => [
            'index' => 'passport_report',
            'create' => 'passport_report.create',
            'store' => 'passport_report.store',
            'edit' => 'passport_report.edit',
            'show' => 'passport_report.show',
            'update' => 'passport_report.update',
            'delete' => 'passport_report.delete'
        ]
    ]);


    //ticket filter

    Route::post('ajax_ticket_filter', 'Ticket\TicketController@ajax_ticket_filter')->name('ajax_ticket_filter');
    Route::post('ajax_ticket_share_filter', 'Ticket\TicketController@ajax_ticket_share_filter')->name('ajax_ticket_share_filter');
    Route::post('approve_ajax_ticket_filter', 'Ticket\TicketController@approve_ajax_ticket_filter')->name('approve_ajax_ticket_filter');

    Route::post('ajax_ticket_filter_share', 'Ticket\TicketController@ajax_ticket_filter_share')->name('ajax_ticket_filter_share');


    Route::group(['prefix' => 'rider'], function()    {
        Route::get('create_ticket','WebRider\WebRiderController@create_ticket')->name('create_ticket');

        Route::post('save_ticket', 'WebRider\WebRiderController@save_ticket')->name('save_ticket');

        Route::get('tickets', 'WebRider\WebRiderController@index')->name('tickets');

        Route::get('ticket_chat/{id}', 'WebRider\WebRiderController@ticket_chat')->name('ticket_chat');
    });


    //IT tickets resources
    Route::resource('it_ticket', 'ItTickets\ItTicketsController', [
        'names' => [
            'index' => 'it_ticket',
            'create' => 'it_ticket.create',
            'store' => 'it_ticket.store',
            'edit' => 'it_ticket.edit',
            'show' => 'it_ticket.show',
            'update' => 'it_ticket.update',
            'delete' => 'it_ticket.delete'
        ]
    ]);


    //Cash Receive
    Route::resource('cash_receive', 'CashReceive\CashReceiveController', [
        'names' => [
            'index' => 'cash_receive',
            'create' => 'cash_receive.create',
            'store' => 'cash_receive.store',
            'edit' => 'cash_receive.edit',
            'show' => 'cash_receive.show',
            'update' => 'cash_receive.update',
            'delete' => 'cash_receive.delete'
        ]
    ]);


    //dashboard2
    Route::get('dashboard2', 'DashboardController@dashboard2');
    Route::get('dashboard-user', 'DashboardController@dashboard3');
    Route::get('dashboard-pro', 'DashboardController@dashboard_pro');
    Route::get('dashboard_test', 'DashboardController@dashboard_test');

    Route::resource('major_department', 'Master\MasterController', [
        'names' => [
            'index' => 'major_department',
            'create' => 'major_department.create',
            'store' => 'major_department.store',
            'edit' => 'major_department.edit',
            'show' => 'major_department.show',
            'update' => 'major_department.update',
            'delete' => 'major_department.delete'
        ]
    ]);
    Route::get('get_network_accounts', 'Master\MasterController@get_network_accounts')->name('get_network_accounts');
    Route::get('sim_master', 'Master\MasterController@sim_master')->name('sim_master');

    Route::post('sim_master_store', 'Master\MasterController@sim_master_store')->name('sim_master_store');
    Route::get('telecome_edit2/{id}', 'Master\MasterController@telecome_edit2')->name('telecome_edit2');

    Route::get('bikes_master', 'Master\MasterController@bikes_master')->name('bikes_master');
    Route::post('bikes_master_store', 'Master\MasterController@bikes_master_store')->name('bikes_master_store');

    Route::get('bikedetail_edit2/{id}', 'Master\MasterController@bikedetail_edit2')->name('bikedetail_edit2');
    Route::put('bikedetail_update/{bikeDetail}', 'Master\MasterController@bikedetail_update')->name('bikedetail_update');
    Route::get('category_checkout/{id}', 'Master\MasterController@category_checkout')->name('category_checkout');


    Route::resource('plateform_notification', 'Notifications\NotificationController', [
        'names' => [
            'index' => 'plateform_notification',
            'create' => 'plateform_notification.create',
            'store' => 'plateform_notification.store',
            'edit' => 'plateform_notification.edit',
            'show' => 'plateform_notification.show',
            'update' => 'plateform_notification.update',
            'delete' => 'plateform_notification.delete'
        ]
    ]);


    Route::resource('labour_upload', 'LabourUploadController', [
        'names' => [
            'index' => 'labour_upload',
            'create' => 'labour_upload.create',
            'store' => 'labour_upload.store',
            'edit' => 'labour_upload.edit',
            'show' => 'labour_upload.show',
            'update' => 'labour_upload.update',
            'delete' => 'labour_upload.delete'
        ]
    ]);

    Route::get('labour_exist', 'LabourUploadController@labour_exist');

    Route::resource('sim_upload', 'SimController', [
        'names' => [
            'index' => 'sim_upload',
            'create' => 'sim_upload.create',
            'store' => 'sim_upload.store',
            'edit' => 'sim_upload.edit',
            'show' => 'sim_upload.show',
            'update' => 'sim_upload.update',
            'delete' => 'sim_upload.delete'
        ]
    ]);

    Route::resource('bike_upload', 'BikeImportsController', [
        'names' => [
            'index' => 'bike_upload',
            'create' => 'bike_upload.create',
            'store' => 'bike_upload.store',
            'edit' => 'bike_upload.edit',
            'show' => 'bike_upload.show',
            'update' => 'bike_upload.update',
            'delete' => 'bike_upload.delete'
        ]
    ]);

    //all masters contollers


//Discount Names
    Route::resource('discount_name', 'DiscountName\DiscountNameController', [
        'names' => [
            'index' => 'discount_name',
            'create' => 'discount_name.create',
            'store' => 'discount_name.store',
            'edit' => 'discount_name.edit',
            'show' => 'discount_name.show',
            'update' => 'discount_name.update',
            'delete' => 'discount_name.delete'
        ]
    ]);

    // Admin Fee Amount
    Route::resource('admin_fee', 'AdminFee\AdminFeeController', [
        'names' => [
            'index' => 'admin_fee',
            'create' => 'admin_fee.create',
            'store' => 'admin_fee.store',
            'edit' => 'admin_fee.edit',
            'show' => 'admin_fee.show',
            'update' => 'admin_fee.update',
            'delete' => 'admin_fee.delete'
        ]
    ]);


    Route::post('admin_fees_ajax','AdminFee\AdminFeeController@admin_fees_ajax')->name('admin_fees_ajax');
//total current used vehicle controller
    Route::resource('vehcile_report', 'Reports\ReportsController', [
        'names' => [
            'index' => 'total_current',
            'create' => 'total_current.create',
            'store' => 'total_current.store',
            'edit' => 'total_current.edit',
            'show' => 'total_current.show',
            'update' => 'total_current.update',
            'delete' => 'total_current.delete'
        ]
    ]);
//sim report

 Route::get('sim_report', 'Reports\ReportsController@sim_report');
 Route::get('assign_report', 'Reports\ReportsController@assign_report')->name('assign_report');
 Route::get('assign_report_attachment', 'Reports\ReportsController@assign_report_attachment')->name('assign_report_attachment');
 Route::get('assign_report_admin', 'Reports\ReportsController@assign_report_admin');
 Route::get('verify_report', 'Reports\ReportsController@verify_report')->name('verify_report');
 Route::post('ajax_get_full_time', 'Reports\ReportsController@ajax_get_full_time')->name('ajax_get_full_time');
 Route::post('ajax_get_part_time', 'Reports\ReportsController@ajax_get_part_time')->name('ajax_get_part_time');
 Route::post('ajax_get_part_time', 'Reports\ReportsController@ajax_get_part_time')->name('ajax_get_part_time');
 Route::post('ajax_company', 'Reports\ReportsController@ajax_company')->name('ajax_company');

    Route::post('assign_report_admin_ajax_employee', 'Reports\ReportsController@assign_report_admin_ajax_employee')->name('assign_report_admin_ajax_employee');
    //nationality masters
    Route::get('nationalities', 'Master\MasterController@nation');
    Route::get('nation_edit/{id}', 'Master\MasterController@nation_edit')->name('nation_edit');
    Route::get('nation_update/{id}', 'Master\MasterController@nation_update')->name('nation_update');
    Route::get('nation_store', 'Master\MasterController@nation_store')->name('nation_store');

    Route::get('category_master', 'Master\MasterController@category_master');
    Route::get('attachment_type', 'Master\MasterController@attachment_type');
    Route::get('category_visa_status', 'Master\MasterController@category_visa_status');
    Route::post('category_visa_store', 'Master\MasterController@category_visa_store')->name('category_visa_store');
    Route::post('category_visa_store', 'Master\MasterController@category_visa_store')->name('category_visa_store');
    Route::post('sub_category_visa_store', 'Master\MasterController@sub_category_visa_store')->name('sub_category_visa_store');

//    category assigns view
    Route::get('category_assign_visa', 'Master\MasterController@category_assign_visa');
    Route::post('visa_category_assign_store', 'Master\MasterController@visa_category_assign_store')->name('visa_category_assign_store');
    Route::get('visa_category_checkout/{id}', 'Master\MasterController@visa_category_checkout')->name('visa_category_checkout');
    Route::post('ajax_render_visa_cat_dropdown', 'Master\MasterController@ajax_render_visa_cat_dropdown')->name('ajax_render_visa_cat_dropdown');


    //working--------assing
    Route::get('category_assign_working', 'Master\MasterController@category_assign_working');
    Route::post('working_category_assign_store', 'Master\MasterController@working_category_assign_store')->name('working_category_assign_store');
    Route::get('working_category_checkout/{id}', 'Master\MasterController@working_category_checkout')->name('working_category_checkout');
    Route::post('ajax_render_working_cat_dropdown', 'Master\MasterController@ajax_render_working_cat_dropdown')->name('ajax_render_working_cat_dropdown');





    Route::get('get_rider_list_for_active_inactive_category', 'Master\MasterController@get_rider_list_for_active_inactive_category')->name('get_rider_list_for_active_inactive_category');
    Route::get('ajax_passport_id_for_active_inactive_category', 'Master\MasterController@ajax_passport_id_for_active_inactive_category')->name('ajax_passport_id_for_active_inactive_category');
    Route::get('ajax_rider_category_active_inactive_history', 'Master\MasterController@ajax_rider_category_active_inactive_history')->name('ajax_rider_category_active_inactive_history');
    Route::get('category_assign_active', 'Master\MasterController@category_assign_active');
    Route::post('active_category_assign_store', 'Master\MasterController@active_category_assign_store')->name('active_category_assign_store');
    Route::get('active_category_checkout/{id}', 'Master\MasterController@active_category_checkout')->name('active_category_checkout');
    Route::post('ajax_render_active_cat_dropdown', 'Master\MasterController@ajax_render_active_cat_dropdown')->name('ajax_render_active_cat_dropdown');

    Route::post('ajax_render_subcategory_active', 'Master\MasterController@ajax_render_subcategory_active')->name('ajax_render_subcategory_active');



    Route::get('active_inactive_category_status', 'Master\MasterController@active_inactive_category_status');
    Route::post('active_main_category_store', 'Master\MasterController@active_main_category_store')->name('active_main_category_store');
    Route::post('active_sub_category_store', 'Master\MasterController@active_sub_category_store')->name('active_sub_category_store');

    Route::get('working_category_status', 'Master\MasterController@working_category_status');
    Route::post('working_category_store', 'Master\MasterController@working_category_store')->name('working_category_store');
    Route::post('working_sub_category_store', 'Master\MasterController@working_sub_category_store')->name('working_sub_category_store');

    Route::post('ajax_render_subcategory_working', 'Master\MasterController@ajax_render_subcategory_working')->name('ajax_render_subcategory_working');
    Route::post('ajax_render_working_dropdown', 'Master\MasterController@ajax_render_working_dropdown')->name('ajax_render_working_dropdown');


    //category assign
    Route::get('category_assign', 'Master\MasterController@category_assign');
    Route::post('category_assign_get_rider_details','Master\MasterController@category_assign_get_rider_details')->name('category_assign_get_rider_details');
    Route::get('autocomplete-fetch-category-assign-passport', 'Master\MasterController@autocomplete_passport')->name('autocomplete-fetch-category-assign-passport');
    Route::post('get_full_passport_detail_for_category_assign','Master\MasterController@get_full_passport_detail_for_category_assign')->name('get_full_passport_detail_for_category_assign');
    Route::post('category_assign_store', 'Master\MasterController@category_assign_store')->name('category_assign_store');
    Route::post('ajax_render_cat_dropdown', 'Master\MasterController@ajax_render_cat_dropdown')->name('ajax_render_cat_dropdown');
    Route::post('ajax_render_subcategory', 'Master\MasterController@ajax_render_subcategory')->name('ajax_render_subcategory');
    Route::post('ajax_render_subcategory_visa', 'Master\MasterController@ajax_render_subcategory_visa')->name('ajax_render_subcategory_visa');

    Route::post('category_store', 'Master\MasterController@category_store')->name('category_store');
    Route::post('sub_category_store', 'Master\MasterController@sub_category_store')->name('sub_category_store');
    //atachment store
    Route::post('attachment_store', 'Master\MasterController@attachment_store')->name('attachment_store');
    Route::get('attachment_edit/{id}', 'Master\MasterController@attachment_edit')->name('attachment_edit');
    Route::get('attachment_update/{id}', 'Master\MasterController@attachment_update')->name('attachment_update');
    //comapanies master
    Route::get('companies', 'Master\MasterController@company');
    Route::get('company_store', 'Master\MasterController@company_store')->name('company_store');
    Route::get('company_edit/{id}', 'Master\MasterController@company_edit')->name('company_edit');
    Route::get('company_update/{id}', 'Master\MasterController@company_update')->name('company_update');


    //category assignes for



    //companies information results
    Route::get('companies_info', 'Master\MasterController@company_info');
    Route::get('company_info_store', 'Master\MasterController@company_info_store')->name('company_info_store');
    Route::get('company_info_edit/{id}', 'Master\MasterController@company_info_edit')->name('company_info_edit');
    Route::get('company_info_update/{id}', 'Master\MasterController@company_info_update')->name('company_info_update');


    // Company master Routes starts
    Route::get('company-master-license-create', 'Master\MasterController@company_license_create')->name('company-master-license-create');
    Route::get('company-master-license-list', 'Master\MasterController@company_license_list')->name('company-master-license-list');
    Route::get('company-master-license/{id}/edit', 'Master\MasterController@company_license_edit')->name('company-master-license-edit');
    Route::get('company-master-license-documents', 'Master\MasterController@company_license_documents')->name('company-master-license-documents');
    Route::post('company_license_info_store', 'Master\MasterController@company_license_info_store')->name('company_license_info_store');
    Route::put('company_license_info_update/{company}', 'Master\MasterController@company_license_info_update')->name('company_license_info_update');

    Route::get('company-master-e-establishment-card','Master\MasterController@e_establishment_card')->name('company-master-e-establishment-card');
    Route::get('company-master-e-establishment-card/{eEstablishment}/edit','Master\MasterController@e_establishment_card_edit')->name('company-master-e-establishment-card-edit');
    Route::get('company-master-e-establishment-card-list','Master\MasterController@e_establishment_card_list')->name('company-master-e-establishment-card-list');
    Route::get('company-master-e-establishment-card-documents','Master\MasterController@e_establishment_card_documents')->name('company-master-e-establishment-card-documents');

    Route::post('company_establishment_card_store', 'Master\MasterController@company_establishment_card_store')->name('company_establishment_card_store');
    Route::put('company_establishment_card_update/{eEstablishment}', 'Master\MasterController@company_establishment_card_update')->name('company_establishment_card_update');

    Route::post('company_labour_card_store', 'Master\MasterController@company_labour_card_store')->name('company_labour_card_store');
    Route::get('company-master-labour-card-card/{labourCard}/edit','Master\MasterController@company_labour_card__edit')->name('company-master-labour-card-card-edit');
    Route::put('company-master-labour-card-update/{labourCard}', 'Master\MasterController@company_labour_card_update')->name('company_labour_card_update');

    Route::get('company-master-traffic-create', 'Master\MasterController@company_master_traffic_create')->name('company_master_traffic_create');
    Route::get('get_ajax_traffic_for_data','Master\MasterController@get_ajax_traffic_for_data')->name('get_ajax_traffic_for_data');
    Route::get('get_ajax_salik_for_data','Master\MasterController@get_ajax_salik_for_data')->name('get_ajax_salik_for_data');

    Route::get('company-master-traffic/{traffic}/edit', 'Master\MasterController@company_master_traffic_edit')->name('company_master_traffic_edit');
    Route::get('company-master-traffic-list', 'Master\MasterController@company_master_traffic_list')->name('company_master_traffic_list');
    Route::get('company-master-traffic-documents', 'Master\MasterController@company_master_traffic_documents')->name('company_master_traffic_documents');
    Route::any('company-master-traffic-store', 'Master\MasterController@company_master_traffic_store')->name('company_master_traffic_store');
    Route::put('company-master-traffic-update/{traffic}', 'Master\MasterController@company_master_traffic_update')->name('company_master_traffic_update');

    Route::get('company-master-salik/{salik}/edit', 'Master\MasterController@company_master_salik_edit')->name('company_master_salik_edit');
    Route::any('company_master_salik_store', 'Master\MasterController@company_master_salik_store')->name('company_master_salik_store');
    Route::put('company_master_salik_update/{salik}', 'Master\MasterController@company_master_salik_update')->name('company_master_salik_update');

    Route::get('company-master-utilities', 'Master\MasterController@company_master_utilities')->name('company-master-utilities');
    Route::get('company-master-utilities-list', 'Master\MasterController@company_master_utilities_list')->name('company-master-utilities-list');
    Route::get('company-master-utilities-documents', 'Master\MasterController@company_master_utilities_documents')->name('company-master-utilities-documents');

    Route::post('company_master_utilities_water_electiricity_store', 'Master\MasterController@company_master_utilities_water_electiricity_store')->name('company_master_utilities_water_electiricity_store');
    Route::get('company_master_utilities_water_electiricity/{electricity}/edit', 'Master\MasterController@company_master_utilities_water_electiricity_edit')->name('company_master_utilities_water_electiricity_edit');
    Route::put('company_master_utilities_water_electiricity_update/{electricity}', 'Master\MasterController@company_master_utilities_water_electiricity_update')->name('company_master_utilities_water_electiricity_update');

    Route::post('company_master_utilities_etisalat_store', 'Master\MasterController@company_master_utilities_etisalat_store')->name('company_master_utilities_etisalat_store');
    Route::get('company_master_utilities_etisalat/{etisalat}/edit', 'Master\MasterController@company_master_utilities_etisalat_edit')->name('company_master_utilities_etisalat_edit');
    Route::put('company_master_utilities_etisalat_update/{etisalat}', 'Master\MasterController@company_master_utilities_etisalat_update')->name('company_master_utilities_etisalat_update');

    Route::post('company_master_utilities_dus_store', 'Master\MasterController@company_master_utilities_dus_store')->name('company_master_utilities_dus_store');
    Route::get('company_master_utilities_dus/{du}/edit', 'Master\MasterController@company_master_utilities_dus_edit')->name('company_master_utilities_dus_edit');
    Route::put('company_master_utilities_dus_update/{du}', 'Master\MasterController@company_master_utilities_dus_update')->name('company_master_utilities_dus_update');


    Route::get('company-master-ejari', 'Master\MasterController@company_master_ejari_create')->name('company-master-ejari');
    Route::get('company-master-ejari-list', 'Master\MasterController@company_master_ejari_list')->name('company-master-ejari-list');
    Route::get('company-master-ejari-documents', 'Master\MasterController@company_master_ejari_documents')->name('company-master-ejari-documents');
    Route::post('company-master-ejari-store', 'Master\MasterController@company_master_ejari_store')->name('company-master-ejari-store');

    Route::get('company-master-ejari/{ejari}/edit', 'Master\MasterController@company_master_ejari_edit')->name('company_master_ejari_edit');
    Route::put('company-master-ejari-update/{ejari}', 'Master\MasterController@company_master_ejari_update')->name('company_master_ejari_update');
    Route::get('company-master-ejari-pdc-payments', 'Master\MasterController@pdc_payments')->name('ajax-get-pdc-payments');

    Route::get('company-master-moa', 'Master\MasterController@company_master_moa_create')->name('company-master-moa');
    Route::get('company-master-moa-list', 'Master\MasterController@company_master_moa_list')->name('company-master-moa-list');
    Route::get('company-master-moa-documents', 'Master\MasterController@company_master_moa_documents')->name('company-master-moa-documents');
    Route::post('company-master-moa-store', 'Master\MasterController@company_master_moa_store')->name('company-master-moa-store');

    Route::get('company-master-moa/{moa}/edit', 'Master\MasterController@company_master_moa_edit')->name('company-master-moa-edit');
    Route::put('company-master-moa-update/{moa}', 'Master\MasterController@company_master_moa_update')->name('company-master-moa-update');

    Route::get('company-master-expiry-reports', 'Master\MasterController@company_master_expiry_reports')->name('company-master-expiry-reports');
    Route::put('company-master-expiry-reports-update', 'Master\MasterController@company_master_expiry_reports_update')->name('company-master-expiry-reports-update');

    // Company master Routes ends

    // Vehicle Master Routes Starts

    Route::get('vehicle-dashboard', 'DashboardController@vehicle_wise_dashboard')->name('vehicle_wise_dashboard');
    Route::get('status_wise_vehicle_report', 'Master\Vehicle\VehicleMasterContorller@status_wise_vehicle_report')->name('status_wise_vehicle_report');
    Route::get('vehicle_life_cycle','Master\Vehicle\VehicleMasterContorller@vehicle_life_cycle')->name('vehicle_life_cycle');
    Route::resource('vehicle_master', 'Master\Vehicle\VehicleMasterContorller');

    Route::resource('vehicle_model', 'Master\Vehicle\VehicleModelController');
    Route::resource('vehicle_tracking_inventory', 'Master\Vehicle\VehicleTrackingInventoryController');
    Route::get('dc_request_for_tracker', 'Master\Vehicle\VehicleTrackingInventoryController@dc_request_for_tracker')->name('dc_request_for_tracker');
    Route::get('rta_request_for_tracker', 'Master\Vehicle\VehicleTrackingInventoryController@rta_request_for_tracker')->name('rta_request_for_tracker');
    Route::get('tracker_requests', 'Master\Vehicle\VehicleTrackingInventoryController@tracker_requests')->name('tracker_requests');
    Route::post('save_dc_request_tracker','Master\Vehicle\VehicleTrackingInventoryController@save_dc_request_tracker')->name('save_dc_request_tracker');
    Route::post('save_rta_request_tracker','Master\Vehicle\VehicleTrackingInventoryController@save_rta_request_tracker')->name('save_rta_request_tracker');
    Route::get('tracker_upload','Master\Vehicle\VehicleTrackingInventoryController@tracker_upload')->name('tracker_upload');
    Route::post('save_upload_tracker','Master\Vehicle\VehicleTrackingInventoryController@save_upload_tracker')->name('save_upload_tracker');

    Route::resource('vehicle_plate_code', 'Master\Vehicle\VehiclePlateCodeController');
    Route::resource('vehicle_insurance', 'Master\Vehicle\VehicleInsuranceController');

    Route::post('insurance_network_type_save', 'Master\Vehicle\VehicleInsuranceController@insurance_network_type_save')->name('insurance_network_type_save');
    Route::post('get_nested_network_data', 'Master\Vehicle\VehicleInsuranceController@get_nested_network_data')->name('get_nested_network_data');

    Route::resource('vehicle_mortgage', 'Master\Vehicle\VehicleMortgageController');
    Route::resource('vehicle_salik_tag', 'Master\Vehicle\VehicleSalikTagController');
    Route::resource('vehicle_category', 'Master\Vehicle\VehicleCategoryController');
    Route::get('get_ajax_vehicle_upload_history', 'Master\Vehicle\VehicleBulkUploadHistoryController@get_ajax_vehicle_upload_history')->name('get_ajax_vehicle_upload_history');
    Route::resource('vehicle_upload_history', 'Master\Vehicle\VehicleBulkUploadHistoryController');
    Route::resource('vehicle_sub_category', 'Master\Vehicle\VehicleSubCategoryController');
    Route::resource('attachmentLabel', 'Master\Vehicle\AttachmentLabelController');
    Route::resource('vehicle_make', 'Master\Vehicle\VehicleMakeController');
    Route::resource('vehicle_year', 'Master\Vehicle\VehicleYearController');

    Route::resource('vehicle_plate_replace', 'Master\Vehicle\VehiclePlateReplaceController');
    Route::get('vehicle-cancellation','Master\Vehicle\VehicleOperationController@vehicle_cancel_form')->name('vehicle_cancel_create');
    Route::post('vehicle-cancellation','Master\Vehicle\VehicleOperationController@vehicle_cancel_store')->name('vehicle_cancel_store');

    Route::get('vehicle-working-status','Master\Vehicle\VehicleOperationController@vehicle_working_status_form')->name('vehicle_working_status_form');
    Route::get('ajax_get_vehicle_sub_categories', 'Master\Vehicle\VehicleOperationController@ajax_get_vehicle_sub_categories')->name('ajax_get_vehicle_sub_categories');
    Route::post('vehicle-working-status','Master\Vehicle\VehicleOperationController@vehicle_working_status_store')->name('vehicle_working_status_store');

    Route::get('ajax_get_filtered_bikes', 'Master\Vehicle\VehicleOperationController@ajax_get_filtered_bikes')->name('ajax_get_filtered_bikes');
    Route::put('vehicle_working_status_bulk_update','Master\Vehicle\VehicleOperationController@vehicle_working_status_bulk_update')->name('vehicle_working_status_bulk_update');

    Route::post('vehicle_plate_replace_reject_request/{reject_request}', 'Master\Vehicle\VehiclePlateReplaceController@reject_request')->name('vehicle_plate_replace_reject_request');
    Route::post('vehicle_plate_replace_approve_request', 'Master\Vehicle\VehiclePlateReplaceController@approve_request')->name('vehicle_plate_replace_approve_request');
    Route::get('vehicle_plate_replace_documents','Master\Vehicle\VehiclePlateReplaceController@vehicle_plate_replace_documents' )->name('vehicle_plate_replace_documents');
    Route::get('get_bike_detail_for_cancellation_with_bike_id','Master\Vehicle\VehiclePlateReplaceController@get_bike_detail_for_cancellation_with_bike_id' )->name('get_bike_detail_for_cancellation_with_bike_id');
    Route::get('get_bike_detail_with_bike_id','Master\Vehicle\VehiclePlateReplaceController@get_bike_detail_with_bike_id' )->name('get_bike_detail_with_bike_id');
    Route::get('get_plate_no_replace_info','Master\Vehicle\VehiclePlateReplaceController@get_plate_no_replace_info' )->name('get_plate_no_replace_info');

    Route::get('bikes_master_documents', 'Master\MasterController@bikes_master_documents')->name('bikes_master_documents');

    Route::get('vehicle_master_list', 'Master\MasterController@vehicle_master_list')->name('vehicle_master_list');
    Route::get('vehicle_master_create', 'Master\MasterController@vehicle_master_create')->name('vehicle_master_create');
    Route::post('vehicle_master_store', 'Master\MasterController@vehicle_master_store')->name('vehicle_master_store');
    Route::get('get_vehicle_sub_category_list','Master\MasterController@get_vehicle_sub_category_list')->name('get_vehicle_sub_category_list');
    Route::get('vehicle_master_edit', 'Master\MasterController@vehicle_master_edit')->name('vehicle_master_edit');
    Route::put('vehicle_master_update', 'Master\MasterController@vehicle_master_update')->name('vehicle_master_update');

    Route::get('vehicle_report', 'Master\MasterController@vehicle_report')->name('vehicle_report');

    // Vehicle Master Routes Ends

    // DC Wise Dashboard Module starts
        Route::get('dc-wise-dashboard', 'DashboardController@dc_wise_dashboard')->name('dc_wise_dashboard');
    // DC Wise Dashboard  Module ends

    // DC manager Dashboard Module starts
        Route::get('dc_manager_dashboard_new', 'DashboardController@dc_manager_dashboard_new')->name('dc_manager_dashboard_new');
    // DC manager Dashboard  Module ends

    // Customer | Supplier ReportsOR Vendor Module starts
    Route::get('customer-supplier-dashboard', 'DashboardController@customer_supplier_wise_dashboard')->name('customer_supplier_wise_dashboard');
    Route::resource('customer_suppliers', 'Master\CustomerSupplier\CustomerSupplierController');
    Route::get('get_company_info','Master\CustomerSupplier\CustomerSupplierController@get_company_info')->name('get_company_info');
    Route::get('get_customer_supplier_sub_category','Master\CustomerSupplier\CustomerSupplierController@get_customer_supplier_sub_category')->name('get_customer_supplier_sub_category');

    Route::resource('customer_supplier_categories', 'Master\CustomerSupplier\CustomerSupplierCategoryController');
    Route::resource('customer_supplier_sub_categories', 'Master\CustomerSupplier\CustomerSupplierSubCategoryController');


    // Customer | Supplier ReportsOR Vendor Module Ends

    // Vehicle Master Routes Starts

    Route::get('sim-dashboard', 'DashboardController@sim_wise_dashboard')->name('sim_wise_dashboard');
    Route::resource('sim_package', 'Master\Sim\SimPackageController');
    Route::get('sim_replace_history', 'Master\Sim\SimCardReplaceController@sim_replace_history')->name('sim_replace_history');
    Route::resource('sim_card_replace', 'Master\Sim\SimCardReplaceController');

    // Vehicle Master Routes Starts
    //WPS Routes
    Route::get('wps-company-listed', 'Wps\WpsDashboardController@company_listed')->name('wps-company-listed');
    Route::get('wps-employee-details', 'Wps\WpsDashboardController@employee_details')->name('wps-employee-details');
    Route::get('wps-get-employee-details', 'Wps\WpsDashboardController@get_employee_details')->name('wps-get-employee-details');
    Route::get('wps-pay-master', 'Wps\WpsDashboardController@wps_pay_master')->name('wps-pay-master');
    Route::post('wps-pay-master', 'Wps\WpsDashboardController@store_wps_pay_master')->name('store-wps-pay-master');
    Route::get('wps-ajax-employee-list', 'Wps\WpsDashboardController@wps_ajax_employee_list')->name('wps-ajax-employee-list');
    Route::get('autocomplete-fetch-wps-passport', 'Wps\WpsDashboardController@autocomplete_passport')->name('autocomplete-fetch-wps-passport');
    Route::get('wps-employee-payment-details', 'Wps\WpsDashboardController@employee_payment_details')->name('wps-employee-payment-details');
    Route::post('wps-details-import', 'Wps\WpsDashboardController@wps_details_import')->name('wps-details-import');
    Route::get('wps-individual-details', 'Wps\WpsDashboardController@wps_individual_details')->name('wps-individual-details');
    Route::post('wps-data-export', 'Wps\WpsDashboardController@wps_data_export')->name('wps-data-export');
    Route::get('wps-employee-data-list', 'Wps\WpsDashboardController@wps_employee_data_list')->name('wps-employee-data-list');
    Route::get('wps-individual-details-edit/{id}', 'Wps\WpsDashboardController@wps_individual_details_edit')->name('wps-individual-details-edit');
    Route::put('wps-individual-details-update/{id}', 'Wps\WpsDashboardController@wps_individual_details_update')->name('wps-individual-details-update');
    Route::post('s3-demo', 'Wps\WpsDashboardController@s3_demo')->name('s3-demo');
    Route::get('s3-demo', 'Wps\WpsDashboardController@get_s3_demo')->name('get-s3-demo');


    //Organized Category
    Route::get('create-vehicle-category', 'OrganizeCategory\OrganizeCategoryController@create_vehicle_category')->name('create-vehicle-category');
    Route::get('create-supplier-category', 'OrganizeCategory\OrganizeCategoryController@create_supplier_category')->name('create-supplier-category');


//designation master
    Route::get('designation', 'Master\MasterController@designation')->name('designation');
    Route::put('designation_status_update','Master\MasterController@designation_status_update')->name('designation_status_update');
    Route::post('designation_store', 'Master\MasterController@designation_store')->name('designation_store');
    Route::get('designation_edit/{id}', 'Master\MasterController@designation_edit')->name('designation_edit');
    Route::put('designation_update/{id}', 'Master\MasterController@designation_update')->name('designation_update');

  //career document name
    Route::resource('career_document_name', 'Master\Career\CareerDoucmentController');

    //career document name
    Route::resource('career_heard_about_us', 'Master\Career\CareerHeardAboutUsController');


    Route::get('it_ticket_start/{id}', 'ItTickets\ItTicketsController@it_ticket_start')->name('it_ticket_start');
    Route::get('it_ticket_not_doing/{id}', 'ItTickets\ItTicketsController@it_ticket_not_doing')->name('it_ticket_not_doing');
    Route::get('it_tickete_complete/{id}', 'ItTickets\ItTicketsController@it_tickete_complete')->name('it_tickete_complete');
    Route::get('it_ticket_new/{id}', 'ItTickets\ItTicketsController@it_ticket_new')->name('it_ticket_new');


    Route::post('get_plateform_detail', 'Notifications\NotificationController@get_plateform_detail')->name('get_plateform_detail');
    Route::post('labour_card_type', 'VisaProcess\VisaStepsController@labour_card_type')->name('labour_card_type');
    Route::post('get_employee_detail', 'DashboardController@get_employee_detail')->name('get_employee_detail');
    Route::post('get_employees', 'DashboardController@get_employees')->name('get_employees');
    Route::post('get_employee_company', 'DashboardController@get_employee_company')->name('get_employee_company');
    Route::resource('expiry', 'Master\ExpiryController', [
        'names' => [
            'index' => 'expiry',
            'create' => 'expiry.create',
            'store' => 'expiry.store',
            'edit' => 'expiry.edit',
            'show' => 'expiry.show',
            'update' => 'expiry.update',
            'delete' => 'expiry.delete'
        ]
    ]);
    Route::resource('visa_cancel', 'VisaProcess\VisaCancallationController', [
        'names' => [
            'index' => 'visa_cancel',
            'create' => 'visa_cancel.create',
            'store' => 'visa_cancel.store',
            'edit' => 'visa_cancel.edit',
            'show' => 'visa_cancel.show',
            'update' => 'visa_cancel.update',
            'delete' => 'visa_cancel.delete'
        ]
    ]);
    Route::get('cancal_approve', 'VisaProcess\VisaCancallationController@cancal_approve');
    Route::get('cancal_approve_update/{id}', 'VisaProcess\VisaCancallationController@cancal_approve_update')->name('cancal_approve_update');
    Route::post('clear_dep_visa', 'VisaProcess\VisaCancallationController@clear_dep_visa')->name('clear_dep_visa');
    Route::post('clear_pro_visa', 'VisaProcess\VisaCancallationController@clear_pro_visa')->name('clear_pro_visa');
    Route::get('view_clear_requests', 'VisaProcess\VisaCancallationController@view_clear_requests');
    Route::get('view_clear', 'VisaProcess\VisaCancallationController@view_clear');
    Route::get('view_clearance_report', 'VisaProcess\VisaCancallationController@view_clearance_report');
    Route::get('cancal_show', 'VisaProcess\VisaCancallationController@cancal_show');
    Route::post('clear_dep_visa_req', 'VisaProcess\VisaCancallationController@clear_dep_visa_req')->name('clear_dep_visa_req');
    Route::get('autocomplete_cancel', 'VisaProcess\VisaCancallationController@autocomplete_cancel')->name('autocomplete_cancel');

    //pro visa cancellation sheet upload
    Route::post('/visa_cancel_sheet', 'VisaProcess\VisaCancallationController@visa_cancel_sheet')->name('visa_cancel_sheet');

    Route::post('visa_chat', 'VisaProcess\VisaCancallationController@visa_chat')->name('visa_chat');
    Route::post('getMessageData', 'VisaProcess\VisaCancallationController@getMessageData')->name('getMessageData');


    //new visa cancellation steps routes are here
    Route::get('completed_visa_process', 'VisaProcess\VisaCancallationController@completed_visa_process');

    Route::get('cancel_visa', 'VisaProcess\VisaCancallationController@cancel_visa');



    Route::post('cancel_visa_process_names', 'VisaProcess\VisaCancallationController@cancel_visa_process_names')->name('cancel_visa_process_names');
    Route::get('start_cancel_visa/{id}', 'VisaProcess\VisaCancallationController@start_cancel_visa')->name('start_cancel_visa');
    Route::post('cancel_visa_contract_typing', 'VisaProcess\VisaCancallationController@cancel_visa_contract_typing')->name('cancel_visa_contract_typing');
    Route::post('renewcancel_typing_save', 'VisaProcess\VisaCancallationController@renewcancel_typing_save')->name('renewcancel_typing_save');

    Route::post('renewcancel_sub_save', 'VisaProcess\VisaCancallationController@renewcancel_sub_save')->name('renewcancel_sub_save');

    Route::post('cancel_visa_contract_sub', 'VisaProcess\VisaCancallationController@cancel_visa_contract_sub')->name('cancel_visa_contract_sub');

    Route::post('cancel_visa_contract', 'VisaProcess\VisaCancallationController@cancel_visa_contract')->name('cancel_visa_contract');
    Route::post('renewcancel_cancel_save', 'VisaProcess\VisaCancallationController@renewcancel_cancel_save')->name('renewcancel_cancel_save');


    Route::post('cancel_visa_approval', 'VisaProcess\VisaCancallationController@cancel_visa_approval')->name('cancel_visa_approval');
    Route::post('cancel_visa_approcal_save', 'VisaProcess\VisaCancallationController@cancel_visa_approcal_save')->name('cancel_visa_approcal_save');


    Route::post('cancel_visa_decline', 'VisaProcess\VisaCancallationController@cancel_visa_decline')->name('cancel_visa_decline');
    Route::post('cancel_visa_decline_save', 'VisaProcess\VisaCancallationController@cancel_visa_decline_save')->name('cancel_visa_decline_save');


    Route::post('cancel_between', 'VisaProcess\VisaCancallationController@cancel_between')->name('cancel_between');
    Route::post('between_cancel_save', 'VisaProcess\VisaCancallationController@between_cancel_save')->name('between_cancel_save');
    Route::get('all_cancelled_visa', 'VisaProcess\VisaCancallationController@all_cancelled_visa');
    Route::post('visa_cancel_complete', 'VisaProcess\VisaCancallationController@visa_cancel_complete')->name('visa_cancel_complete');
    Route::post('visa_cancel_submission', 'VisaProcess\VisaCancallationController@visa_cancel_submission')->name('visa_cancel_submission');
    Route::post('visa_cancel_cancellation_report', 'VisaProcess\VisaCancallationController@visa_cancel_cancellation_report')->name('visa_cancel_cancellation_report');
    Route::post('visa_cancel_approval', 'VisaProcess\VisaCancallationController@visa_cancel_approval')->name('visa_cancel_approval');
    Route::post('visa_cancel_decline', 'VisaProcess\VisaCancallationController@visa_cancel_decline')->name('visa_cancel_decline');
    Route::get('visa_cancel_request', 'VisaProcess\VisaCancallationController@visa_cancel_request');


    Route::get('visa_cancel_request_hr', 'VisaProcess\VisaCancallationController@visa_cancel_request_hr');
    Route::post('cancel_visa_request_get_info', 'VisaProcess\VisaCancallationController@cancel_visa_request_get_info')->name('cancel_visa_request_get_info');



    Route::post('cancel_request_save', 'VisaProcess\VisaCancallationController@cancel_request_save')->name('cancel_request_save');


    Route::get('all_cancel_requests', 'VisaProcess\VisaCancallationController@all_cancel_requests');
    Route::get('cancel_request_revoke/{id}', 'VisaProcess\VisaCancallationController@cancel_request_revoke')->name('cancel_request_revoke');
    Route::get('cancel_request_accept/{id}', 'VisaProcess\VisaCancallationController@cancel_request_accept')->name('cancel_request_accept');
    Route::get('autocomplete_cancels', 'VisaProcess\VisaCancallationController@autocomplete_cancels')->name('autocomplete_cancels');
    Route::get('all_cancel_requests_to_dc', 'VisaProcess\VisaCancallationController@all_cancel_requests_to_dc');
    Route::get('autocomplete_cancels_hr', 'VisaProcess\VisaCancallationController@autocomplete_cancels_hr')->name('autocomplete_cancels_hr');
    Route::get('all_cancel_requests_to_pro', 'VisaProcess\VisaCancallationController@all_cancel_requests_to_pro');
    Route::post('hr_to_pro', 'VisaProcess\VisaCancallationController@hr_to_pro')->name('hr_to_pro');
    Route::get('autocomplete_replace_hr', 'VisaProcess\VisaCancallationController@autocomplete_replace_hr')->name('autocomplete_replace_hr');
    //labour card
    Route::GET('labour_card_upload', 'VisaProcess\VisaStepsController@labour_card_upload');



    Route::post('labour_card_upload_store', 'VisaProcess\VisaStepsController@labour_card_upload_store')->name('labour_card_upload_store');

    //repleacement visa routes

        Route::post('replacement_visa_request_get_info', 'VisaProcess\VisaCancallationController@replacement_visa_request_get_info')->name('replacement_visa_request_get_info');
        Route::get('visa_replacement_request', 'VisaProcess\VisaCancallationController@visa_replacement_request');
        Route::get('visa_replacement_request_hr', 'VisaProcess\VisaCancallationController@visa_replacement_request_hr');
        Route::get('visa_replacement_request_pro', 'VisaProcess\VisaCancallationController@visa_replacement_request_pro');
        Route::get('replacement_visa_requests', 'VisaProcess\VisaCancallationController@replacement_visa_requests');
        Route::post('hr_to_pro_replacement', 'VisaProcess\VisaCancallationController@hr_to_pro_replacement')->name('hr_to_pro_replacement');
        Route::get('replacement_request_accept/{id}', 'VisaProcess\VisaCancallationController@replacement_request_accept')->name('replacement_request_accept');
        Route::post('accpeted_replacement_requests', 'VisaProcess\VisaCancallationController@accpeted_replacement_requests')->name('accpeted_replacement_requests');
        Route::post('pro_replacement_requests', 'VisaProcess\VisaCancallationController@pro_replacement_requests')->name('pro_replacement_requests');
        Route::post('repacement_request_save', 'VisaProcess\VisaCancallationController@repacement_request_save')->name('repacement_request_save');
        Route::get('replacement_history', 'VisaProcess\VisaStepsController@replacement_history');
        //status change
    Route::get('autocomplete_fetch_complete_passport', 'EmiratesIdCard\EmiratesIdCardController@autocomplete_passport')->name('autocomplete_fetch_complete_passport');
    Route::resource('emirates_id_card', 'EmiratesIdCard\EmiratesIdCardController', [
        'names' => [
            'index' => 'emirates_id_card',
            'create' => 'emirates_id_card.create',
            'store' => 'emirates_id_card.store',
            'edit' => 'emirates_id_card.edit',
            'show' => 'emirates_id_card.show',
            'update' => 'emirates_id_card.update',
            'delete' => 'emirates_id_card.delete'
        ]
    ]);
    //renew emirates id
    Route::get('renew_emirates_id', 'EmiratesIdCard\EmiratesIdCardController@renew_emirates_id');

    Route::post('eid_get_unique_passport', 'EmiratesIdCard\EmiratesIdCardController@eid_get_unique_passport')->name('eid_get_unique_passport');
    Route::post('renew_store', 'EmiratesIdCard\EmiratesIdCardController@renew_store')->name('renew_store');
    Route::post('emirates_id_history', 'EmiratesIdCard\EmiratesIdCardController@emirates_id_history')->name('emirates_id_history');



    Route::resource('bike_tracking', 'BikesTracking\BikesTrackingController', [
        'names' => [
            'index' => 'bike_tracking',
            'create' => 'bike_tracking.create',
            'store' => 'bike_tracking.store',
            'edit' => 'bike_tracking.edit',
            'show' => 'bike_tracking.show',
            'update' => 'bike_tracking.update',
            'delete' => 'bike_tracking.delete'
        ]
    ]);
    Route::get('bike_tracking_history', 'BikesTracking\BikesTrackingController@bike_tracking_history')->name('bike_tracking_history');
    Route::get('ajax_get_bike_tracker_history', 'BikesTracking\BikesTrackingController@ajax_get_bike_tracker_history')->name('ajax_get_bike_tracker_history');

    Route::resource('performance', 'Performance\PerformanceController', [
        'names' => [
            'index' => 'performance',
            'create' => 'performance.create',
            'store' => 'performance.store',
            'edit' => 'performance.edit',
            'show' => 'performance.show',
            'update' => 'performance.update',
            'delete' => 'performance.delete'
        ]
    ]);
    Route::post('/performance_upload', 'Performance\UploadPerformanceController@import')->name('performance_upload');
    Route::get('performance_setting', 'Performance\PerformanceController@performance_setting')->name('performance_setting');
    Route::get('view_performance', 'Performance\PerformanceController@view_performance');
    Route::post('performance_setting_edit', 'Performance\PerformanceController@performance_setting_edit')->name('performance_setting_edit');
    Route::post('deliveroo_settings_store', 'Performance\PerformanceController@deliveroo_settings_store')->name('deliveroo_settings_store');
    Route::get('deliveroo_setting_update/{id}', 'Performance\PerformanceController@deliveroo_setting_update')->name('deliveroo_setting_update');
    Route::post('show_deliveroo_performance/{id}', 'Performance\PerformanceController@show_deliveroo_performance')->name('show_deliveroo_performance');
    Route::post('show_deliveroo_performance/{id}', 'Performance\PerformanceController@show_deliveroo_performance')->name('show_deliveroo_performance');
    Route::get('two_weeks', 'Performance\PerformanceController@two_weeks')->name('two_weeks');
    Route::get('all_rating', 'Performance\PerformanceController@all_rating')->name('all_rating');



    //ar balance
    Route::resource('ar_balance', 'ArBalance\ArBalanceController', [
        'names' => [
            'index' => 'ar_balance',
            'create' => 'ar_balance.create',
            'store' => 'ar_balance.store',
            'edit' => 'ar_balance.edit',
            'show' => 'ar_balance.show',
            'update' => 'ar_balance.update',
            'delete' => 'ar_balance.delete'
        ]
    ]);

    Route::post('/ar_balance_upload', 'ArBalance\ArBalanceController@import')->name('ar_balance_upload');
    Route::post('/ar_balance_sheet_upload', 'ArBalance\ArBalanceController@import2')->name('ar_balance_sheet_upload');
    Route::post('/ar_balance_sheet_upload2', 'ArBalance\ArBalanceController@import3')->name('ar_balance_sheet_upload2');
    Route::post('/ar_balance_add_balance', 'ArBalance\ArBalanceController@ar_balance_add_balance')->name('ar_balance_add_balance');
    Route::post('/ar_balance_sub_balance', 'ArBalance\ArBalanceController@ar_balance_sub_balance')->name('ar_balance_add_balance');
    Route::get('ar_balance_sheet', 'ArBalance\ArBalanceController@ar_balance_sheet');
    Route::post('ar_balance_sheet_name', 'ArBalance\ArBalanceController@ar_balance_sheet_name')->name('ar_balance_sheet_name');
    Route::post('ar_balance_sheet_detail', 'ArBalance\ArBalanceController@ar_balance_sheet_detail')->name('ar_balance_sheet_detail');
    Route::get('ar_balance_report', 'ArBalance\ArBalanceController@ar_balance_report');
    Route::post('ajax_ar_balance_edit', 'ArBalance\ArBalanceController@ajax_ar_balance_edit')->name('ajax_ar_balance_edit');
    Route::post('ar_balance_sheet_edit', 'ArBalance\ArBalanceController@ar_balance_sheet_edit')->name('ar_balance_sheet_edit');
    Route::post('/ar_balance_edit_add_balance', 'ArBalance\ArBalanceController@ar_balance_edit_add_balance')->name('ar_balance_edit_add_balance');

    Route::post('ar_balance_between_search', 'ArBalance\ArBalanceController@ar_balance_between_search')->name('ar_balance_between_search');
    Route::post('ar_balance_between_user', 'ArBalance\ArBalanceController@ar_balance_between_user')->name('ar_balance_between_user');

    Route::get('ar_balance_first_pdf/{id}', 'ArBalance\ArBalanceController@ar_balance_first_pdf')->name('ar_balance_first_pdf');
    Route::get('ar_balance_second_pdf/{date_from}/{date_to}', 'ArBalance\ArBalanceController@ar_balance_second_pdf')->name('ar_balance_second_pdf');
    Route::get('ar_balance_third_pdf/{date_from}/{date_to}/{zds_code}', 'ArBalance\ArBalanceController@ar_balance_third_pdf')->name('ar_balance_third_pdf');


    Route::post('/ar_balance_sheet_history', 'ArBalance\ArBalanceController@import4')->name('ar_balance_sheet_history');
    Route::get('ar_balance_history', 'ArBalance\ArBalanceController@ar_balance_history');
    Route::post('ar_balance_sheet_detail_history', 'ArBalance\ArBalanceController@ar_balance_sheet_detail_history')->name('ar_balance_sheet_detail_history');
    Route::post('ar_balance_between_search_history', 'ArBalance\ArBalanceController@ar_balance_between_search_history')->name('ar_balance_between_search_history');
    Route::post('ar_balance_between_user_history', 'ArBalance\ArBalanceController@ar_balance_between_user_history')->name('ar_balance_between_user_history');

    Route::get('ar_balance_history_first_pdf/{id}', 'ArBalance\ArBalanceController@ar_balance_history_first_pdf')->name('ar_balance_history_first_pdf');
    Route::get('ar_balance_history_second_pdf/{date_from}/{date_to}', 'ArBalance\ArBalanceController@ar_balance_history_second_pdf')->name('ar_balance_history_second_pdf');

    Route::post('add_assigning_amount', 'ArBalance\ArBalanceController@add_assigning_amount')->name('add_assigning_amount');
    Route::post('get_assign_amount', 'ArBalance\ArBalanceController@get_assign_amount')->name('get_assign_amount');


    Route::post('assigning_detail', 'ArBalance\ArBalanceController@assigning_detail')->name('assigning_detail');



    Route::get('show_visa_expense', 'ArBalance\ArBalanceController@show_visa_expense');
    Route::post('ar_balance_visa_expense', 'ArBalance\ArBalanceController@ar_balance_visa_expense')->name('ar_balance_visa_expense');








    Route::resource('create_interview', 'CreateInterviews\CreateInterviewController');

    Route::post('display_interview_list', 'CreateInterviews\CreateInterviewController@display_interview_list')->name('display_interview_list');
    Route::post('save_interview_list', 'CreateInterviews\CreateInterviewController@save_interview_list')->name('save_interview_list');
    Route::get('sent_interview', 'CreateInterviews\CreateInterviewController@sent_interview')->name('sent_interview');
    Route::get('acknowledge_interview', 'CreateInterviews\CreateInterviewController@acknowledge_interview')->name('acknowledge_interview');
    Route::get('invitation_rejected', 'CreateInterviews\CreateInterviewController@invitation_rejected')->name('invitation_rejected');
    Route::get('pass_candidate', 'CreateInterviews\CreateInterviewController@pass_candidate')->name('pass_candidate');
    Route::get('fail_candidate', 'CreateInterviews\CreateInterviewController@fail_candidate')->name('fail_candidate');
    Route::get('recent_interview', 'CreateInterviews\CreateInterviewController@recent_interview')->name('recent_interview');
    Route::get('batch_report', 'CreateInterviews\CreateInterviewController@batch_report')->name('batch_report');
    Route::get('autocomplete_batch_report', 'CreateInterviews\CreateInterviewController@autocomplete_batch_report')->name('autocomplete_batch_report');
    Route::post('get_autocomplete_batch_report', 'CreateInterviews\CreateInterviewController@get_autocomplete_batch_report')->name('get_autocomplete_batch_report');


    Route::post('ajax_batch_log', 'CreateInterviews\CreateInterviewController@ajax_batch_log')->name('ajax_batch_log');
    Route::post('ajax_interview_user', 'CreateInterviews\CreateInterviewController@ajax_interview_user')->name('ajax_interview_user');
    Route::post('update_interview_status', 'CreateInterviews\CreateInterviewController@update_interview_status')->name('update_interview_status');
    Route::post('save_batch', 'CreateInterviews\CreateInterviewController@save_batch')->name('save_batch');
    Route::get('ajax_generate_reference_number', 'CreateInterviews\CreateInterviewController@ajax_generate_reference_number')->name('ajax_generate_reference_number');
    Route::post('get_city_wise_batch_interview', 'CreateInterviews\CreateInterviewController@get_city_wise_batch_interview')->name('get_city_wise_batch_interview');





    Route::resource('reserve_bike', 'ReserveBike\ReserveBikeController', [
        'names' => [
            'index' => 'reserve_bike',
            'create' => 'reserve_bike.create',
            'store' => 'reserve_bike.store',
            'edit' => 'reserve_bike.edit',
            'show' => 'reserve_bike.show',
            'update' => 'reserve_bike.update',
            'delete' => 'reserve_bike .delete'
        ]
    ]);

    Route::post('check_bike_reserve_ajax', 'ReserveBike\ReserveBikeController@check_bike_reserve_ajax')->name('check_bike_reserve_ajax');
    Route::post('check_sim_reserve_ajax', 'ReserveBike\ReserveBikeController@check_sim_reserve_ajax')->name('check_sim_reserve_ajax');

    Route::get('rider_life_cycle','Profile\ProfileShowController@rider_life_cycle')->name('rider_life_cycle');
    Route::resource('profile', 'Profile\ProfileShowController');

    Route::post('profile_show', 'Profile\ProfileShowController@profile_show')->name('profile_show');
    Route::post('get_profile_detail', 'Profile\ProfileShowController@get_profile_detail')->name('get_profile_detail');
    Route::post('ajax_performance_info', 'Profile\ProfileShowController@ajax_performance_info')->name('ajax_performance_info');
    Route::post('full_cod_history', 'Profile\ProfileShowController@full_cod_history')->name('full_cod_history');
    Route::post('profile_bike_checkout', 'Profile\ProfileShowController@profile_bike_checkout')->name('profile_bike_checkout');
    Route::post('profile_sim_checkout', 'Profile\ProfileShowController@profile_sim_checkout')->name('profile_sim_checkout');
    Route::post('profile_bike_assign', 'Profile\ProfileShowController@profile_bike_assign')->name('profile_bike_assign');
    Route::post('profile_sim_assign', 'Profile\ProfileShowController@profile_sim_assign')->name('profile_sim_assign');
    Route::post('profile_plateform_assign', 'Profile\ProfileShowController@profile_plateform_assign')->name('profile_plateform_assign');
    Route::post('profile_plat_checkout', 'Profile\ProfileShowController@profile_plat_checkout')->name('profile_plat_checkout');
    Route::post('bike_handling', 'Profile\ProfileShowController@bike_handling')->name('bike_handling');
    Route::post('bike_handling_new', 'Profile\ProfileShowController@bike_handling_new')->name('bike_handling_new');
    Route::get('bike_handle_pdf/{id}', 'Profile\ProfileShowController@bike_handle_pdf')->name('bike_handle_pdf');
    Route::post('upload_bike_handle', 'Profile\ProfileShowController@upload_bike_handle');
    Route::get('/dynamic_pdf/pdf', 'Profile\ProfileShowController@pdf');

    //profile autocomplete
    Route::get('autocomplete', 'Profile\ProfileShowController@autocomplete')->name('autocomplete');
    Route::get('profile_test', 'Profile\ProfileShowController@profile_test');

    Route::get('autocomplete_eid_handover', 'Profile\ProfileShowController@autocomplete_eid_handover')->name('autocomplete_eid_handover');



    Route::post('ajax_ticket_info2', 'Profile\ProfileShowController@ajax_ticket_info2')->name('ajax_ticket_info2');



    Route::resource('admin-dashboard', 'AdminDashboard\AdminDashboardController', [
        'names' => [
            'index' => 'admin-dashboard',
            'create' => 'admin-dashboard.create',
            'store' => 'admin-dashboard.store',
            'edit' => 'admin-dashboard.edit',
            'show' => 'admin-dashboard.show',
            'update' => 'admin-dashboard.update',
            'delete' => 'admin-dashboard.delete'
        ]
    ]);


    //fine uploads controller route
    Route::resource('fine_uploads','FineUpload\FineUploadController',[
        'names' => [
            'index' => 'fine_uploads',
            'create' => 'fine_uploads.create',
            'store' => 'fine_uploads.store',
            'edit' => 'fine_uploads.edit',
            'show' => 'fine_uploads.show',
            'update' => 'fine_uploads.update',
            'delete' => 'fine_uploads.delete',
        ]
    ]);

    Route::post('ajax_view_fine_offense', 'FineUpload\FineUploadController@ajax_view_fine_offense')->name('ajax_view_fine_offense');
    Route::post('ajax_get_rider_filter_counts', 'FineUpload\FineUploadController@ajax_get_rider_filter_counts')->name('ajax_get_rider_filter_counts');
    Route::get('rider_fines', 'FineUpload\FineUploadController@rider_fines')->name('rider_fines');

    //fine uploads controller route
    Route::resource('salik_uploads','VehicleSalik\VehicleSalikController',[
        'names' => [
            'index' => 'salik_uploads',
            'create' => 'salik_uploads.create',
            'store' => 'salik_uploads.store',
            'edit' => 'salik_uploads.edit',
            'show' => 'salik_uploads.show',
            'update' => 'salik_uploads.update',
            'delete' => 'salik_uploads.delete',
        ]
    ]);

    Route::post('salik_render_calender', 'VehicleSalik\VehicleSalikController@salik_render_calender')->name('salik_render_calender');
    Route::post('delete_salik', 'VehicleSalik\VehicleSalikController@delete_salik')->name('delete_salik');
    Route::post('update_duplicate_salik', 'VehicleSalik\VehicleSalikController@update_duplicate_salik')->name('update_duplicate_salik');
    Route::post('ajax_company_name', 'VehicleSalik\VehicleSalikController@ajax_company_name')->name('ajax_company_name');
    Route::get('salik_data/{type}/{id}', 'VehicleSalik\VehicleSalikController@salik_data')->name('salik_data');
    Route::post('salikget_salik_total_amount_ajax', 'VehicleSalik\VehicleSalikController@salikget_salik_total_amount_ajax')->name('salikget_salik_total_amount_ajax');



    //sim bill upload
    Route::resource('sim_bill_upload', 'SimBillUpload\SimBillUploadController', [
        'names' => [
            'index' => 'sim_bill_upload',
            'create' => 'sim_bill_upload.create',
            'store' => 'sim_bill_upload.store',
            'edit' => 'sim_bill_upload.edit',
            'show' => 'sim_bill_upload.show',
            'update' => 'sim_bill_upload.update',
            'delete' => 'sim_bill_upload.delete'
        ]
    ]);



    //Rider Order Controller Routes
    Route::resource('rider_orders','RiderOrderDetail\RiderOrderDetailControler',[
        'names' => [
            'index' => 'rider_orders',
            'create' => 'rider_orders.create',
            'store' => 'rider_orders.store',
            'edit' => 'rider_orders.edit',
            'show' => 'rider_orders.show',
            'update' => 'rider_orders.update',
            'delete' => 'rider_orders.delete',
        ]
    ]);

    Route::post('rider_data_count_ajax', 'RiderOrderDetail\RiderOrderDetailControler@rider_data_count_ajax')->name('rider_data_count_ajax');
    Route::get('add_order_rates', 'RiderOrderDetail\RiderOrderDetailControler@add_order_rates')->name('add_order_rates');
    Route::post('save_order_rates', 'RiderOrderDetail\RiderOrderDetailControler@save_order_rates')->name('save_order_rates');
    Route::get('order_rate_edit/{id}', 'RiderOrderDetail\RiderOrderDetailControler@order_rate_edit')->name('order_rate_edit');
    Route::post('order_rate_update/{id}', 'RiderOrderDetail\RiderOrderDetailControler@order_rate_update')->name('order_rate_update');

    Route::get('add_order', 'RiderOrderDetail\RiderOrderDetailControler@add_order')->name('add_order');
    Route::post('save_rider_order', 'RiderOrderDetail\RiderOrderDetailControler@save_rider_order')->name('save_rider_order');
    Route::get('missing_order_rider', 'RiderOrderDetail\RiderOrderDetailControler@missing_order_rider')->name('missing_order_rider');

//attendance
    Route::post('update_to_present', 'Attendance\AttendanceController@update_to_present')->name('update_to_present');
    Route::resource('rider_attendance', 'Attendance\AttendanceController', [
        'names' => [
            'index' => 'rider_attendance',
            'create' => 'rider_attendance.create',
            'store' => 'rider_attendance.store',
            'edit' => 'rider_attendance.edit',
            'show' => 'rider_attendance.show',
            'update' => 'rider_attendance.update',
            'delete' => 'rider_attendance.delete'
        ]
    ]);
    Route::post('ajax_get_attendance_date', 'Attendance\AttendanceController@ajax_get_attendance_date')->name('ajax_get_attendance_date');
    Route::post('ajax_get_attendance_user', 'Attendance\AttendanceController@ajax_get_attendance_user')->name('ajax_get_attendance_user');
    Route::post('ajax_refresh_show', 'Attendance\AttendanceController@ajax_refresh_show')->name('ajax_refresh_show');
    //dashboard for talabat
    Route::get('dashboard_show', 'AdminDashboard\AdminDashboardController@dashboard_show');
    Route::post('dashboard_show_refresh', 'AdminDashboard\AdminDashboardController@dashboard_show_refresh')->name('dashboard_show_refresh');


    //rider fuel
    Route::resource('rider_fuel', 'FuelRider\FuelRiderController', [
        'names' => [
            'index' => 'rider_fuel',
            'create' => 'rider_fuel.create',
            'store' => 'rider_fuel.store',
            'edit' => 'rider_fuel.edit',
            'show' => 'rider_fuel.show',
            'update' => 'rider_fuel.update',
            'delete' => 'rider_fuel.delete'
        ]
    ]);

    //bike impounding upload
    Route::post('impound-tracking', 'BikeImpoundingUpload\BikeImpoundingUploadController@impound_tracking')->name('impound-tracking');
    Route::get('impounded-bike', 'BikeImpoundingUpload\BikeImpoundingUploadController@impounded_bike')->name('impounded-bike');
    Route::post('fine-or-impound', 'BikeImpoundingUpload\BikeImpoundingUploadController@fine_or_impound')->name('fine-or-impound');
    Route::post('single-bike-impounding', 'BikeImpoundingUpload\BikeImpoundingUploadController@single_bike_impounding')->name('single-bike-impounding');
    Route::resource('bike_impounding', 'BikeImpoundingUpload\BikeImpoundingUploadController', [
        'names' => [
            'index' => 'bike_impounding',
            'create' => 'bike_impounding.create',
            'store' => 'bike_impounding.store',
            'edit' => 'bike_impounding.edit',
            'show' => 'bike_impounding.show',
            'update' => 'bike_impounding.update',
            'delete' => 'bike_impounding.delete'
        ]
    ]);

    Route::post('bike_impounding_total_amount_ajax', 'BikeImpoundingUpload\BikeImpoundingUploadController@bike_impounding_total_amount_ajax')->name('bike_impounding_total_amount_ajax');



    Route::resource('sim_shortage_setting', 'SimShortageSetting\SimShortageSettingController', [
        'names' => [
            'index' => 'sim_shortage_setting',
            'create' => 'sim_shortage_setting.create',
            'store' => 'sim_shortage_setting.store',
            'edit' => 'sim_shortage_setting.edit',
            'show' => 'sim_shortage_setting.show',
            'update' => 'sim_shortage_setting.update',
            'delete' => 'sim_shorta ge_setting.delete'
        ]
    ]);

    //bike assign by platform
    Route::resource('bike_assign_platform', 'BikeAssignPlatform\BikeAssignPlatformController', [
        'names' => [
            'index' => 'bike_assign_platform',
            'create' => 'bike_assign_platform.create',
            'store' => 'bike_assign_platform.store',
            'edit' => 'bike_assign_platform.edit',
            'show' => 'bike_assign_platform.show',
            'update' => 'bike_assign_platform.update',
            'delete' => 'bike_assign_platform.delete'
        ]
    ]);
    Route::post('ajax_get_bikes_checkin_by_platform', 'BikeAssignPlatform\BikeAssignPlatformController@ajax_get_bikes_checkin_by_platform')->name('ajax_get_bikes_checkin_by_platform');
    //bike replacement
    Route::resource('bike_replacement', 'BikeReplacement\BikeReplacementController', [
        'names' => [
            'index' => 'bike_replacement',
            'create' => 'bike_replacement.create',
            'store' => 'bike_replacement.store',
            'edit' => 'bike_replacement.edit',
            'show' => 'bike_replacement.show',
            'update' => 'bike_replacement.update',
            'delete' => 'bike_replacement.delete'
        ]
    ]);


    //LPO
    Route::get('lpo-process', 'Lpo\LpoProcessController@lpo_process')->name('lpo-process');
    Route::post('ajax-lpo-process', 'Lpo\LpoProcessController@ajax_lpo_process')->name('ajax-lpo-process');
    Route::post('ajax-lpo-vcc-attachment', 'Lpo\LpoProcessController@ajax_lpo_vcc_attachment')->name('ajax-lpo-vcc-attachment');
    Route::post('ajax-lpo-add-insurance', 'Lpo\LpoProcessController@ajax_lpo_add_insurance')->name('ajax-lpo-add-insurance');
    Route::post('ajax-lpo-add-no-plate', 'Lpo\LpoProcessController@ajax_lpo_add_no_plate')->name('ajax-lpo-add-no-plate');
    Route::post('ajax-salik-tags', 'Lpo\LpoProcessController@ajax_salik_tags')->name('ajax-salik-tags');
    Route::post('ajax-bike-ready', 'Lpo\LpoProcessController@ajax_bike_ready')->name('ajax-bike-ready');
    Route::get('get-lpo-process-details', 'Lpo\LpoProcessController@get_lpo_process_details')->name('get-lpo-process-details');
    Route::get('fetch-lpo-chassis', 'Lpo\LpoProcessController@fetch_lpo_chassis')->name('fetch-lpo-chassis');
    Route::get('lpo-vehicle-info', 'Lpo\LpoProcessController@lpo_vehicle_info')->name('lpo-vehicle-info');

    Route::get('create-lpo-contract', 'Lpo\LpoController@create_lpo_contract')->name('create-lpo-contract');
    Route::post('store-lpo-contract', 'Lpo\LpoController@store_lpo_contract')->name('store-lpo-contract');
    Route::get('report-lpo-contract', 'Lpo\LpoController@report_lpo_contract')->name('report-lpo-contract');

    Route::get('create-master-lpo', 'Lpo\LpoController@create_master_lpo')->name('create-master-lpo');
    Route::post('store-master-lpo', 'Lpo\LpoController@store_master_lpo')->name('store-master-lpo');
    Route::get('report-master-lpo', 'Lpo\LpoController@report_master_lpo')->name('report-master-lpo');

    Route::get('create-lpo-invoice', 'Lpo\LpoController@create_lpo_invoice')->name('create-lpo-invoice');
    Route::post('lpo-filter-invoice-lpo-no', 'Lpo\LpoController@lpo_filter_invoice_lpo_no')->name('lpo-filter-invoice-lpo-no');
    Route::post('store-lpo-invoice', 'Lpo\LpoController@store_lpo_invoice')->name('store-lpo-invoice');

    Route::get('ajax-lpo-inventory-details', 'Lpo\LpoController@ajax_lpo_inventory_details')->name('ajax-lpo-inventory-details');
    Route::get('create-company-lpo', 'Lpo\LpoController@create_company_lpo')->name('create-company-lpo');

    Route::get('create-emi', 'Lpo\LpoController@create_emi')->name('create-emi');
    Route::post('store-emi', 'Lpo\LpoController@store_emi')->name('store-emi');
    Route::post('ajax-filter-lpo-emi', 'Lpo\LpoController@ajax_filter_lpo_emi')->name('ajax-filter-lpo-emi');
    Route::post('ajax-fetch-lpo-cheque', 'Lpo\LpoController@ajax_fetch_lpo_cheque')->name('ajax-fetch-lpo-cheque');
    // Route::post('ajax-filter-lpo-cheque', 'Lpo\LpoController@ajax_filter_lpo_cheque')->name('ajax-filter-lpo-cheque');

    Route::get('accounts-dashboard', 'Lpo\AccountsDashboardController@accounts_dashboard')->name('accounts-dashboard');
    Route::get('insurance-claim-report', 'Lpo\AccountsDashboardController@insurance_claim_report')->name('insurance-claim-report');
    Route::get('bike-impound-report', 'Lpo\AccountsDashboardController@bike_impound_report')->name('bike-impound-report');

    Route::post('ajax-filter-lpo-vehicle-info', 'Lpo\LpoController@ajax_filter_lpo_vehicle_info')->name('ajax-filter-lpo-vehicle-info');

    Route::get('create-cheque', 'Lpo\LpoController@create_cheque')->name('create-cheque');
    Route::post('store-cheque', 'Lpo\LpoController@store_cheque')->name('store-cheque');
    Route::get('report-cheque', 'Lpo\LpoController@report_cheque')->name('report-cheque');

    Route::get('create-salik-tags', 'Lpo\LpoController@create_salik_tags')->name('create-salik-tags');
    Route::post('store-salik-tags', 'Lpo\LpoController@store_salik_tags')->name('store-salik-tags');
    Route::post('upload-salik-tags', 'Lpo\LpoController@upload_salik_tags')->name('upload-salik-tags');
    Route::get('report-salik-tags', 'Lpo\LpoController@report_salik_tags')->name('report-salik-tags');

    Route::get('create-lpo-vehicle', 'Lpo\LpoController@create_lpo_vehicle')->name('create-lpo-vehicle');
    Route::post('store-lpo-vehicle', 'Lpo\LpoController@store_lpo_vehicle')->name('store-lpo-vehicle');
    Route::post('ajax-store-lpo-vehicle', 'Lpo\LpoProcessController@ajax_store_lpo_vehicle')->name('ajax-store-lpo-vehicle');

    Route::get('vehicle-receive', 'Lpo\LpoController@vehicle_receive')->name('vehicle-receive');
    Route::get('lpo-filter-vehicle-receive', 'Lpo\LpoController@lpo_filter_vehicle_receive')->name('lpo-filter-vehicle-receive');
    Route::get('lpo-filter-spare-receive', 'Lpo\LpoController@lpo_filter_spare_receive')->name('lpo-filter-spare-receive');
    Route::post('lpo-vehicle-received', 'Lpo\LpoController@lpo_vehicle_received')->name('lpo-vehicle-received');
    Route::post('lpo-spare-received', 'Lpo\LpoController@lpo_spare_received')->name('lpo-spare-received');

    Route::get('report-lpo-received-vehicle', 'Lpo\LpoController@report_lpo_received_vehicle')->name('report-lpo-received-vehicle');
    Route::get('report-lpo-dashboard', 'Lpo\LpoController@report_lpo_dashboard')->name('report-lpo-dashboard');
    Route::post('lpo-ajax-dashboard-report', 'Lpo\LpoController@lpo_ajax_dashboard_report')->name('lpo-ajax-dashboard-report');
    Route::get('report-lpo-spare-receive', 'Lpo\LpoController@report_lpo_spare_receive')->name('report-lpo-spare-receive');
    Route::get('report-lpo-filter-vehicle-receive', 'Lpo\LpoController@report_lpo_filter_vehicle_receive')->name('report-lpo-filter-vehicle-receive');
    Route::get('create-vcc-attachment', 'Lpo\LpoController@create_vcc_attachment')->name('create-vcc-attachment');
    Route::post('lpo-vcc-attachment', 'Lpo\LpoController@lpo_vcc_attachment')->name('lpo-vcc-attachment');
    Route::post('lpo-add-insurance', 'Lpo\LpoController@lpo_add_insurance')->name('lpo-add-insurance');
    Route::post('lpo-add-no-plate', 'Lpo\LpoController@lpo_add_no_plate')->name('lpo-add-no-plate');

    Route::get('lpo-filter-vcc-vehicle', 'Lpo\LpoController@lpo_filter_vcc_vehicle')->name('lpo-filter-vcc-vehicle');
    Route::get('vehicle-assignment-company', 'Lpo\LpoController@vehicle_assignment_company')->name('vehicle-assignment-company');
    Route::get('vehicle-assignment-insurance', 'Lpo\LpoController@vehicle_assignment_insurance')->name('vehicle-assignment-insurance');
    Route::get('plate-registration', 'Lpo\LpoController@plate_registration')->name('plate-registration');

    Route::get('bike-missing-request', 'Lpo\BikeMissingController@bike_missing_request')->name('bike-missing-request');
    Route::get('dc-bike-missing-request', 'Lpo\BikeMissingController@dc_bike_missing_request')->name('dc-bike-missing-request');
    Route::post('store-bike-missing', 'Lpo\BikeMissingController@store_bike_missing')->name('store-bike-missing');

    Route::get('checkout-missing-bike', 'Lpo\BikeMissingController@checkout_missing_bike')->name('checkout-missing-bike');
    Route::post('store-checkout-missing-bike', 'Lpo\BikeMissingController@store_checkout_missing_bike')->name('store-checkout-missing-bike');
    Route::post('store-police-complaint', 'Lpo\BikeMissingController@store_police_complaint')->name('store-police-complaint');
    Route::post('store-police-report', 'Lpo\BikeMissingController@store_police_report')->name('store-police-report');
    Route::post('store-found-remarks', 'Lpo\BikeMissingController@store_found_remarks')->name('store-found-remarks');
    Route::post('store-insurance-claim', 'Lpo\BikeMissingController@store_insurance_claim')->name('store-insurance-claim');
    Route::post('store-payment-receive', 'Lpo\BikeMissingController@store_payment_receive')->name('store-payment-receive');
    Route::post('store-vehicle-cancellation', 'Lpo\BikeMissingController@store_vehicle_cancellation')->name('store-vehicle-cancellation');
    Route::get('get-missing-process-details', 'Lpo\BikeMissingController@get_missing_process_details')->name('get-missing-process-details');
    Route::get('get-missing-bike-details', 'Lpo\BikeMissingController@get_missing_bike_details')->name('get-missing-bike-details');

    Route::get('missing-bike-process', 'Lpo\BikeMissingController@missing_bike_process')->name('missing-bike-process');

    Route::get('bike-process-single', 'Lpo\BikeMissingController@bike_process_single')->name('bike-process-single');
    Route::post('ajax-missing-process', 'Lpo\BikeMissingController@ajax_missing_process')->name('ajax-missing-process');
    Route::get('station-autocomplete', 'Lpo\BikeMissingController@station_autocomplete')->name('station-autocomplete');


    Route::get('autocomplete_checkin_bikes_for_replace', 'BikeReplacement\BikeReplacementController@autocomplete_checkin_bikes_for_replace')->name('autocomplete_checkin_bikes_for_replace');
    Route::get('autocomplete_bikes_need_replace_checkout', 'BikeReplacement\BikeReplacementController@autocomplete_bikes_need_replace_checkout')->name('autocomplete_bikes_need_replace_checkout');
    //sim replacement
    Route::resource('sim_replacement', 'SimReplacement\SimReplacementController', [
        'names' => [
            'index' => 'sim_replacement',
            'create' => 'sim_replacement.create',
            'store' => 'sim_replacement.store',
            'edit' => 'sim_replacement.edit',
            'show' => 'sim_replacement.show',
            'update' => 'sim_replacement.update',
            'delete' => 'sim_replacement.delete'
        ]
    ]);

    Route::resource('visa_application', 'VisaApplication\VisaApplicationController', [
        'names' => [
            'index' => 'visa_application',
            'create' => 'visa_application.create',
            'store' => 'visa_application.store',
            'edit' => 'visa_application.edit',
            'show' => 'visa_application.show',
            'update' => 'visa_application.update',
            'delete' => 'visa_application.delete'
        ]
    ]);
    Route::post('ajax_get_visa_app_att', 'VisaApplication\VisaApplicationController@ajax_get_visa_app_att')->name('ajax_get_visa_app_att');

    Route::get('autocomplete_checkin_sim_for_replace', 'SimReplacement\SimReplacementController@autocomplete_checkin_sim_for_replace')->name('autocomplete_checkin_sim_for_replace');
    Route::get('autocomplete_checkin_sim_for_replace', 'SimReplacement\SimReplacementController@autocomplete_checkin_sim_for_replace')->name('autocomplete_checkin_sim_for_replace');
    Route::get('autocomplete_sim_need_replace_checkout', 'SimReplacement\SimReplacementController@autocomplete_sim_need_replace_checkout')->name('autocomplete_sim_need_replace_checkout');
    Route::post('ajax_get_visa_app', 'VisaApplication\VisaApplicationController@ajax_get_visa_app')->name('ajax_get_visa_app');
    //rider report controller
    Route::post('search_report_rider', 'RiderReport\RiderReportController@search_report_rider')->name('search_report_rider');
    Route::get('temporary_bike_to_collect', 'RiderReport\RiderReportController@temporary_bike_to_collect')->name('temporary_bike_to_collect');
    Route::get('temporary_sim_to_collect', 'RiderReport\RiderReportController@temporary_sim_to_collect')->name('temporary_sim_to_collect');
    Route::get('temporary_bike_to_collect_history', 'RiderReport\RiderReportController@temporary_bike_to_collect_history_gamer')->name('temporary_bike_to_collect_history');
    Route::get('ajax_view_remarks_bike_replacement', 'RiderReport\RiderReportController@ajax_view_remarks_bike_replacement')->name('ajax_view_remarks_bike_replacement');


    Route::resource('rider_report', 'RiderReport\RiderReportController', [
        'names' => [
            'index' => 'rider_report',
            'create' => 'rider_report.create',
            'store' => 'rider_report.store',
            'edit' => 'rider_report.edit',
            'show' => 'rider_report.show',
            'update' => 'rider_report.update',
            'delete' => 'rider_report.delete'
        ]
    ]);


//    career by office
    Route::resource('career_by_office','Career\CareerByOfficeController',[
        'names' => [
            'index' => 'career_by_office',
            'create' => 'career_by_office.create',
            'store' => 'career_by_office.store',
            'edit' => 'career_by_office.edit',
            'show' => 'career_by_office.show',
            'update' => 'career_by_office.update',
            'delete' => 'career_by_office.delete',
        ]
    ]);

    Route::get('search_passport_json', 'Career\CareerByOfficeController@search_passport_json')->name('search_passport_json');
    Route::get('search_city_json', 'Career\CareerByOfficeController@search_city_json')->name('search_city_json');

    Route::get('get_rider_fuel_list','FuelRider\FuelRiderController@get_rider_fuel_list')->name('get_rider_fuel_list');
    Route::get('autocomplete_career','Career\CareerByOfficeController@autocomplete_career')->name('autocomplete_career');
    Route::get('only_passport_suggest','Career\CareerByOfficeController@only_passport_suggest')->name('only_passport_suggest');
    Route::get('ajax_check_the_passport_info','Career\CareerByOfficeController@ajax_check_the_passport_info')->name('ajax_check_the_passport_info');



    Route::post('ajax_filter_color_by_office', 'Career\CareerByOfficeController@ajax_filter_color')->name('ajax_filter_color_by_office');
    Route::post('get_ajax_filter_color_block_count_by_office', 'Career\CareerByOfficeController@get_ajax_filter_color_block_count')->name('get_ajax_filter_color_block_count_by_office');


    //follow up routes

    Route::resource('follow_up','Followup\FollowupController',[
        'names' => [
            'index' => 'follow_up',
            'create' => 'follow_up.create',
            'store' => 'follow_up.store',
            'edit' => 'follow_up.edit',
            'show' => 'follow_up.show',
            'update' => 'follow_up.update',
            'delete' => 'follow_up.delete',
        ]
    ]);
    Route::get('follow_up_dashboard', 'Followup\FollowupController@follow_up_dashboard')->name('follow_up_dashboard');
    Route::post('ajax_filter_report_follow_up', 'Followup\FollowupController@ajax_filter_report_follow_up')->name('ajax_filter_report_follow_up');
    Route::post('get_color_block_count_ajax', 'Followup\FollowupController@get_color_block_count_ajax')->name('get_color_block_count_ajax');
    Route::post('get_career_history', 'Followup\FollowupController@get_career_history')->name('get_career_history');
    Route::get('follow_up_candidate', 'Followup\FollowupController@follow_up_candidate')->name('follow_up_candidate');

    Route::post('get_color_block_count_ajax_candidate', 'Followup\FollowupController@get_color_block_count_ajax_candidate')->name('get_color_block_count_ajax_candidate');
    Route::post('ajax_filter_report_follow_up_candidate', 'Followup\FollowupController@ajax_filter_report_follow_up_candidate')->name('ajax_filter_report_follow_up_candidate');

//    own bike_sim routes

    Route::resource('own_sim_bike','OwnSimBike\OwnSimBikeController',[
        'names' => [
            'index' => 'own_sim_bike',
            'create' => 'own_sim_bike.create',
            'store' => 'own_sim_bike.store',
            'edit' => 'own_sim_bike.edit',
            'show' => 'own_sim_bike.show',
            'update' => 'own_sim_bike.update',
            'delete' => 'own_sim_bike.delete',
        ]
    ]);

    Route::get('user-dashboard','DashboardController@userDashboard')->name('userDashboard');

    Route::resource('assign_to_dc', 'AssignToDc\AssignToDcController', [
        'names' => [
            'index' => 'assign_to_dc',
            'create' => 'assign_to_dc.create',
            'store' => 'assign_to_dc.store',
            'edit' => 'assign_to_dc.edit',
            'show' => 'assign_to_dc.show',
            'update' => 'assign_to_dc.update',
            'delete' => 'assign_to_dc.delete'
        ]

    ]);

    Route::post('get_passport_checkin_platform','AssignToDc\AssignToDcController@get_passport_checkin_platform')->name('get_passport_checkin_platform');
    Route::post('display_rider_list','AssignToDc\AssignToDcController@display_rider_list')->name('display_rider_list');
    Route::post('display_rider_list_by_user_platform','AssignToDc\AssignToDcController@display_rider_list_by_user_platform')->name('display_rider_list_by_user_platform');
    Route::post('dc_transfer_save','AssignToDc\AssignToDcController@dc_transfer_save')->name('dc_transfer_save');

    Route::get('dc_rirder_by_platform/{id}/{platform}','AssignToDc\AssignToDcController@dc_rirder_by_platform')->name('dc_rirder_by_platform');
    Route::get('get_remain_platform_counts','AssignToDc\AssignToDcController@get_remain_platform_counts')->name('get_remain_platform_counts');
    Route::get('get_remain_dc_counts','AssignToDc\AssignToDcController@get_remain_dc_counts')->name('get_remain_dc_counts');
    Route::get('dc_transfer_rider','AssignToDc\AssignToDcController@dc_transfer_rider')->name('dc_transfer_rider');
    Route::get('get_dc_by_platforms','AssignToDc\AssignToDcController@get_dc_by_platforms')->name('get_dc_by_platforms');

    Route::get('dc_dashboard/{id?}','AssignToDc\AssignToDcController@dc_dashboard')->name('dc_dashboard');
    Route::get('dc_leaderboard','AssignToDc\AssignToDcController@dc_leaderboard')->name('dc_leaderboard');
    Route::get('dc_master_dashboard/','AssignToDc\AssignToDcController@dc_master_dashboard')->name('dc_master_dashboard');
    Route::get('get_dc_item_menu','AssignToDc\AssignToDcController@get_dc_item_menu')->name('get_dc_item_menu');
    Route::get('rider_master_list/{type}/{id}/{platform?}','AssignToDc\AssignToDcController@rider_master_list')->name('rider_master_list');
    Route::get('check_dc_riders_attendance_rider','AssignToDc\AssignToDcController@check_dc_riders_attendance_rider')->name('check_dc_riders_attendance_rider');
    Route::get('dc_riders','AssignToDc\AssignToDcController@dc_riders')->name('dc_riders');
    Route::get('rider_not_implement_attendance','AssignToDc\AssignToDcController@rider_not_implement_attendance')->name('rider_not_implement_attendance');
    Route::get('rider_not_implement_orders/{id?}','AssignToDc\AssignToDcController@rider_not_implement_orders')->name('rider_not_implement_orders');

    Route::get('dc_manager_dashboard','AssignToDc\AssignToDcController@dc_manager_dashboard')->name('dc_manager_dashboard');
    Route::get('get_dc_item_menu_of_manager','AssignToDc\AssignToDcController@get_dc_item_menu_of_manager')->name('get_dc_item_menu_of_manager');

    Route::get('get_manger_dc_user_button','AssignToDc\AssignToDcController@get_manger_dc_user_button')->name('get_manger_dc_user_button');
    Route::get('assign_dc_rider_download/{id}','AssignToDc\AssignToDcController@assign_dc_rider_download')->name('assign_dc_rider_download');
    Route::get('dc_rider_filter_ajax','AssignToDc\AssignToDcController@dc_rider_filter_ajax')->name('dc_rider_filter_ajax');

    Route::resource('manager_user', 'Manager_user\Manage_UserController', [
        'names' => [
            'index' => 'manager_user',
            'create' => 'manager_user.create',
            'store' => 'manager_user.store',
            'edit' => 'manager_user.edit',
            'show' => 'manager_user.show',
            'update' => 'manager_user.update',
            'delete' => 'manager_user.delete'
        ]
    ]);
    Route::get('ajax_user_member','Manager_user\Manage_UserController@ajax_user_member')->name('ajax_user_member');

    //ppuid cancel
    Route::resource('ppuid_cancel', 'PpuidCancel\PpuidCancelController', [
        'names' => [
            'index' => 'ppuid_cancel',
            'create' => 'ppuid_cancel.create',
            'store' => 'ppuid_cancel.store',
            'edit' => 'ppuid_cancel.edit',
            'show' => 'ppuid_cancel.show',
            'update' => 'ppuid_cancel.update',
            'delete' => 'ppuid_cancel.delete'
        ]
    ]);

    Route::post('ppuid_show', 'PpuidCancel\PpuidCancelController@ppuid_show')->name('ppuid_show');
    Route::get('ajax_append_subcategory_cancel', 'PpuidCancel\PpuidCancelController@ajax_append_subcategory_cancel')->name('ajax_append_subcategory_cancel');
    Route::get('cancel_activate_agreed_amount', 'PpuidCancel\PpuidCancelController@cancel_activate_agreed_amount')->name('cancel_activate_agreed_amount');


    Route::post('ppuid_cancel_status', 'PpuidCancel\PpuidCancelController@ppuid_cancel_status')->name('ppuid_cancel_status');
    Route::post('ppuid_activate', 'PpuidCancel\PpuidCancelController@ppuid_activate')->name('ppuid_activate');

    Route::get('ppuid_cancel_report', 'PpuidCancel\PpuidCancelController@ppuid_cancel_report');
    Route::get('ppuid_cancel_history', 'PpuidCancel\PpuidCancelController@ppuid_cancel_history');

    Route::resource('contractor_report','Reports\ContractorReport\ContractorReportController',[
        'names' => [
            'index' => 'contractor_report',
            'create' => 'contractor_report.create',
            'store' => 'contractor_report.store',
            'edit' => 'contractor_report.edit',
            'show' => 'contractor_report.show',
            'update' => 'contractor_report.update',
            'delete' => 'contractor_report.delete',
        ]
    ]);
    Route::post('contract_report_show', 'Reports\ContractorReport\ContractorReportController@contract_report_show')->name('contract_report_show');
    Route::get('contractor_all', 'Reports\ContractorReport\ContractorReportController@contractor_all');

    Route::get('contractor_bike_report', 'Reports\ContractorReport\ContractorReportController@contractor_bike_reporter');
    Route::get('contractor_sim_report', 'Reports\ContractorReport\ContractorReportController@contractor_sim_reporter');
    Route::post('contractor_bike_report_show', 'Reports\ContractorReport\ContractorReportController@contractor_bike_report_show')->name('contractor_bike_report_show');
    Route::post('contractor_sim_report_show', 'Reports\ContractorReport\ContractorReportController@contractor_sim_report_show')->name('contractor_sim_report_show');

    Route::get('contractor_salik', 'Reports\ContractorReport\ContractorReportController@contractor_salik');
    Route::post('salikget_salik_total_amount_ajax_4pl', 'Reports\ContractorReport\ContractorReportController@salikget_salik_total_amount_ajax_4pl')->name('salikget_salik_total_amount_ajax_4pl');
    Route::post('get_4pl_salik_detail', 'Reports\ContractorReport\ContractorReportController@get_4pl_salik_detail')->name('get_4pl_salik_detail');

    Route::get('contractor_fine', 'Reports\ContractorReport\ContractorReportController@contractor_fine');
    Route::post('fineget_fine_total_amount_ajax_4pl', 'Reports\ContractorReport\ContractorReportController@fineget_fine_total_amount_ajax_4pl')->name('fineget_fine_total_amount_ajax_4pl');
    Route::post('get_4pl_fine_detail', 'Reports\ContractorReport\ContractorReportController@get_4pl_fine_detail')->name('get_4pl_fine_detail');

    Route::get('contractor_sim', 'Reports\ContractorReport\ContractorReportController@contractor_sim');
    Route::post('simget_sim_total_amount_ajax_4pl', 'Reports\ContractorReport\ContractorReportController@simget_sim_total_amount_ajax_4pl')->name('simget_sim_total_amount_ajax_4pl');
    Route::post('get_4pl_sim_detail', 'Reports\ContractorReport\ContractorReportController@get_4pl_sim_detail')->name('get_4pl_sim_detail');
    Route::get('vendor_dashboard', 'Reports\ContractorReport\ContractorReportController@vendor_dashboard');
    Route::get('get_vendor_attenance','Reports\ContractorReport\ContractorReportController@get_vendor_attenance')->name('get_vendor_attenance');

    Route::get('get_vendor_dc','Reports\ContractorReport\ContractorReportController@get_vendor_dc')->name('get_vendor_dc');

    Route::get('get_vendor_companies','Reports\ContractorReport\ContractorReportController@get_vendor_companies')->name('get_vendor_companies');
    Route::get('get_vendor_bike','Reports\ContractorReport\ContractorReportController@get_vendor_bike')->name('get_vendor_bike');

    Route::get('get_vendor_sim','Reports\ContractorReport\ContractorReportController@get_vendor_sim')->name('get_vendor_sim');

    //visa process report
    Route::resource('visa_process_report','Reports\VisaProcessReport\VisaProcessReportController',[
        'names' => [
            'index' => 'visa_process_report',
            'create' => 'visa_process_report.create',
            'store' => 'visa_process_report.store',
            'edit' => 'visa_process_report.edit',
            'show' => 'visa_process_report.show',
            'update' => 'visa_process_report.update',
            'delete' => 'visa_process_report.delete',
        ]
    ]);

    Route::post('get_nested_info_visa_process_report', 'Reports\VisaProcessReport\VisaProcessReportController@get_nested_info_visa_process_report')->name('get_nested_info_visa_process_report');
    Route::get('visa_process_report_show', 'Reports\VisaProcessReport\VisaProcessReportController@visa_process_report_show')->name('visa_process_report_show');
    Route::post('visa_process_report_visa_status', 'Reports\VisaProcessReport\VisaProcessReportController@visa_process_report_visa_status')->name('visa_process_report_visa_status');
    Route::post('visa_process_report_own_visa_status', 'Reports\VisaProcessReport\VisaProcessReportController@visa_process_report_own_visa_status')->name('visa_process_report_own_visa_status');
    Route::post('visa_process_report_own_without_status', 'Reports\VisaProcessReport\VisaProcessReportController@visa_process_report_own_without_status')->name('visa_process_report_own_without_status');
    Route::get('start_visa/{id}', 'Reports\VisaProcessReport\VisaProcessReportController@start_visa')->name('start_visa');
    Route::get('start_visa2/{id}', 'Reports\VisaProcessReport\VisaProcessReportController@start_visa2')->name('start_visa2');
    Route::get('start_visa3/{id}', 'Reports\VisaProcessReport\VisaProcessReportController@start_visa3')->name('start_visa3');
    Route::get('start_visa4/{id}', 'Reports\VisaProcessReport\VisaProcessReportController@start_visa4')->name('start_visa4');
    Route::get('stop_and_resume_report', 'Reports\VisaProcessReport\VisaProcessReportController@stop_and_resume_report');


    Route::get('visa_process_companies', 'Reports\VisaProcessReport\VisaProcessReportController@visa_process_companies');

    Route::post('visa_company_detail', 'Reports\VisaProcessReport\VisaProcessReportController@visa_company_detail')->name('visa_company_detail');

    Route::post('visa_category_details', 'Reports\VisaProcessReport\VisaProcessReportController@visa_category_details')->name('visa_category_details');

    Route::get('visa_category_details', 'Reports\VisaProcessReport\VisaProcessReportController@visa_category_details');

    Route::post('get_visa_category_details', 'Reports\VisaProcessReport\VisaProcessReportController@get_visa_category_details')->name('get_visa_category_details');



    Route::resource('bulk_assign_to_dc','AssignToDc\BulkAssignToDcController',[
        'names' => [
            'index' => 'bulk_assign_to_dc',
            'create' => 'bulk_assign_to_dc.create',
            'store' => 'bulk_assign_to_dc.store',
            'edit' => 'bulk_assign_to_dc.edit',
            'show' => 'bulk_assign_to_dc.show',
            'update' => 'bulk_assign_to_dc.update',
            'delete' => 'bulk_assign_to_dc.delete',
        ]
    ]);
    //un assigned order
    Route::resource('unassigned_order','RiderOrderDetail\UnassigndOrderController',[
        'names' => [
            'index' => 'unassigned_order',
            'create' => 'unassigned_order.create',
            'store' => 'unassigned_order.store',
            'edit' => 'unassigned_order.edit',
            'show' => 'unassigned_order.show',
            'update' => 'unassigned_order.update',
            'delete' => 'unassigned_order.delete',
        ]
    ]);
    Route::get('unassigned_order_filter_ajax', 'RiderOrderDetail\UnassigndOrderController@unassigned_order_filter_ajax')->name('unassigned_order_filter_ajax');
    Route::get('unassigned_main_digit_ajax', 'RiderOrderDetail\UnassigndOrderController@unassigned_main_digit_ajax')->name('unassigned_main_digit_ajax');
    Route::resource('vendor_portal','VendorRegistration\VendorRegistrationController',[
        'names' => [
            'index' => 'vendor_portal',
            'create' => 'vendor_portal.create',
            'store' => 'vendor_portal.store',
            'edit' => 'vendor_portal.edit',
            'show' => 'vendor_portal.show',
            'update' => 'vendor_portal.update',
            'delete' => 'vendor_portal.delete',
        ]
    ]);
    Route::get('vendor_accept/{id}', 'VendorRegistration\VendorRegistrationController@vender_accept')->name('vender_accept');
    Route::get('vendor_reject', 'VendorRegistration\VendorRegistrationController@vendor_reject')->name('vendor_reject');
    // Route::get('vendor-upload', 'VendorRegistration\VendorRegistrationController@vendor_upload')->name('vendor-upload');
    Route::post('vendor-upload', 'VendorRegistration\VendorRegistrationController@post_vendor_upload')->name('post-vendor-upload');
    Route::get('rider-upload', 'VendorRegistration\VendorRegistrationController@rider_upload')->name('rider-upload');
    Route::post('rider-upload', 'VendorRegistration\VendorRegistrationController@post_rider_upload')->name('post-rider-upload');
    Route::get('cancellation_ppuid_ajax', 'VendorRegistration\VendorRegistrationController@cancellation_ppuid_ajax')->name('cancellation_ppuid_ajax');
    Route::post('vendor_onboard_accept_rejoin', 'VendorRegistration\VendorRegistrationController@vendor_onboard_accept_rejoin')->name('vendor_onboard_accept_rejoin');
    Route::get('vendor-cancel', 'VendorRegistration\VendorRegistrationController@vendor_cancel')->name('vendor-cancel');
    Route::post('post-vendor-cancel', 'VendorRegistration\VendorRegistrationController@post_vendor_cancel')->name('post-vendor-cancel');
    Route::get('ajax-vendor-cancel', 'VendorRegistration\VendorRegistrationController@ajax_vendor_cancel')->name('ajax-vendor-cancel');
    Route::get('ajax-vendor-assigned-count', 'VendorRegistration\VendorRegistrationController@ajax_vendor_assigned_count')->name('ajax-vendor-assigned-count');



    //new career controller routes
    Route::get('only_new_visa_noc','Career\NewCareerController@index')->name('only_new_visa_noc');
    Route::post('ajax_filter_color_after_short_list','Career\NewCareerController@ajax_filter_color_after_short_list')->name('ajax_filter_color_after_short_list');
    Route::post('get_ajax_filter_color_block_count_after_shortlist','Career\NewCareerController@get_ajax_filter_color_block_count_after_shortlist')->name('get_ajax_filter_color_block_count_after_shortlist');
    Route::get('not_new_visa_noc','Career\NewCareerController@not_new_visa_noc')->name('not_new_visa_noc');

    // Fuel Platform Routes stats
    Route::resource('fuel_platform', 'FuelPlatform\FuelPlatformController');
   // Fuel Platform Routes Ends

    //new visa process routes

    Route::get('visa_process', 'VisaProcess\VisaStepsController@visa_process');
    Route::post('get_visa_profile_detail', 'VisaProcess\VisaStepsController@get_visa_profile_detail')->name('get_visa_profile_detail');
    Route::get('visa_process_amount', 'VisaProcess\VisaStepsController@visa_process_amount');
    Route::post('visa_process_names', 'VisaProcess\VisaStepsController@visa_process_names')->name('visa_process_names');
    Route::post('visa_process_offer_letter', 'VisaProcess\VisaStepsController@visa_process_offer_letter')->name('visa_process_offer_letter');
    Route::post('visa_process_offer_letter_sub', 'VisaProcess\VisaStepsController@visa_process_offer_letter_sub')->name('visa_process_offer_letter_sub');
    Route::post('visa_process_electronic_pre_app', 'VisaProcess\VisaStepsController@visa_process_electronic_pre_app')->name('visa_process_electronic_pre_app');
    Route::post('visa_process_electronic_pre_app_pay', 'VisaProcess\VisaStepsController@visa_process_electronic_pre_app_pay')->name('visa_process_electronic_pre_app_pay');
    Route::post('visa_process_print_inside_outside', 'VisaProcess\VisaStepsController@visa_process_print_inside_outside')->name('visa_process_print_inside_outside');
    Route::post('visa_process_status_change', 'VisaProcess\VisaStepsController@visa_process_status_change')->name('visa_process_status_change');
    Route::post('visa_process_entry_date', 'VisaProcess\VisaStepsController@visa_process_entry_date')->name('visa_process_entry_date');
    Route::post('visa_process_medical', 'VisaProcess\VisaStepsController@visa_process_medical')->name('visa_process_medical');
    Route::post('visa_process_fit_unfit', 'VisaProcess\VisaStepsController@visa_process_fit_unfit')->name('visa_process_fit_unfit');
    Route::post('visa_process_emirates_id_apply', 'VisaProcess\VisaStepsController@visa_process_emirates_id_apply')->name('visa_process_emirates_id_apply');
    Route::post('visa_process_finger_print', 'VisaProcess\VisaStepsController@visa_process_finger_print')->name('visa_process_finger_print');
    Route::post('visa_process_new_contract', 'VisaProcess\VisaStepsController@visa_process_new_contract')->name('visa_process_new_contract');
    Route::post('visa_process_tawjeeh', 'VisaProcess\VisaStepsController@visa_process_tawjeeh')->name('visa_process_tawjeeh');
    Route::post('visa_process_new_contract_sub', 'VisaProcess\VisaStepsController@visa_process_new_contract_sub')->name('visa_process_new_contract_sub');
    Route::post('visa_process_new_labout_card', 'VisaProcess\VisaStepsController@visa_process_new_labout_card')->name('visa_process_new_labout_card');
    Route::post('visa_process_visa_stamp', 'VisaProcess\VisaStepsController@visa_process_visa_stamp')->name('visa_process_visa_stamp');
    Route::post('visa_process_waiting', 'VisaProcess\VisaStepsController@visa_process_waiting')->name('visa_process_waiting');
    Route::post('visa_process_zajeel', 'VisaProcess\VisaStepsController@visa_process_zajeel')->name('visa_process_zajeel');
    Route::post('visa_process_visa_pasted', 'VisaProcess\VisaStepsController@visa_process_visa_pasted')->name('visa_process_visa_pasted');
    Route::post('visa_process_unique', 'VisaProcess\VisaStepsController@visa_process_unique')->name('visa_process_unique');
    Route::post('visa_process_unique_id', 'VisaProcess\VisaStepsController@visa_process_unique_id')->name('visa_process_unique_id');
    Route::post('visa_process_labour_insurance', 'VisaProcess\VisaStepsController@visa_process_labour_insurance')->name('visa_process_labour_insurance');
    Route::post('labour_insurance_save', 'VisaProcess\ElectronicPreApprovalController@labour_insurance_save')->name('labour_insurance_save');


    //visa process between stop routes-------------------------------------

    Route::post('visa_process_stop_resume', 'VisaProcess\VisaStepsController@visa_process_stop_resume')->name('visa_process_stop_resume');
    Route::post('stop_resume_save', 'VisaProcess\VisaStepsController@stop_resume_save')->name('stop_resume_save');


    Route::post('visa_process_replacement', 'VisaProcess\VisaStepsController@visa_process_replacement')->name('visa_process_replacement');
    Route::post('visa_process_replacement_save', 'VisaProcess\VisaStepsController@visa_process_replacement_save')->name('visa_process_replacement_save');



    //visa process between stop routes ends here-------------------------------------

//visa process dashboard
    Route::get('visa_process_dashboard', 'VisaProcess\VisaStepsController@visa_process_dashboard');
    Route::get('visa_process_payments', 'VisaProcess\VisaStepsController@visa_process_payments');
    Route::post('get_visa_payment_detail', 'VisaProcess\VisaStepsController@get_visa_payment_detail')->name('get_visa_payment_detail');
    Route::get('visa_process_pendings', 'VisaProcess\VisaStepsController@visa_process_pendings');
    Route::post('visa_process_get_remaining', 'VisaProcess\VisaStepsController@visa_process_get_remaining')->name('visa_process_get_remaining');

    Route::get('visa_renew_process_payments', 'VisaProcess\VisaStepsController@visa_renew_process_payments');
    Route::post('get_renew_visa_payment_detail', 'VisaProcess\VisaStepsController@get_renew_visa_payment_detail')->name('get_renew_visa_payment_detail');



    Route::resource('visa_renew', 'VisaProcess\RenewVisaProcessController', [
        'names' => [
            'index' => 'visa_renew',
            'create' => 'visa_renew.create',
            'store' => 'visa_renew.store',
            'edit' => 'visa_renew.edit',
            'show' => 'visa_renew.show',
            'update' => 'visa_renew.update',
            'delete' => 'visa_renew.delete'
        ]
    ]);
    Route::post('visa_renew_names', 'VisaProcess\RenewVisaProcessController@visa_renew_names')->name('visa_renew_names');
    Route::post('renew_nested', 'VisaProcess\RenewVisaProcessController@renew_nested')->name('renew_nested');
    Route::get('start_renew_visa/{id}', 'VisaProcess\RenewVisaProcessController@start_renew_visa')->name('start_renew_visa');
    Route::get('renew_visa_process', 'VisaProcess\RenewVisaProcessController@renew_visa_process');
    Route::post('renew_visa_process_names', 'VisaProcess\RenewVisaProcessController@renew_visa_process_names')->name('renew_visa_process_names');


    Route::post('renew_visa_process_contract_typing', 'VisaProcess\RenewVisaProcessController@renew_visa_process_contract_typing')->name('renew_visa_process_contract_typing');
    Route::post('renewcontract_typing_save', 'VisaProcess\RenewVisaProcessController@renewcontract_typing_save')->name('renewcontract_typing_save');
    Route::post('renew_visa_process_contract_sub', 'VisaProcess\RenewVisaProcessController@renew_visa_process_contract_sub')->name('renew_visa_process_contract_sub');
    Route::post('renewcontract_sub_save', 'VisaProcess\RenewVisaProcessController@renewcontract_sub_save')->name('renewcontract_sub_save');
    Route::post('renew_visa_process_medical', 'VisaProcess\RenewVisaProcessController@renew_visa_process_medical')->name('renew_visa_process_medical');
    Route::post('renewmedical_save', 'VisaProcess\RenewVisaProcessController@renewmedical_save')->name('renewmedical_save');

    Route::post('reneweid_apply_save', 'VisaProcess\RenewVisaProcessController@reneweid_apply_save')->name('reneweid_apply_save');

    Route::post('renew_emirates_id_apply', 'VisaProcess\RenewVisaProcessController@renew_emirates_id_apply')->name('renew_emirates_id_apply');
    Route::post('renew_visa_stamping', 'VisaProcess\RenewVisaProcessController@renew_visa_stamping')->name('renew_visa_stamping');
    Route::post('renew_visa_stamp_save', 'VisaProcess\RenewVisaProcessController@renew_visa_stamp_save')->name('renew_visa_stamp_save');


    Route::post('renew_visa_pasting', 'VisaProcess\RenewVisaProcessController@renew_visa_pasting')->name('renew_visa_pasting');
    Route::post('renew_visa_pasted_save', 'VisaProcess\RenewVisaProcessController@renew_visa_pasted_save')->name('renew_visa_pasted_save');

    Route::post('renew_visa_eid_rec', 'VisaProcess\RenewVisaProcessController@renew_visa_eid_rec')->name('renew_visa_eid_rec');
    Route::post('renew_visa_eid_rec_save', 'VisaProcess\RenewVisaProcessController@renew_visa_eid_rec_save')->name('renew_visa_eid_rec_save');

    Route::post('renew_visa_eid_handover', 'VisaProcess\RenewVisaProcessController@renew_visa_eid_handover')->name('renew_visa_eid_handover');
    Route::post('renew_eid_handover', 'VisaProcess\RenewVisaProcessController@renew_eid_handover')->name('renew_eid_handover');
    //list of all expired visas
    Route::get('expired_visa', 'VisaProcess\RenewVisaProcessController@expired_visa');
    Route::post('renew_visa_pendings', 'VisaProcess\RenewVisaProcessController@renew_visa_pendings')->name('renew_visa_pendings');
//renew visa expires
    Route::get('renew_expired_visa', 'VisaProcess\RenewVisaProcessController@renew_expired_visa');
    Route::get('renew_visa_history', 'VisaProcess\RenewVisaProcessController@renew_visa_history');


//own-visa-process
    Route::resource('own_visa', 'VisaProcess\OwnVisaController', [
        'names' => [
            'index' => 'own_visa',
            'create' => 'own_visa.create',
            'store' => 'own_visa.store',
            'edit' => 'own_visa.edit',
            'show' => 'own_visa.show',
            'update' => 'own_visa.update',
            'delete' => 'own_visa.delete'
        ]
    ]);


    Route::post('own_contract_typing', 'VisaProcess\OwnVisaController@own_contract_typing')->name('own_contract_typing');
    Route::post('own_contract_typing_save', 'VisaProcess\OwnVisaController@own_contract_typing_save')->name('own_contract_typing_save');
    Route::post('own_contract_sub', 'VisaProcess\OwnVisaController@own_contract_sub')->name('own_contract_sub');
    Route::post('own_contract_sub_save', 'VisaProcess\OwnVisaController@own_contract_sub_save')->name('own_contract_sub_save');
    Route::post('own_labour', 'VisaProcess\OwnVisaController@own_labour')->name('own_labour');
    Route::post('own_contract_lab_save', 'VisaProcess\OwnVisaController@own_contract_lab_save')->name('own_contract_lab_save');
    Route::get('own_visa_list', 'VisaProcess\OwnVisaController@own_visa_list');
    Route::get('own_visa_to_start', 'VisaProcess\OwnVisaController@own_visa_to_start');
    Route::post('own_visa_sub', 'VisaProcess\OwnVisaController@own_visa_sub')->name('own_visa_sub');

    //takaful emarat
    Route::get('takaful_emarat','VisaProcess\VisaStepsController@takaful_emarat');
    Route::post('takaful_save', 'VisaProcess\VisaStepsController@takaful_save')->name('takaful_save');

    Route::post('load_takaful', 'VisaProcess\VisaStepsController@load_takaful')->name('load_takaful');

    Route::post('takaful_update', 'VisaProcess\VisaStepsController@takaful_update')->name('takaful_update');

    Route::post('takaful_check', 'VisaProcess\VisaStepsController@takaful_check')->name('takaful_check');
    Route::post('load_company_network', 'VisaProcess\VisaStepsController@load_company_network')->name('load_company_network');


    Route::get('change_own_visa_status', 'VisaProcess\OwnVisaController@change_own_visa_status')->name('change_own_visa_status');
    Route::post('own_visa_status_change', 'VisaProcess\VisaStepsController@own_visa_status_change')->name('own_visa_status_change');

    Route::post('own_visa_change_save', 'VisaProcess\OwnVisaController@own_visa_change_save')->name('own_visa_change_save');




    // Route::post('visa_bypass', 'VisaProcess\VisaStepsController@visa_bypass')->name('visa_bypass');


    Route::get('takaful_edit/{id}', 'VisaProcess\VisaStepsController@takaful_edit')->name('takaful_edit');

    Route::get('visa_bypass/{id}', 'VisaProcess\VisaStepsController@visa_bypass')->name('visa_bypass');


    Route::get('visa_pybass_list','VisaProcess\VisaStepsController@visa_pybass_list');

    Route::get('gl_wmc','VisaProcess\VisaStepsController@gl_wmc');
    Route::post('load_gl_wmc', 'VisaProcess\VisaStepsController@load_gl_wmc')->name('load_gl_wmc');

    Route::post('gl_save', 'VisaProcess\VisaStepsController@gl_save')->name('gl_save');

    Route::post('gl_update', 'VisaProcess\VisaStepsController@gl_update')->name('gl_update');

    Route::get('gl_edit/{id}', 'VisaProcess\VisaStepsController@gl_edit')->name('gl_edit');

    Route::resource('cancel_category_ppuid', 'PpuidCancel\CancelCategoryController');


    //careem
    Route::resource('careem_cod', 'careem\CareemController', [
        'names' => [
            'index' => 'careem_cod',
            'create' => 'careem_cod.create',
            'store' => 'careem_cod.store',
            'edit' => 'careem_cod.edit',
            'show' => 'careem_cod.show',
            'update' => 'careem_cod.update',
            'delete' => 'careem_cod.delete'
        ]
    ]);
    Route::post('careem_render_calender', 'careem\CareemController@careem_render_calender')->name('careem_render_calender');
    Route::get('careem_add_cash_cod','careem\CareemController@create')->name('careem_add_cash_cod');
    Route::put('careem_update_cash_cod','careem\CareemController@careem_update_cash_cod')->name('careem_update_cash_cod');
    Route::put('careem_update_bank_cod','careem\CareemController@careem_update_bank_cod')->name('careem_update_bank_cod');
    Route::post('careem_delete_cash_cod','careem\CareemController@careem_delete_cash_cod')->name('careem_delete_cash_cod');
    Route::post('careem_delete_bank_cod','careem\CareemController@careem_delete_bank_cod')->name('careem_delete_bank_cod');
    Route::get('careem_add_bank_cod','careem\CareemController@show')->name('careem_add_bank_cod');
    Route::post('careem_store_cash','careem\CareemController@store_cash_cod')->name('careem_store_cash');
    Route::post('careem_store_bank','careem\CareemController@store_bank_cod')->name('careem_store_bank');
    Route::get('careem_cash_cod','careem\CareemController@cash_cod')->name('careem_cash_cod');
    Route::get('careem_bank_cod','careem\CareemController@bank_cod')->name('careem_bank_cod');
    Route::post('careem_total_cod_cash','careem\CareemController@ajax_total_cod_cash')->name('careem_total_cod_cash');
    Route::post('careem_total_cod_bank','careem\CareemController@ajax_total_cod_bank')->name('careem_total_cod_bank');
    Route::get('careem_close_month','careem\CareemController@close_month')->name('careem_close_month');
    Route::post('save_close_month','careem\CareemController@save_close_month')->name('save_close_month');
    Route::get('careem_rider_wise_cod','careem\CareemController@rider_wise_cod')->name('careem_rider_wise_cod');
    Route::post('ajax_rider_report_careem','careem\CareemController@ajax_rider_report')->name('ajax_rider_report_careem');
    Route::get('careem_balance_cod','careem\CareemController@careem_balance_cod')->name('careem_balance_cod');
    Route::post('ajax_balance_careem','careem\CareemController@ajax_balance_cod')->name('ajax_balance_careem');
    Route::post('save_careem_followup','careem\CareemController@save_followup')->name('save_careem_followup');
    Route::get('careem_follow_up_calls', 'careem\CareemController@follow_up_calls')->name('careem_follow_up_calls');
    Route::get('careem_uploaded_data', 'careem\CareemController@uploaded_data')->name('careem_uploaded_data');
    Route::post('careem_get_details', 'careem\CareemController@get_details')->name('careem_get_details');
    Route::get('careem_dashboard','careem\CareemController@dashboard')->name('careem_dashboard');
    Route::get('ajax_careem_dashboard','careem\CareemController@ajax_careem_dashboard')->name('ajax_careem_dashboard');
    Route::post('careem_cash_cod_upload','careem\CareemController@careem_cash_cod_upload')->name('careem_cash_cod_upload');

    //carrefour
    Route::resource('carrefour_cod', 'carrefour\CarrefourController', [
        'names' => [
            'index' => 'carrefour_cod',
            'create' => 'carrefour_cod.create',
            'store' => 'carrefour_cod.store',
            'edit' => 'carrefour_cod.edit',
            'show' => 'carrefour_cod.show',
            'update' => 'carrefour_cod.update',
            'delete' => 'carrefour_cod.delete'
        ]
    ]);
    Route::post('carrefour_render_calender', 'carrefour\CarrefourController@carrefour_render_calender')->name('carrefour_render_calender');
    Route::get('carrefour_add_cash_cod','carrefour\CarrefourController@create')->name('carrefour_add_cash_cod');
    Route::post('carrefour_store_cash','carrefour\CarrefourController@carrefour_store_cash')->name('carrefour_store_cash');
    Route::get('carrefour_cash_cod','carrefour\CarrefourController@show')->name('carrefour_cash_cod');
    Route::post('carrefour_total_cod_cash','carrefour\CarrefourController@ajax_total_cod_cash')->name('carrefour_total_cod_cash');
    Route::put('carrefour_update_cash_cod','Carrefour\CarrefourController@carrefour_update_cash_cod')->name('carrefour_update_cash_cod');
    Route::post('carrefour_delete_cash_cod','carrefour\CarrefourController@carrefour_delete_cash_cod')->name('carrefour_delete_cash_cod');
    Route::get('carrefour_close_month','carrefour\CarrefourController@close_month')->name('carrefour_close_month');
    Route::post('carrefour_save_close_month','carrefour\CarrefourController@save_close_month')->name('carrefour_save_close_month');
    Route::get('carrefour_cash_cod_upload','carrefour\CarrefourController@cash_cod_upload')->name('carrefour_cash_cod_upload');
    Route::post('store_cash_cod_upload','carrefour\CarrefourController@store_cash_cod_upload')->name('store_cash_cod_upload');
    Route::post('carrefour_cash_render_calender', 'carrefour\CarrefourController@carrefour_cash_render_calender')->name('carrefour_cash_render_calender');
    Route::get('carrefour_rider_wise_cod','carrefour\CarrefourController@rider_wise_cod')->name('carrefour_rider_wise_cod');
    Route::post('ajax_rider_report_carrefour','carrefour\CarrefourController@ajax_rider_report')->name('ajax_rider_report_carrefour');
    Route::get('carrefour_balance_cod','carrefour\CarrefourController@carrefour_balance_cod')->name('carrefour_balance_cod');
    Route::post('ajax_balance_carrefour','carrefour\CarrefourController@ajax_balance_cod')->name('ajax_balance_carrefour');
    Route::post('save_carrefour_followup','carrefour\CarrefourController@save_followup')->name('save_carrefour_followup');
    Route::get('carrefour_follow_up_calls','carrefour\CarrefourController@follow_up_calls')->name('carrefour_follow_up_calls');
    Route::get('carrefour_uploaded_data','carrefour\CarrefourController@uploaded_data')->name('carrefour_uploaded_data');
    Route::post('carrefour_get_details','carrefour\CarrefourController@get_details')->name('carrefour_get_details');
    Route::get('carrefour_dashboard','carrefour\CarrefourController@dashboard')->name('carrefour_dashboard');
    Route::get('carrefour_ajax_dashboard','carrefour\CarrefourController@ajax_dashboard')->name('carrefour_ajax_dashboard');

    //Box Installation
    Route::get('box_install_request','VehicleReport\VehicleReportController@box_install_request')->name('box_install_request');
    Route::post('get_bike_details','VehicleReport\VehicleReportController@get_bike_details')->name('get_bike_details');
    Route::post('save_box_request_dc','VehicleReport\VehicleReportController@save_box_request_dc')->name('save_box_request_dc');
    Route::get('dc_box_install_requests','VehicleReport\VehicleReportController@dc_box_install_requests')->name('dc_box_install_requests');
    Route::get('box_request_rta','VehicleReport\VehicleReportController@box_request_rta')->name('box_request_rta');
    Route::post('save_box_request_rta','VehicleReport\VehicleReportController@save_box_request_rta')->name('save_box_request_rta');
    Route::get('box_requests','VehicleReport\VehicleReportController@box_requests')->name('box_requests');
    Route::post('accept_box_request','VehicleReport\VehicleReportController@accept_box_request')->name('accept_box_request');
    Route::get('box_process','VehicleReport\VehicleReportController@box_process')->name('box_process');
    Route::post('box_process_details','VehicleReport\VehicleReportController@box_process_details')->name('box_process_details');
    Route::get('box_process_details_ajax','VehicleReport\VehicleReportController@box_process_details_ajax')->name('box_process_details_ajax');

    Route::post('box_upload_documents','VehicleReport\VehicleReportController@box_upload_documents')->name('box_upload_documents');
    Route::get('box_create_batch','VehicleReport\VehicleReportController@create_batch')->name('box_create_batch');
    Route::get('box_reference_number','VehicleReport\VehicleReportController@reference_number')->name('box_reference_number');
    Route::post('save_box_batch','VehicleReport\VehicleReportController@save_box_batch')->name('save_box_batch');
    Route::post('get_box_batchs','VehicleReport\VehicleReportController@get_box_batchs')->name('get_box_batchs');
    Route::post('send_bike_to_install','VehicleReport\VehicleReportController@send_bike_to_install')->name('send_bike_to_install');
    Route::get('get_batch_details','VehicleReport\VehicleReportController@get_batch_details')->name('get_batch_details');
    Route::post('ajax_send_bike_to_install','VehicleReport\VehicleReportController@ajax_send_bike_to_install')->name('ajax_send_bike_to_install');
    Route::post('upload_box_image','VehicleReport\VehicleReportController@upload_box_image')->name('upload_box_image');
    Route::get('get_box_document_details','VehicleReport\VehicleReportController@get_box_document_details')->name('get_box_document_details');
    Route::get('get_box_image','VehicleReport\VehicleReportController@get_box_image')->name('get_box_image');
    Route::get('get_box_bike_details','VehicleReport\VehicleReportController@get_box_bike_details')->name('get_box_bike_details');
    Route::get('get_box_platform','VehicleReport\VehicleReportController@get_box_platform')->name('get_box_platform');
    Route::post('update_box_documents','VehicleReport\VehicleReportController@update_box_documents')->name('update_box_documents');
    Route::post('update_box_image','VehicleReport\VehicleReportController@update_box_image')->name('update_box_image');
    Route::get('box_removal','VehicleReport\VehicleReportController@box_removal')->name('box_removal');
    Route::get('get_current_box','VehicleReport\VehicleReportController@get_current_box')->name('get_current_box');
    Route::post('save_box_removal','VehicleReport\VehicleReportController@save_box_removal')->name('save_box_removal');
    Route::get('removed_boxes','VehicleReport\VehicleReportController@removed_boxes')->name('removed_boxes');

    //Food Permit
    Route::get('dc_request_food','VehicleReport\VehicleReportController@dc_request_food')->name('dc_request_food');
    Route::post('food_request_dc','VehicleReport\VehicleReportController@food_request_dc')->name('food_request_dc');
    Route::get('food_process','VehicleReport\VehicleReportController@food_process')->name('food_process');
    Route::get('food_permit_process','VehicleReport\VehicleReportController@food_permit_process')->name('food_permit_process');
    Route::post('food_process_details','VehicleReport\VehicleReportController@food_process_details')->name('food_process_details');
    Route::post('food_upload_documents','VehicleReport\VehicleReportController@food_upload_documents')->name('food_upload_documents');
    Route::post('food_upload_permit','VehicleReport\VehicleReportController@food_upload_permit')->name('food_upload_permit');
    Route::get('get_food_document_details','VehicleReport\VehicleReportController@get_food_document_details')->name('get_food_document_details');
    Route::get('get_food_permit_details','VehicleReport\VehicleReportController@get_food_permit_details')->name('get_food_permit_details');
    Route::get('food_permit_expiry','VehicleReport\VehicleReportController@food_permit_expiry')->name('food_permit_expiry');
    Route::post('renew_food_permit','VehicleReport\VehicleReportController@renew_permit')->name('renew_food_permit');

    //Bike Renewal
    Route::get('bike_renewal','VehicleReport\VehicleReportController@bike_renewal')->name('bike_renewal');
    Route::post('renewal_token_save','VehicleReport\VehicleReportController@renewal_token_save')->name('renewal_token_save');
    Route::get('pending_bike_renewal','VehicleReport\VehicleReportController@renewal_pending_process')->name('pending_bike_renewal');
    Route::post('save_cash_requesition','VehicleReport\VehicleReportController@save_cash_requesition')->name('save_cash_requesition');
    Route::post('save_new_expiry','VehicleReport\VehicleReportController@save_new_expiry')->name('save_new_expiry');
    Route::get('pending_cash_request','VehicleReport\VehicleReportController@pending_cash_request')->name('pending_cash_request');
    Route::post('accept_cash_request','VehicleReport\VehicleReportController@accept_cash_request')->name('accept_cash_request');

    //Vehicle Accident
    Route::get('accident_request','VehicleReport\VehicleAccidentController@accident_request')->name('accident_request');
    Route::get('location_autocomplete','VehicleReport\VehicleAccidentController@location_autocomplete')->name('location_autocomplete');
    Route::post('get_accident_rider_details','VehicleReport\VehicleAccidentController@get_rider_details')->name('get_accident_rider_details');
    Route::post('save_vehicle_accident_request','VehicleReport\VehicleAccidentController@save_vehicle_accident_request')->name('save_vehicle_accident_request');
    Route::get('accident_autocomplete','VehicleReport\VehicleAccidentController@accident_autocomplete')->name('accident_autocomplete');
    Route::get('accident_pending_request','VehicleReport\VehicleAccidentController@accident_pending_request')->name('accident_pending_request');
    Route::get('accident_pending_process','VehicleReport\VehicleAccidentController@accident_pending_process')->name('accident_pending_process');
    Route::post('get_upload_modal_accident','VehicleReport\VehicleAccidentController@get_upload_modal_accident')->name('get_upload_modal_accident');
    Route::post('save_accident_documents','VehicleReport\VehicleAccidentController@save_accident_documents')->name('save_accident_documents');
    Route::post('save_claim_process','VehicleReport\VehicleAccidentController@save_claim_process')->name('save_claim_process');
    Route::post('bike_delivery_to_garage','VehicleReport\VehicleAccidentController@bike_delivery_to_garage')->name('bike_delivery_to_garage');
    Route::post('save_loss_repair','VehicleReport\VehicleAccidentController@save_loss_repair')->name('save_loss_repair');
    Route::get('loss_repair_bikes','VehicleReport\VehicleAccidentController@loss_repair_bikes')->name('loss_repair_bikes');
    Route::post('save_lossclaim_process','VehicleReport\VehicleAccidentController@save_lossclaim_process')->name('save_lossclaim_process');
    Route::post('save_cancel_bike_process','VehicleReport\VehicleAccidentController@save_cancel_bike_process')->name('save_cancel_bike_process');
    Route::get('accident_process','VehicleReport\VehicleAccidentController@accident_process')->name('accident_process');
    Route::post('accident_process_details','VehicleReport\VehicleAccidentController@accident_process_details')->name('accident_process_details');
    Route::get('get_accident_documents','VehicleReport\VehicleAccidentController@get_documents_details')->name('get_accident_documents');

    //Salik Tag
    Route::get('salik_operation','VehicleReport\SalikTagController@index')->name('salik_operation');
    Route::post('save_salik_operation','VehicleReport\SalikTagController@store')->name('save_salik_operation');
    Route::post('remove_salik_tag','VehicleReport\SalikTagController@update')->name('remove_salik_tag');

    Route::get('all_vehicle_report','VehicleReport\VehicleReportController@vehicle_report')->name('all_vehicle_report');
    Route::get('rta_dashboard','VehicleReport\VehicleReportController@rta_dashboard')->name('rta_dashboard');




    Route::view('/user_dashboard','admin-panel.show_user_dashboard');

    Route::get('user-dashboard-new','DashboardController@userDashboardNew')->name('userDashboardNew');
    Route::put('user-update','DashboardController@update_user')->name('update_user');
    Route::get('company-dashboard', 'DashboardController@company_wise_dashboard')->name('company_wise_dashboard');
    // Route::get('vehicle-dashboard', 'DashboardController@vehicle_wise_dashboard')->name('vehicle_wise_dashboard');

    Route::get('wps-dashboard', 'Wps\WpsDashboardController@dashboard')->name('wps_dashboard');
    Route::get('category-dashboard', 'DashboardController@category_dashboard')->name('category-dashboard');

    Route::resource('notices', 'NoticeController');
    Route::get('state_list','Master\MasterController@state_list')->name('state_list');
    Route::get('renewal_history','Master\MasterController@renewal_history')->name('renewal_history');


});
    //auth middleware end here



    //Referal route


    Route::get('vendor_onboard_accept/{id}', 'VendorRegistration\VendorRegistrationController@vendor_onboard_accept')->name('vendor_onboard_accept');
    Route::get('vendor_onboard_reject', 'VendorRegistration\VendorRegistrationController@vendor_onboard_reject')->name('vendor_onboard_reject');
    Route::get('vendor_onboard_pending/{id}', 'VendorRegistration\VendorRegistrationController@vendor_onboard_pending')->name('vendor_onboard_pending');
    Route::get('vendor-onboard-edit/{id}', 'VendorRegistration\VendorRegistrationController@vendor_onboard_edit')->name('vendor-onboard-edit');\
    Route::post('vendor-onboard-update/{id}', 'VendorRegistration\VendorRegistrationController@vendor_onboard_update')->name('vendor-onboard-update');


    Route::get('vendor_onboard', 'VendorRegistration\VendorRegistrationController@vendor_onboard')->name('vendor_onboard');
    Route::get('vendor_onboard_accept_recject','VendorRegistration\VendorRegistrationController@vendor_onboard_accept_recject')->name('vendor_onboard_accept_recject');
    Route::get('vendor_report', 'VendorRegistration\VendorRegistrationController@vendor_report');
    Route::get('ajax_vendor_rider', 'VendorRegistration\VendorRegistrationController@ajax_vendor_rider')->name('ajax_vendor_rider');
    Route::get('ajax_vendor_rider_cod', 'VendorRegistration\VendorRegistrationController@ajax_vendor_rider_cod')->name('ajax_vendor_rider_cod');




    Route::resource('referal', 'Referal\RefrealController', [
        'names' => [
            'index' => 'referal',
            'create' => 'referal.create',
            'store' => 'referal.store',
            'edit' => 'referal.edit',
            'show' => 'referal.show',
            'update' => 'referal.update',
            'delete' => 'referal.delete'
        ]
    ]);
Route::get('get_referal_user_ajax', 'Referal\RefrealController@get_referal_user_ajax')->name('get_referal_user_ajax');

    //Passport Request Route
    Route::resource('passport_request', 'Passport\PassportsRequestController', [
        'names' => [
            'index' => 'passport_request',
            'create' => 'passport_request.create',
            'store' => 'passport_request.store',
            'edit' => 'passport_request.edit',
            'show' => 'passport_request.show',
            'update' => 'passport_request.update',
            'delete' => 'passport_request.delete'
        ]
    ]);
    //four pl route


    Route::resource('four_pl', 'FourPl\FourPlController', [
        'names' => [
            'index' => 'four_pl',
            'create' => 'four_pl.create',
            'store' => 'four_pl.store',
            'edit' => 'four_pl.edit',
            'show' => 'four_pl.show',
            'update' => 'four_pl.update',
            'delete' => 'four_pl.delete'
        ]
    ]);
//bike profile route

    Route::resource('bike_profile', 'Profile\BikeProfileController', [
        'names' => [
            'index' => 'bike_profile',
            'create' => 'bike_profile.create',
            'store' => 'bike_profile.store',
            'edit' => 'bike_profile.edit',
            'show' => 'bike_profile.show',
            'update' => 'bike_profile.update',
            'delete' => 'bike_profile.delete'
        ]
    ]);


    Route::resource('salary_sheet', 'SalarySheet\SalarySheetController', [
        'names' => [
            'index' => 'salary_sheet',
            'create' => 'salary_sheet.create',
            'store' => 'salary_sheet.store',
            'edit' => 'salary_sheet.edit',
            'show' => 'salary_sheet.show',
            'update' => 'salary_sheet.update',
            'delete' => 'salary_sheet.delete'
        ]
    ]);

    Route::post('/talabat_salary_upload', 'SalarySheet\SalarySheetController@import')->name('talabat_salary_upload');
    Route::get('talabat_salary_pdf/{id}', 'SalarySheet\SalarySheetController@talabat_salary_pdf')->name('talabat_salary_pdf');
    Route::get('del_salary_pdf/{id}', 'SalarySheet\SalarySheetController@del_salary_pdf')->name('del_salary_pdf');
    Route::post('/salary_sheet_search', 'SalarySheet\SalarySheetController@salary_sheet_search')->name('salary_sheet_search');
    Route::get('uber_limo_salary_pdf/{id}', 'SalarySheet\SalarySheetController@uber_limo_salary_pdf')->name('uber_limo_salary_pdf');
//salary sheet tables loaders
    Route::post('talabat_table', 'SalarySheet\SalarySheetController@talabat_table')->name('talabat_table');
    Route::post('deliveroo_table', 'SalarySheet\SalarySheetController@deliveroo_table')->name('deliveroo_table');
    Route::post('careem_table', 'SalarySheet\SalarySheetController@careem_table')->name('careem_table');
    Route::post('careem_limo_table', 'SalarySheet\SalarySheetController@careem_limo_table')->name('careem_limo_table');
    Route::post('uber_limo_table', 'SalarySheet\SalarySheetController@uber_limo_table')->name('uber_limo_table');


    //salary sheets table loader routers ends here
    Route::resource('platform_structure', 'SalarySheet\PlatformStructureController', [
        'names' => [
            'index' => 'platform_structure',
            'create' => 'platform_structure.create',
            'store' => 'platform_structure.store',
            'edit' => 'platform_structure.edit',
            'show' => 'platform_structure.show',
            'update' => 'platform_structure.update',
            'delete' => 'platform_structure.delete'
        ]
    ]);

    //all reports
    //fuel Reports
    Route::get('fuel_report', 'Reports\AllReportsController@fuel_report');
    Route::post('daily_fuel_report', 'Reports\AllReportsController@daily_fuel_report')->name('daily_fuel_report');

Route::get('company_rate', 'SalarySheet\PlatformStructureController@company_rate');
Route::get('rider_rate', 'SalarySheet\PlatformStructureController@rider_rate');
Route::get('four_pl_company_rate', 'SalarySheet\PlatformStructureController@four_pl_company_rate');
Route::get('four_pl_rider_rate', 'SalarySheet\PlatformStructureController@four_pl_rider_rate');

Route::get('autocomplete_bike',  'Profile\BikeProfileController@autocomplete_bike')->name('autocomplete_bike');
Route::post('profile_show_bike', 'Profile\BikeProfileController@profile_show_bike')->name('profile_show_bike');

Route::post('referral_settings', 'Referal\RefrealController@referral_settings')->name('referral_settings');
Route::post('referral_settings_store', 'Referal\RefrealController@referral_settings_store')->name('referral_settings_store');
Route::get('referral_setting_update/{id}', 'Referal\RefrealController@referral_setting_update')->name('referral_setting_update');
Route::post('view_referal', 'Referal\RefrealController@view_referal')->name('view_referal');
Route::post('profile_reward_collect', 'Referal\RefrealController@profile_reward_collect')->name('profile_reward_collect');



Route::resource('assignment_report', 'Assign\AssignmentReportController', [
    'names' => [
        'index' => 'assignment_report',
        'create' => 'assignment_report.create',
        'store' => 'assignment_report.store',
        'edit' => 'assignment_report.edit',
        'show' => 'assignment_report.show',
        'update' => 'assignment_report.update',
        'delete' => 'assignment_report.delete'
    ]
]);


Route::get('get_departments', 'Ticket\TicketController@getDepartments');
//Route::post('post_tickets', 'Ticket\TicketController@storeTicket');
Route::get('download-apk','StaticController@download')->name('download-apk');
Route::get('download/apk', 'StaticController@fileDownload')->name('apk-download');
Route::get('ticket_start/{id}', 'Ticket\TicketController@ticket_start')->name('ticket_start');
Route::get('ticket_reject/{id}', 'Ticket\TicketController@ticket_reject')->name('ticket_reject');
Route::post('assign_to_management/{id}', 'Ticket\TicketController@assign_to_management')->name('assign_to_management');
//privacy policy

Route::get('privacy_policy', 'PrivacyPolicy\PrivacyPolicyController@index');



//web Rider URL Middleware

Route::group(['prefix' => 'rider'], function()
{
    Route::get('rider_login', 'WebRider\WebRiderController@rider_login')->name('rider_login');
    Route::get('rider_register', 'WebRider\WebRiderController@rider_register')->name('rider_register');
});


Route::group(['middleware' => ['auth','only_rider']], function () {
    Route::group(['prefix' => 'rider'], function()
    {
        Route::get('create_ticket','WebRider\WebRiderController@create_ticket')->name('create_ticket');
        Route::post('save_ticket', 'WebRider\WebRiderController@save_ticket')->name('save_ticket');
        Route::get('tickets', 'WebRider\WebRiderController@index')->name('tickets');
        Route::get('ticket_chat/{id}', 'WebRider\WebRiderController@ticket_chat')->name('ticket_chat');
    });
});




Route::group(['middleware' => ['auth']], function () {
    Route::get('drc_dashboard','Riders\DefaulterRiders\DefaulterRiderDrcAssignController@drc_dashboard' )->name('drc_dashboard');
    Route::get('drc_rider_operations','Riders\DefaulterRiders\DefaulterRiderDrcAssignController@drc_rider_operations' )->name('drc_rider_operations');
    Route::post('drc_rider_approval','Riders\DefaulterRiders\DefaulterRiderDrcAssignController@drc_rider_approval' )->name('drc_rider_approval');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('drcm_dashboard','Riders\DefaulterRiders\DefaulterRiderManagerController@drcm_dashboard' )->name('drcm_dashboard');
    Route::get('drcm_rider_operations','Riders\DefaulterRiders\DefaulterRiderManagerController@drcm_rider_operations' )->name('drcm_rider_operations');
    Route::post('drcm_rider_approval','Riders\DefaulterRiders\DefaulterRiderManagerController@drcm_rider_approval' )->name('drcm_rider_approval');
    Route::get('get_platforms_dcs','Riders\DefaulterRiders\DefaulterRiderManagerController@get_platforms_dcs' )->name('get_platforms_dcs');
    Route::post('save_remove_defaulter','Riders\DefaulterRiders\DefaulterRiderManagerController@save_remove_defaulter' )->name('save_remove_defaulter');

});
Route::group(['middleware' => ['auth']], function () {
    Route::get('talabat_rider_performances_view', 'Riders\RiderPerformance\TalabatRiderPerformanceController@talabat_rider_performances_view_new')->name('talabat_rider_performances_view');
    Route::resource('talabat_rider_performances', 'Riders\RiderPerformance\TalabatRiderPerformanceController');
});
Route::group(['middleware' => ['auth']], function () {
    Route::get('careem_rider_performances_view', 'Riders\RiderPerformance\CareemRiderPerformanceController@careem_rider_performances_view')->name('careem_rider_performances_view');
    Route::resource('careem_rider_performances', 'Riders\RiderPerformance\CareemRiderPerformanceController');
});

Route::group(['middleware' => ['auth']], function () {
    // These routes for admin to generate settings
    Route::get('create_rider_performance_settings', 'Riders\RiderPerformance\RiderPerformanceSettingController@create_rider_performance_settings')->name('create_rider_performance_settings');
    Route::get('ajax_load_selected_platform_columns', 'Riders\RiderPerformance\RiderPerformanceSettingController@ajax_load_selected_platform_columns')->name('ajax_load_selected_platform_columns');
    Route::get('ajax_rider_performance_platform_columns_setting', 'Riders\RiderPerformance\RiderPerformanceSettingController@ajax_rider_performance_platform_columns_setting')->name('ajax_rider_performance_platform_columns_setting');
    Route::get('ajax_profitablity_indicator_wise_setting_inputs', 'Riders\RiderPerformance\RiderPerformanceSettingController@ajax_profitablity_indicator_wise_setting_inputs')->name('ajax_profitablity_indicator_wise_setting_inputs');
    Route::post('rider_performance_settings/store', 'Riders\RiderPerformance\RiderPerformanceSettingController@store_rider_performance_settings')->name('store_rider_performance_settings');
    // These routes for admin to generate settings

    // These routes for dc and manager to generate performances
    Route::get('rider_performance_report_generate_create', 'Riders\RiderPerformance\RiderPerformanceSettingController@rider_performance_report_generate_create')->name('rider_performance_report_generate_create');
    Route::get('rider_performance_report_generate_details', 'Riders\RiderPerformance\RiderPerformanceSettingController@rider_performance_report_generate_details')->name('rider_performance_report_generate_details');
    Route::get('rider_performance_report_generate_load', 'Riders\RiderPerformance\RiderPerformanceSettingController@rider_performance_report_generate_load')->name('rider_performance_report_generate_load');
    // These routes for dc and manager to generate performances

});

Route::group(['middleware' => ['auth']], function () {
    Route::get('passport-handler-dashboard', 'PassportHandler\PassportDashboardController@passport_handler_dashboard')->name('passport-handler-dashboard');
});

Route::group(['middkeware' => ['auth']], function(){
    Route::get('rider_attendance_report', 'Riders\RiderAttendance\RiderAttendanceController@rider_attendance_report')->name('rider_attendance_report');
    Route::get('ajax_rider_attendance_report', 'Riders\RiderAttendance\RiderAttendanceController@ajax_rider_attendance_report')->name('ajax_rider_attendance_report');
});

Route::group(['middkeware' => ['auth']], function(){
    $birthday['name'] =  "Mehreen Ma'am";
    $birthday['message'] = "your dedication, determination and vision inspires us to always give our best. We appreciate having someone wonderful like you at the helm of affairs. Do have a happy birthday";
    $birthday['wishers'] = "Zone Team";
    // Route::view('birthday-wishes', 'birthday-wishes', compact('birthday'))->name('birthday-wishes');
});

Route::group(['middkeware' => ['auth']], function(){
    Route::get('talabat_rider_time_sheet_view', 'Riders\RiderTimeSheet\TalabatRiderTimeSheetController@talabat_rider_time_sheet_view')->name('talabat_rider_time_sheet_view');
    Route::resource('talabat_rider_time_sheets', 'Riders\RiderTimeSheet\TalabatRiderTimeSheetController');
});


Route::view('gallery-test', 'blue-imp-gallery');
