<?php

Route::group([
    'namespace' => 'Newsletter',
    'middleware' => ['role:admin']
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'newsletter',
        'as' => 'newsletter.',
    ], function () {
        Route::post('filter', 'NewsletterController@filter')->name('filter');
        Route::put('{newsletter}/toggle-is-active', 'NewsletterController@toggleIsActive')->name('toggleIsActive');
        // Route::get('count', 'NewsletterController@count')->name('count');
        // Route::get('search/{query}', 'NewsletterController@search')->name('search');
        // require __DIR__ . '/Newsletter/category.php';
        // Route::group([
        //     'prefix' => '{Newsletter}',
        // ], function () {
        //     require __DIR__ . '/Newsletter/address.php';
        //     require __DIR__ . '/Newsletter/gallery.php';
        // });
    });

    /*
     * Resource
     */
    Route::resource('newsletter', 'NewsletterController')->only(['store', 'show', 'update', 'destroy']);
});
