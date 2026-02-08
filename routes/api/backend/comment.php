<?php

Route::group([
    'namespace' => 'Comment',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'comment',
        'as' => 'comment.',
    ], function () {
        Route::post('filter', 'CommentController@filter')->name('filter');
        require __DIR__ . '/comment/answer.php';
        Route::group([
            'prefix' => '{comment}',
        ], function () {
            Route::post('toggle-published', 'CommentController@togglePublished')->name('toggle-published');
            Route::post('toggle-rejected', 'CommentController@toggleRejected')->name('toggle-rejected');
            Route::post('update-text', 'CommentController@updateText')->name('updateText');
            Route::post('update-message', 'CommentController@updateMessage')->name('updateMessage');
            Route::get('moderate', 'CommentController@moderate')->name('moderate');
        });
    });

    /*
     * Resource
     */
    Route::resource('comment', 'CommentController')->only(['destroy']);
});
