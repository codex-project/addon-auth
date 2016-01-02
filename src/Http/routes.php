<?php


    Route::get('logout', [ 'as' => 'logout', 'uses' => 'AuthController@getLogout' ]);

    Route::get('login', [ 'as' => 'login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@postLogin' ]);


Route::group(['as' => 'login.', 'prefix' => 'login/{provider}'], function () {
    Route::get('/', [ 'as' => 'social', 'uses' => 'SocialAuthController@redirectToProvider' ]);
    Route::any('callback', [ 'as' => 'social.callback', 'uses' => 'SocialAuthController@handleProviderCallback' ]);
});
