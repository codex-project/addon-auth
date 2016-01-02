<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Http\Controllers;

use App\User;
use Codex\Core\Contracts\Codex;
use Codex\Core\Http\Controllers\Controller;
use Codex\Hooks\Auth\Contracts\Manager;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * This is the class AuthController.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class SocialAuthController extends Controller
{
    protected $manager;

    /**
     * Create a new authentication controller instance.
     *
     * @param \Codex\Core\Contracts\Codex             $codex
     * @param \Codex\Core\Contracts\Menus\MenuFactory $menu
     * @param \Illuminate\Contracts\View\Factory      $view
     * @param \Codex\Hooks\Auth\Contracts\Manager     $manager
     *
     * @internal param \Laravel\Socialite\Contracts\Factory $social
     * @internal param \Illuminate\Session\SessionInterface $session
     */
    public function __construct(Codex $codex, ViewFactory $view, Manager $manager)
    {
        parent::__construct($codex, $view);
        $this->manager = $manager;
        $this->middleware('guest', [ 'except' => 'getLogout' ]);
    }

    protected function validateProviderName($provider, $abort = true)
    {
        $valid = $this->manager->isValidProvider($provider);
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

        return $this->manager->redirect($provider);
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Response
     */
    public function handleProviderCallback($provider)
    {
        $this->validateProviderName($provider);
        $this->manager->callback($provider);

        return redirect()->route('codex.hooks.auth.login');
        // $user->token;
    }


    public function getLogout($provider)
    {
        $this->validateProviderName($provider);
        $this->manager->logout($provider);

        return redirect()->route('codex.hooks.auth.login');
    }
}
