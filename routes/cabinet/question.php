<?php

Route::group([
    'namespace' => 'Question',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'question',
        'as' => 'question.',
    ], function () {

    });

    /*
     * Resource
     */
    Route::resource('question', 'QuestionController')->only(['index', 'show']);
});
