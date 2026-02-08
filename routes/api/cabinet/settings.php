<?php

Route::group([
    'namespace' => 'Settings',
], function () {
    /*
     * Resource
     */
    Route::resource('/settings', 'SettingsController')->only(['index']);
    Route::get('/settings/user-settings', 'SettingsController@userSettings');
    Route::post('/settings/toggle', 'SettingsController@toggle');
});
