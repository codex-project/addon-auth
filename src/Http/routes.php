<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */



Route::get('{driver}/login', ['as' => 'login', 'uses' => 'AuthController@redirectToProvider']);
Route::get('{driver}/callback', ['as' => 'login.callback', 'uses' => 'AuthController@handleProviderCallback']);
Route::get('{driver}/logout', ['as' => 'logout', 'uses' => 'AuthController@logoutProvider']);

Route::get('protected', ['as' => 'protected', 'uses' => 'AuthController@getProtected']);