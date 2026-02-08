<?php

// Route::group([
//     'namespace' => 'Selection',
//     'middleware' => ['role:admin']
// ], function () {
//     /*
//      * Additional
//      */
//     Route::group([
//         'prefix' => 'selection',
//         'as' => 'selection.',
//     ], function () {
//         Route::post('filter', 'SelectionController@filter')->name('filter');
//         Route::get('all', 'SelectionController@all')->name('all');
//     });

//     /*
//      * Resource
//      */
//     Route::resource('selection', 'SelectionController')->only(['store', 'show', 'update', 'destroy']);
// });
