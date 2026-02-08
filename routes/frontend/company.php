<?php

Route::group([
    'namespace' => 'Company',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'company',
        'as' => 'company.',
    ], function () {
        Route::get('/', 'CompanyController@index')->name('index');
        Route::get('{company}', 'CompanyController@show')->name('show');
        Route::group([
            'prefix' => '{company}',
            'middleware' => 'auth'
        ], function () {
            Route::post('/review', 'CompanyController@review')->name('review');
            Route::post('/{comment}/review-answer', 'CompanyController@reviewAnswer')->name('reviewAnswer');
            Route::post('/report', 'CompanyController@report')->name('report');
        });
    });

    /*
     * Resource
     */
});
