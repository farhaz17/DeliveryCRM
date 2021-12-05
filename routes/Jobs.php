
<?php

// open routes

 Route::get('list_of_jobs2', 'Jobs\JobsController@list_of_jobs2');

 Route::get('get_full_job_detail2/{id}', 'Jobs\JobsController@get_full_job_detail2')->name('get_full_job_detail2');

 Route::get('apply_job_2/{id}', 'Jobs\JobsController@apply_job_2')->name('apply_job_2');

//  Route::post('apply_store_2', 'Jobs\JobsController@apply_store_2')->name('apply_store_2');
 Route::post('apply_store_2','Jobs\JobsController@apply_store_2')->middleware('cors');


Route::group(['middleware' => 'auth','prefix' => '/'], function () {
Route::resource('jobs','Jobs\JobsController',[
        'names' => [
            'index' => 'jobs',
            'create' => 'jobs.create',
            'store' => 'jobs.store',
            'edit' => 'jobs.edit',
            'show' => 'jobs.show',
            'update' => 'jobs.update',
            'delete' => 'jobs.delete',
        ]
    ]);



    Route::get('jobs_posted', 'Jobs\JobsController@jobs_posted');

    Route::post('get_job_detail', 'Jobs\JobsController@get_job_detail')->name('get_job_detail');
    Route::get('list_of_jobs', 'Jobs\JobsController@list_of_jobs');

    Route::get('get_full_job_detail/{id}', 'Jobs\JobsController@get_full_job_detail')->name('get_full_job_detail');

    // Route::get('apply_job', 'Jobs\JobsController@apply_job');
    Route::get('apply_job/{id}', 'Jobs\JobsController@apply_job')->name('apply_job');
    Route::post('apply_store', 'Jobs\JobsController@apply_store')->name('apply_store');

    Route::get('applicants_list', 'Jobs\JobsController@applicants_list');
    Route::post('get_app_comments', 'Jobs\JobsController@get_app_comments')->name('get_app_comments');
    Route::post('get_app_cover_letter', 'Jobs\JobsController@get_app_cover_letter')->name('get_app_cover_letter');
    Route::post('get_app_question', 'Jobs\JobsController@get_app_question')->name('get_app_question');
    Route::post('get_app_ref', 'Jobs\JobsController@get_app_ref')->name('get_app_ref');
    Route::get('view_jobs_title_sort/{id}', 'Jobs\JobsController@view_jobs_title_sort')->name('view_jobs_title_sort');



    Route::post('get_accept_applicant_list', 'Jobs\JobsController@get_accept_applicant_list')->name('get_accept_applicant_list');
    Route::post('get_reject_applicant_list', 'Jobs\JobsController@get_reject_applicant_list')->name('get_reject_applicant_list');

    Route::get('accept_app/{id}', 'Jobs\JobsController@accept_app')->name('accept_app');
    Route::get('rej_app/{id}', 'Jobs\JobsController@rej_app')->name('rej_app');


});
    ?>

