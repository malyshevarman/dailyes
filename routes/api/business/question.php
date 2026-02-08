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
        Route::group([
            'prefix' => '{question}',
        ], function () {
            require __DIR__ . '/question/answer.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('question', 'QuestionController')->only(['show']);
});
