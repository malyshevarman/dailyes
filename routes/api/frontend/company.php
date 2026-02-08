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
        'middleware' => 'auth'
    ], function () {
        Route::post('/feature', 'CompanyController@feature')->name('feature');
        Route::group([
            'prefix' => '{company}',
        ], function () {
            Route::post('/rating', 'CompanyController@rating')->name('rating');
            Route::post('/recommendation', 'CompanyController@recommendation')->name('recommendation');
            Route::post('/submit-owner', 'CompanyController@submitOwner')->name('owner');
        });
    });

    /*
     * Resource
     */
});
