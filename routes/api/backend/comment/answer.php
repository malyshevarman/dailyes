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
            Route::post('toggle-published', 'AnswerController@togglePublished')->name('toggle-published');
            Route::post('toggle-rejected', 'AnswerController@toggleRejected')->name('toggle-rejected');
            Route::post('update-text', 'AnswerController@updateText')->name('updateText');
            Route::post('update-message', 'AnswerController@updateMessage')->name('updateMessage');
            Route::get('moderate', 'AnswerController@moderate')->name('moderate');
        });
    });

    /*
     * Resource
     */
    Route::resource('answer', 'AnswerController')->only(['destroy']);
});
