<?php

Route::group([
    'namespace' => 'Event',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'stocks',
        'as' => 'event.',
    ], function () {
        Route::get('/', 'EventController@index')->name('index');
        Route::get('{event}', 'EventController@show')->name('show');
        Route::group([
            'prefix' => '{event}',
            'middleware' => 'auth'
        ], function () {
            Route::post('/review', 'EventController@review')->name('review');
            Route::post('/{comment}/review-answer', 'EventController@reviewAnswer')->name('reviewAnswer');
            Route::post('/question', 'EventController@question')->name('question');
            Route::post('/report', 'EventController@report')->name('report');
        });
    });

    /*
     * Resource
     */
});
