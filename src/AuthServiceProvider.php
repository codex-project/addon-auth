<?php
namespace Codex\Addon\Auth;

use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

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
        \Laravel\Socialite\SocialiteServiceProvider::class,
        Http\HttpServiceProvider::class,
        Socialite\SocialiteServiceProvider::class,
    ];


    public function boot()
    {
        $app = parent::boot();
        $this->codex()
            ->theme
            ->addStylesheet('auth', 'vendor/codex-auth/styles/auth')
            ->addBodyClass('codex-auth');
        $this->codex()->pushToStack('header', $this->codexView('auth.header-auth-menu'));
        return $app;
    }

    protected function bootMenu()
    {
        $menu = $this->codex()->menus->add('auth');
        $menu->setAttribute('title', 'Auth');
        $menu->setAttribute('subtitle', 'Auth');
        $menu->setView($this->codex()->view('menus.auth'));
        $this->codex()->pushToStack('header', $this->codexView('auth.header-auth-menu'));
    }

    public function register()
    {
        $app = parent::register();
        $this->codexIgnoreRoute('auth');
        $this->codexView('menus.auth', 'codex::menus.header-dropdown');
        $this->codexView('auth.header-auth-menu', 'codex-auth::header-auth-menu');
        return $app;
    }

}
