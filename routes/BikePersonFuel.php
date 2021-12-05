<?php

Route::group(['middleware' => 'auth','prefix' => '/'], function () {

    Route::resource('bike_person_fuel', 'BikePersonFuel\BikePersonFuelController', [
        'names' => [
            'index' => 'bike_person_fuel',
            'create' => 'bike_person_fuel.create',
            'store' => 'bike_person_fuel.store',
            'edit' => 'bike_person_fuel.edit',
            'show' => 'bike_person_fuel.show',
            'update' => 'bike_person_fuel.update',
            'delete' => 'career_dashboard.delete'
        ]
    ]);
    Route::POST('get_current_bike_user','BikePersonFuel\BikePersonFuelController@get_current_bike_user')->name('get_current_bike_user');
    Route::GET('autocomplete_passport_have_vehicle_only','BikePersonFuel\BikePersonFuelController@autocomplete_passport_have_vehicle_only')->name('autocomplete_passport_have_vehicle_only');
    Route::GET('crown_job_checkout_bike','BikePersonFuel\BikePersonFuelController@crown_job_checkout_bike')->name('crown_job_checkout_bike');



});
//auth end here

?>
