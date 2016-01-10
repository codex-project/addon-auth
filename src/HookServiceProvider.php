<?php

namespace Codex\Hooks\Auth;

use Codex\Core\Project;
use Codex\Core\Traits\CodexProviderTrait;
use Codex\Hooks\Auth\Hooks\ControllerDocumentHook;
use Codex\Hooks\Auth\Hooks\FactoryHook;
use Codex\Hooks\Auth\Hooks\ProjectsResolvedHook;
use Illuminate\Contracts\Foundation\Application;
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
    use CodexProviderTrait;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex.hooks.auth' ];

    protected $viewDirs = [ 'views' => 'codex/auth' ];

    protected $providers = [
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class,
        \Laravel\Socialite\SocialiteServiceProvider::class
    ];

    protected $singletons = [
        'codex.hooks.auth' => Manager::class
    ];

    protected $aliases = [
        'codex.hooks.auth' => Contracts\Manager::class
    ];

    protected $bindings = [
        'codex.hooks.auth.project' => ProjectAuth::class
    ];

    public function register()
    {
        $app = parent::register();

        $this->codexRouteExclusion('auth');
        $this->codexHook('factory:done', FactoryHook::class);
        $this->codexHook('controller:document', ControllerDocumentHook::class);
        $this->codexHook('projects:resolved', ProjectsResolvedHook::class);

        Project::extend('getAuth', function () {
            /** @var Project $this */
            return $this->getContainer()->make('codex.hooks.auth.project', [
                'project' => $this
            ]);
        });

        $this->app['events']->listen('router.before', function () {
            app('codex.hooks.auth')->shareUserData();
        });
    }

    public function boot()
    {
        $app = parent::boot();
        $app->make('codex')->stack('codex/auth::sections.header-top-menu');


    }
}
