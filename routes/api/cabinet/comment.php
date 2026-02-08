<?php

Route::group([
    'namespace' => 'Comment',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'comment',
        'as' => 'comment.',
    ], function () {
        Route::group([
            'prefix' => '{comment}',
        ], function () {
            require __DIR__ . '/comment/answer.php';
        });
    });

    /*
     * Resource
     */
    Route::resource('comment', 'CommentController')->only(['show', 'update']);
});
