<?php
/**
 * Part of the CLI PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */



Route::get('{driver}/login', ['as' => 'login', 'uses' => 'AuthController@redirectToProvider']);
Route::get('{driver}/callback', ['as' => 'login.callback', 'uses' => 'AuthController@handleProviderCallback']);
Route::get('{driver}/logout', ['as' => 'logout', 'uses' => 'AuthController@logoutProvider']);