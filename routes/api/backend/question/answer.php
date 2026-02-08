<?php

Route::group([
    'namespace' => 'Answer',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'answer',
        'as' => 'answer.',
    ], function () {
        Route::post('filter', 'AnswerController@filter')->name('filter');
        Route::group([
            'prefix' => '{answer}',
        ], function () {
            Route::post('toggle', 'AnswerController@toggle')->name('toggle');
        });
    });

    /*
     * Resource
     */
    Route::resource('answer', 'AnswerController')->only(['destroy']);
});
