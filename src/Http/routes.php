<?php


    Route::get('logout', [ 'as' => 'logout', 'uses' => 'AuthController@getLogout' ]);

    Route::get('login', [ 'as' => 'login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@postLogin' ]);


    Route::group(['as' => 'social.', 'prefix' => 'social/{provider}'], function () {
        Route::get('login', [ 'as' => 'login', 'uses' => 'SocialAuthController@redirectToProvider' ]);
        Route::any('login/callback', [ 'as' => 'login.callback', 'uses' => 'SocialAuthController@handleProviderCallback' ]);
        Route::get('logout', [ 'as' => 'logout', 'uses' => 'SocialAuthController@getLogout' ]);
    });
