<?php

Route::group([
    'namespace' => 'Invoice',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'invoice',
        'as' => 'invoice.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('invoice', 'InvoiceController')->only(['index']);
});
