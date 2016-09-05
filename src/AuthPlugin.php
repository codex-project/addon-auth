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
namespace Codex\Addon\Auth;

use Codex\Addons\Annotations\Plugin;
use Codex\Addons\BasePlugin;
use Codex\Codex;

/**
 * This is the class AuthPlugin.
 *
 * @package        Codex\Addon
 * @author         Radic
 * @copyright      Copyright (c) 2015, Radic. All rights reserved
 *
 * @Plugin("auth")
 */
class AuthPlugin extends BasePlugin
{

    # BasePlugin
    protected $views = [
        'menus.auth'            => 'codex::menus.header-dropdown',
        'auth.header-auth-menu' => 'codex-auth::header-auth-menu'
    ];

    protected $routeExclusions = [ 'phpdoc' ];

    # ServiceProvider
    protected $configFiles = [ 'codex-auth' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];

    protected $assetDirs = [ 'assets' => 'codex-auth' ];

    protected $shared = [ 'codex.auth' => CodexAuth::class ];

    protected $providers = [ Socialite\SocialiteServiceProvider::class ];

    public function register()
    {
        $app = parent::register();
        if ( $app[ 'config' ]->get('codex.http.enabled', false) ) {
            $this->registerHttp();
        }

        Codex::extend('auth', CodexAuth::class);
        return $app;
    }


    protected function registerHttp()
    {
        $this->excludeRoute('auth');
        $this->app->register(Http\HttpServiceProvider::class);
    }

    public function boot()
    {
        $app = parent::boot();
        $this->bootTheme();
        $this->bootMenu();
        return $app;
    }

    protected function bootMenu()
    {
        $menu = $this->codex()->menus->add('auth');
        $menu->setAttribute('title', 'Auth');
        $menu->setAttribute('subtitle', 'Auth');
        $menu->setView($this->codex()->view('menus.auth'));
        $this->codex()->theme->pushToStack('nav', $this->view('auth.header-auth-menu'));
    }

    protected function bootTheme()
    {
        $this->codex()
            ->theme
            ->addStylesheet('auth', 'vendor/codex-auth/styles/auth')
            ->addBodyClass('codex-auth');
        //$this->codex()->theme->pushToStack('nav', $this->view('auth.header-auth-menu'));
    }

}
