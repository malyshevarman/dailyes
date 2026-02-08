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
        Route::get('{tag?}', 'CompanyController@show')->name('show');
    });

    /*
     * Resource
     */
});
