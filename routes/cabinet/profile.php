<?php

Route::group([
    'namespace' => 'Profile',
], function () {
    /*
     * Additional
     */
    Route::group([
        'as' => 'profile.',
    ], function () {
        Route::view('/profile/index', 'cabinet.profile.index')->name('index')->middleware('permission:read-profile');
        Route::view('/profile', 'cabinet.profile.profile')->name('profile')->middleware('permission:read-profile');
        Route::view('/password', 'cabinet.profile.password')->name('password')->middleware('permission:read-profile-password');
        Route::get('/delete', 'ProfileController@deleteuser')->name('delete')->middleware('permission:read-profile');
    });

    /*
     * Resource
     */
});
