<?php
namespace Codex\Addon\Auth;

use Codex\Contracts\Codex;
use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex-auth' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];


    protected $providers = [
        \Laravel\Socialite\SocialiteServiceProvider::class,
        Http\HttpServiceProvider::class,
        Socialite\SocialiteServiceProvider::class
    ];

    public function boot()
    {
        $app = parent::boot();

        $this->codex()->pushToStack('header', $this->codexView('auth.stacks.header.auth-menu'));
        $this->codex()->theme->addStylesheet('auth', 'vendor/codex-auth/styles/auth');

        return $app;
    }

    public function register()
    {
        $app = parent::register();
        $this->codexIgnoreRoute('auth');
        $this->codexView('auth', [
            'stacks' => [
                'header' => [
                    'auth-menu' => 'codex-auth::stacks.header-auth-menu',
                ],
            ],
        ]);
        $this->registerCodexAuthExtension();
        return $app;
    }


    protected function registerCodexAuthExtension()
    {
        $this->codexHook('constructed', function (Codex $codex)
        {
            $codex->extend('auth', Auth::class);
        });
    }
}