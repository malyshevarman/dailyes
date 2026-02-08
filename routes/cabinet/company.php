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
        Route::group([
            'prefix' => '{company}',
        ], function () {
            Route::get('stat', 'CompanyController@stat')->name('stat');
            require __DIR__ . '/company/address.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('company', 'CompanyController')->only(['index', 'create', 'edit']);
});
