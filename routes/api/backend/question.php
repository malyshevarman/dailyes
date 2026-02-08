<?php

Route::group([
    'namespace' => 'Question',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'question',
        'as' => 'question.',
    ], function () {
        Route::post('filter', 'QuestionController@filter')->name('filter');
        require __DIR__ . '/question/answer.php';
        Route::group([
            'prefix' => '{question}',
        ], function () {
            Route::post('toggle', 'QuestionController@toggle')->name('toggle');
        });
    });

    /*
     * Resource
     */
    Route::resource('question', 'QuestionController')->only(['destroy']);
});
