<?php



Route::group([ 'as' => 'codex.hooks.auth.', 'prefix' => 'auth' ], function () {

    Route::get('login', [ 'as' => 'login', 'uses' => 'AuthController@getLogin' ]);
    Route::post('login', [ 'as' => 'login', 'uses' => 'AuthController@postLogin' ]);
    Route::get('logout', [ 'as' => 'login', 'uses' => 'AuthController@getLogout' ]);
});
