<?php

namespace Codex\AuthHook;

use Sebwite\Support\ServiceProvider;

/**
* The main service provider
*
* @author        Sebwite
* @copyright  Copyright (c) 2015, Sebwite
* @license      https://tldrlegal.com/license/mit-license MIT
* @package      Codex\AuthHook
*/
class AuthHookServiceProvider extends ServiceProvider
{
    protected $dir = __DIR__;

    protected $configFiles = [ 'codex.auth-hook' ];

    protected $providers = [
        \Codex\AuthHook\Providers\ConsoleServiceProvider::class
    ];
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $app = parent::boot();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $app = parent::register();
    }
}
