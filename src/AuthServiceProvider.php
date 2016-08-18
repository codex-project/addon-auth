<?php
namespace Codex\Addon\Auth;

use Codex\Codex;
use Codex\Support\Traits\CodexProviderTrait;
use Laradic\ServiceProvider\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex-auth' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];

    protected $assetDirs = [ 'assets' => 'codex-auth' ];

    protected $shared = [
        'codex.auth' => CodexAuth::class,
    ];

    protected $providers = [
        Socialite\SocialiteServiceProvider::class,
    ];

    protected $codexTheme = [
        'stylesheets' => [
            ['auth', 'vendor/codex-auth/styles/auth']
        ],
        'bodyClass' => 'codex-auth',
        'stack' => [
            'header' => ['auth.header-auth-menu']
        ]
    ];

    protected function registerHttp()
    {
        $this->codexIgnoreRoute('auth');
        $this->app->register(Http\HttpServiceProvider::class);
    }

    protected function registerViews()
    {
        $this->codexView('menus.auth', 'codex::menus.header-dropdown');
        $this->codexView('auth.header-auth-menu', 'codex-auth::header-auth-menu');
    }



    public function boot()
    {
        $app = parent::boot();
        $this->codex()
            ->theme
            ->addStylesheet('auth', 'vendor/codex-auth/styles/auth')
            ->addBodyClass('codex-auth');
        $this->codex()->pushToStack('nav', $this->codexView('auth.header-auth-menu'));
        return $app;
    }

    protected function bootMenu()
    {
        $menu = $this->codex()->menus->add('auth');
        $menu->setAttribute('title', 'Auth');
        $menu->setAttribute('subtitle', 'Auth');
        $menu->setView($this->codex()->view('menus.auth'));
        $this->codex()->pushToStack('nav', $this->codexView('auth.header-auth-menu'));
    }

    public function register()
    {
        $app = parent::register();
        $this->registerHttp();
        $this->registerViews();
        Codex::extend('auth', CodexAuth::class);
        return $app;
    }

}
