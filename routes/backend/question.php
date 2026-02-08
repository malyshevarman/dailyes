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
        require __DIR__ . '/question/answer.php';
    });

    /*
     * Resource
     */
    Route::resource('question', 'QuestionController')->only(['index']);
});
