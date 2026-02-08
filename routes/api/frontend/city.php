<?php

Route::group([
    'namespace' => 'City',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'city',
        'as' => 'city.',
    ], function () {
        Route::get('/near', 'CityController@near'); // ближайший город
        Route::post('/all', 'CityController@all'); // все города в алфавитном порядке
        Route::post('/set', 'CityController@set'); // Установить город в куки для поддоменов
    });

    /*
     * Resource
     */
});
