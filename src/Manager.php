<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth;

use Codex\Core\Contracts\Codex;
use Codex\Core\Traits\CodexTrait;
use Codex\Core\Traits\ContainerTrait;
use Codex\Hooks\Auth\Contracts\Manager as ManagerContract;
use Codex\Hooks\Auth\Exceptions\InvalidProviderException;
use Illuminate\Contracts\Container\Container;
use Laravel\Socialite\Contracts\Factory as SocialAuthFactory;

/**
 * This is the class Manager.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class Manager implements ManagerContract
{
    use CodexTrait, ContainerTrait;

    protected $social;

    public function __construct(Container $container, Codex $codex, SocialAuthFactory $social)
    {
        $this->setContainer($container);
        $this->setCodex($codex);
        $this->social = $social;
    }

    public function shareUserData()
    {
        $view     = $this->container->make('view');
        if (count($this->getLoggedInProviders()) > 0) {
            $provider = $this->getLoggedInProviders()[ 0 ];

            $view->share('currentUser', $this->getUser($provider));

        }

        $auths = collect();
        foreach ($this->getProviders() as $provider) {
            if ($this->isLoggedIn($provider)) {
                $auths->put($provider, $this->getUser($provider));
            } else {
                $auths->put($provider, false);
            }
        }
        $view->share('auths', $auths);
    }

    public function getProviders()
    {
        return config('codex.hooks.auth.providers', [ ]);
    }

    public function isValidProvider($provider, $throw = false)
    {
        $valid = in_array($provider, $this->getProviders(), true);
        if($valid === false && $throw === true){
            throw InvalidProviderException::forProvider($provider);
        }
        return $valid;
    }

    public function redirect($provider)
    {
        $s = request()->session();
        $this->isValidProvider($provider, true);

        $driver = $this->social->driver($provider);
        if ($provider === 'github') {
            $driver->scopes([ 'user', 'user:email', 'read:org' ]);
        }

        return $driver->redirect();
    }

    public function callback($provider)
    {
        if (!$this->isValidProvider($provider)) {
            throw new \InvalidArgumentException("Not a valid provider [{$provider}]");
        }
        $driver       = $this->social->driver($provider);
        $user         = $driver->user();
        $git          = app('sebwite.git')->connection($provider);
        $user->groups = $git->listOrganisations($user->getNickname());

        \Session::put('login.' . $provider, true);
        \Session::put('user.' . $provider, $user);
    }

    public function isLoggedIn($provider)
    {
        return \Session::has('login.' . $provider);
    }

    public function logout($provider)
    {
        \Session::forget([ 'login.' . $provider, 'user.' . $provider ]);
    }

    public function getLoggedInProviders()
    {
        $providers = [ ];
        foreach ($this->getProviders() as $provider) {
            if ($this->isLoggedIn($provider)) {
                $providers[] = $provider;
            }
        }

        return $providers;
    }

    public function getUser($provider)
    {
        if ($this->isLoggedIn($provider)) {
            return \Session::get('user.' . $provider);
        }
    }
}
