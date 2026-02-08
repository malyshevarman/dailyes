<?php

Route::group([
    'namespace' => 'Label',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'label',
        'as' => 'label.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('label', 'LabelController')->only(['index', 'create', 'edit']);
});
