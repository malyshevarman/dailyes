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

    });

    /*
     * Resource
     */
    Route::resource('answer', 'AnswerController')->only(['store', 'update']);
});
