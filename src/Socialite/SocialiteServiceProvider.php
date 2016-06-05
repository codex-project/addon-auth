<?php
namespace Codex\Addon\Auth\Socialite;



class SocialiteServiceProvider extends \Laravel\Socialite\SocialiteServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Laravel\Socialite\Contracts\Factory', function ($app) {
            return new SocialiteManager($app);
        });
    }
}