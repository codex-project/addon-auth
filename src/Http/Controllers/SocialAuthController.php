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
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Session\SessionInterface;
use Laravel\Socialite\Contracts\Factory as SocialAuthFactory;

/**
 * This is the class AuthController.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class SocialAuthController extends Controller
{
    protected $social;

    protected $session;

    /**
     * Create a new authentication controller instance.
     *
     * @param \Codex\Core\Contracts\Codex             $codex
     * @param \Codex\Core\Contracts\Menus\MenuFactory $menu
     * @param \Illuminate\Contracts\View\Factory      $view
     * @param \Laravel\Socialite\Contracts\Factory    $social
     * @param \Illuminate\Session\SessionInterface    $session
     */
    public function __construct(Codex $codex, MenuFactory $menu, ViewFactory $view, SocialAuthFactory $social, Store)
    {
        parent::__construct($codex, $menu, $view);
        $this->social = $social;
        $this->session = $session;
        $this->middleware('guest', [ 'except' => 'getLogout' ]);
    }

    protected function validateProviderName($provider, $abort = true)
    {
        $valid = in_array($provider, config('codex.hooks.auth.providers'), true);
        if (!$valid && $abort) {
            abort(403, 'Not a valid provider');
        }
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Response
     */
    public function redirectToProvider($provider)
    {
        $this->validateProviderName($provider);
        return $this->social->driver($provider)->scopes(['user', 'user:email', 'read:org'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Response
     */
    public function handleProviderCallback($provider)
    {
        $this->validateProviderName($provider);
        $user = $this->social->driver($provider)->user();
        $this->session->set('login', $provider);
        return redirect()->route('codex.index');
        // $user->token;
    }
}
