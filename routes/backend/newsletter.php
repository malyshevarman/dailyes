<?php

Route::group([
    'namespace' => 'Newsletter',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    // Route::group([
        // 'prefix' => 'newsletter',
        // 'as' => 'newsletter.',
    // ], function () {
        // require __DIR__ . '/event/category.php';
        // require __DIR__ . '/event/label.php';
    // });

    /*
     * Resource
     */
    Route::resource('newsletter', 'NewsletterController')->only(['index', 'create', 'edit']);
});
