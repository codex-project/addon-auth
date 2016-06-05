<?php
namespace Codex\Addon\Auth;

use Codex\Contracts\Codex;
use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $providers = [
        \Laravel\Socialite\SocialiteServiceProvider::class
    ];



    public function register()
    {
        $app = parent::register();

        $this->codexHook('constructed', function(Codex $codex){
            $codex->extend('auth', Auth::class);
        });



        return $app;
    }
}