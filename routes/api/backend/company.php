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
        'middleware' => ['role:admin|moderator']
    ], function () {
        Route::post('filter', 'CompanyController@filter')->name('filter');
        Route::get('count', 'CompanyController@count')->name('count');
        Route::get('search/{query}', 'CompanyController@search')->name('search');
        require __DIR__ . '/company/category.php';
        Route::group([
            'prefix' => '{company}',
        ], function () {
            require __DIR__ . '/company/address.php';
            require __DIR__ . '/company/gallery.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('company', 'CompanyController')->only(['store', 'show', 'update', 'destroy'])->middleware('role:admin|moderator');
});
