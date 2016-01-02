<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Http\Controllers;

use App\User;
use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Menus\MenuFactory;
use Codex\Core\Http\Controllers\Controller;
use Codex\Hooks\Auth\Contracts\Manager;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;

/**
 * This is the class AuthController.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class AuthController extends Controller
{
    use AuthenticatesUsers, ThrottlesLogins;

    protected $redirectPath = '/dashboard';

    protected $manager;

    public function getLogin()
    {
        return view('codex/auth::login');
    }

    public function getLogout()
    {
        foreach ($this->manager->getLoggedInProviders() as $provider) {
            $this->manager->logout($provider);
        }

        \Auth::logout();

        return redirect()->route('codex.hooks.auth.login');
    }


    /**
     * Create a new authentication controller instance.
     *
     * @param \Codex\Core\Contracts\Codex             $codex
     * @param \Codex\Core\Contracts\Menus\MenuFactory $menu
     * @param \Illuminate\Contracts\View\Factory      $view
     * @param \Laravel\Socialite\Contracts\Factory    $social
     */
    public function __construct(Codex $codex, MenuFactory $menu, ViewFactory $view, Manager $manager)
    {
        parent::__construct($codex, $menu, $view);
        $this->manager = $manager;

        $this->middleware('guest', [ 'except' => 'getLogout' ]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|max:255',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data[ 'name' ],
            'email'    => $data[ 'email' ],
            'password' => bcrypt($data[ 'password' ]),
        ]);
    }
}
