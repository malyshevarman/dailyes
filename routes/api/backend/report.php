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
        Route::group([
            'prefix' => '{report}',
        ], function () {
            require __DIR__ . '/report/answer.php';
        });
        Route::post('filter', 'ReportController@filter')->name('filter');
        Route::get('{report}/moderate', 'ReportController@moderate')->name('moderate');
    });
});
