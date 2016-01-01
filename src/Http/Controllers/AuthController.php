<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Http\Controllers;

use Codex\Core\Http\Controllers\Controller;

/**
 * This is the class AuthController.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class AuthController extends Controller
{
    public function getLogin()
    {
        return view('codex/auth::login');
    }

    public function postLogin()
    {

    }

    public function getLogout()
    {

    }
}
