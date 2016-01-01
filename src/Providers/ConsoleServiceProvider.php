<?php

namespace Codex\AuthHook\Providers;

use Sebwite\Support\ConsoleServiceProvider as BaseConsoleProvider;

/**
* This is the ConsoleServiceProvider.
*
* @author        Sebwite
* @copyright  Copyright (c) 2015, Sebwite
* @license      https://tldrlegal.com/license/mit-license MIT
* @package      Codex\AuthHook
*/
class ConsoleServiceProvider extends BaseConsoleProvider
{
    /**
     * @var  string
     */
    protected $namespace = 'Codex\\AuthHook\\Console';

    /**
     * @var  string
     */
    protected $prefix = 'codex.auth-hook.commands.';

    /**
     * @var  array
     */
    protected $commands = [
        'test'   => 'AuthHookTest'
    ];
}
