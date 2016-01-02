<?php

namespace Codex\Hooks\Auth;

use Codex\Core\Traits\ProvidesCodex;
use Codex\Hooks\Auth\Hooks\ControllerDocumentHook;
use Codex\Hooks\Auth\Hooks\FactoryHook;
use Illuminate\View\View;
use Sebwite\Support\ServiceProvider;

/**
 * The main service provider
 *
 * @author        Sebwite
 * @copyright     Copyright (c) 2015, Sebwite
 * @license       https://tldrlegal.com/license/mit-license MIT
 * @package       Codex\AuthHook
 */
class HookServiceProvider extends ServiceProvider
{
    use ProvidesCodex;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex.hooks.auth' ];

    protected $viewDirs = [ 'views' => 'codex/auth' ];

    protected $providers = [
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class,
        \Laravel\Socialite\SocialiteServiceProvider::class
    ];

    public function register()
    {
        $app = parent::register();
        $this->addRouteProjectNameExclusions('auth');
        $this->addCodexHook('factory:ready', FactoryHook::class);
        $this->addCodexHook('controller:document', ControllerDocumentHook::class);
    }

    public function boot()
    {
        $app = parent::boot();
        $app->make('codex')->appendSectionsView('codex/auth::sections.header-actions-right');
    }


}
