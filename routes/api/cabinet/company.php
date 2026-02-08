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
        Route::get('search/{query}', 'CompanyController@search')->name('search');
        // Route::get('status/{query}', 'CompanyController@status')->name('status');
        Route::get('get', 'CompanyController@getCompanies')->name('companies');
        require __DIR__ . '/company/category.php';
        Route::group([
            'prefix' => '{company}',
        ], function () {
            Route::get('submit-owner', 'CompanyController@submitOwner')->name('owner');
            require __DIR__ . '/company/address.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('company', 'CompanyController')->only(['store', 'show', 'update', 'destroy']);
});
