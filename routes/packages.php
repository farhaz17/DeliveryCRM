<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::resource('packages','Package\PackageController',[
            'names' => [
                'index' => 'packages',
                'create' => 'packages.create',
                'store' => 'packages.store',
                'edit' => 'packages.edit',
                'show' => 'packages.show',
                'update' => 'packages.update',
                'delete' => 'packages.delete',
            ]
        ]);

//packages assign page
        Route::get('package_assign', 'Package\PackageController@package_assign');
// get the details visa ajax here
        Route::post('get_rider_detail', 'Package\PackageController@get_rider_detail')->name('get_rider_detail');
        Route::post('get_package_detail', 'Package\PackageController@get_package_detail')->name('get_package_detail');
        Route::post('package_assign_save', 'Package\PackageController@package_assign_save')->name('package_assign_save');
        Route::post('package_assign_save_file', 'Package\PackageController@package_assign_save_file')->name('package_assign_save_file');

        Route::get('package_report', 'Package\PackageController@package_report');
        Route::get('merge-pdfs', 'Package\PackageController@process');


        Route::get('view_riders/{id}', 'Package\PackageController@view_riders')->name('view_riders');

        Route::post('get_inactive', 'Package\PackageController@get_inactive')->name('get_inactive');



        Route::get('deactive_packages/{id}', 'Package\PackageController@deactive_packages')->name('deactive_packages');
        Route::get('active_packages/{id}', 'Package\PackageController@active_packages')->name('active_packages');


        //package ammendment
        Route::post('package_ammend_save_file', 'Package\PackageController@package_ammend_save_file')->name('package_ammend_save_file');

        Route::get('package_sign_unsigned', 'Package\PackageController@package_sign_unsigned');

        Route::post('package_assign_checkout', 'Package\PackageController@package_assign_checkout')->name('package_assign_checkout');



        //date validation

        Route::post('get_date_detail', 'Package\PackageController@get_date_detail')->name('get_date_detail');
        Route::post('get_checkout_date_detail', 'Package\PackageController@get_checkout_date_detail')->name('get_checkout_date_detail');















    });
?>
