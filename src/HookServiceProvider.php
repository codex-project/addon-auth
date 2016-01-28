<?php

namespace Codex\Hooks\Auth;

use Codex\Core\Project;
use Codex\Core\Traits\CodexProviderTrait;
use Codex\Hooks\Auth\Hooks\ControllerDocumentHook;
use Codex\Hooks\Auth\Hooks\FactoryHook;
use Codex\Hooks\Auth\Hooks\ProjectsResolvedHook;
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

    protected $deferredProviders = [
        \Laravel\Socialite\SocialiteServiceProvider::class
    ];

    protected $providers = [
        Providers\ConsoleServiceProvider::class,
        Providers\RouteServiceProvider::class,
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


    public function boot()
    {
        $app = parent::boot();

        $app->make('codex')->stack('codex/auth::sections.header-top-menu', function ()
        {
            app('codex.hooks.auth')->shareUserData();
        });

        $this->mergeServicesConfig();
    }

    public function register()
    {
        $app = parent::register();

        $this->codexRouteExclusion('auth');
        $this->codexHook('factory:done', FactoryHook::class);
        $this->codexHook('controller:document', ControllerDocumentHook::class);
        $this->codexHook('projects:resolved', ProjectsResolvedHook::class);

        Project::extend('getAuth', function ()
        {
            /** @var Project $this */
            return $this->getContainer()->make('codex.hooks.auth.project', [
                'project' => $this
            ]);
        });
    }

    protected function mergeServicesConfig()
    {
        $config = $this->app->make('config');

        if ( ! $config->get('codex.hooks.auth.merge_providers', false) )
        {
            return;
        }

        $providers = $config->get('codex.hooks.auth.providers');
        foreach ( $providers as $provider => $data )
        {
            if ( !$config->has('services.' . $provider) )
            {
                $data[ 'redirect' ] = $this->getRedirectUrl($provider);
                $config->set('services.' . $provider, $data);
            }
        }
    }

    protected function getRedirectUrl($provider)
    {
        return route('codex.hooks.auth.social.login.callback', compact('provider'));
    }

}
