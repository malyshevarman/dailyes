<?php

Route::group([
    'namespace' => 'Address',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'address',
        'as' => 'address.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('address', 'AddressController')->only(['create', 'edit']);
});
