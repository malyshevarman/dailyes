<?php

Route::group([
    'namespace' => 'Profile',
], function () {
    /*
     * Additional
     */
    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.',
    ], function () {
        Route::get('/get-auth-user', 'ProfileController@getAuthUser')->middleware('permission:read-profile');
        Route::put('/update-auth-user', 'ProfileController@updateAuthUser')->middleware('permission:update-profile');
        Route::put('/update-password-auth-user', 'ProfileController@updatePasswordAuthUser')->middleware('permission:update-profile-password');
        Route::post('/upload-avatar-auth-user', 'ProfileController@uploadAvatarAuthUser')->middleware('permission:update-profile');
        Route::post('/remove-avatar-auth-user', 'ProfileController@removeAvatarAuthUser')->middleware('permission:update-profile');
    });

    /*
     * Resource
     */
});
