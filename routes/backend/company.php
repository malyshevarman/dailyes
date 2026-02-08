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
        'middleware' => ['role:admin']
    ], function () {
        require __DIR__ . '/company/category.php';
        Route::group([
            'prefix' => '{company}',
        ], function () {
            require __DIR__ . '/company/address.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('company', 'CompanyController')->only(['index', 'create', 'edit'])->middleware('role:admin|moderator');
});
