<?php

Route::group([
    'namespace' => 'Report',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'report',
        'as' => 'report.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('report', 'ReportController')->only(['index']);
    Route::resource('report/company', 'ReportController')->only(['index']);
});
