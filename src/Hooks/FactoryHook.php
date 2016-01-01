<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Hooks;

use Codex\Core\Contracts\Hook;
use Codex\Core\Factory as CodexFactory;
use Illuminate\Contracts\Config\Repository;

/**
 * This is the Hook.
 *
 * @package        Codex\Core
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class FactoryHook implements Hook
{
    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     */
    public function __construct(Repository $config)
    {
        $this->config = $config;
    }

    public function handle(CodexFactory $codex)
    {
        $codex->setConfig(
            array_replace_recursive(
                $codex->config(),
                $this->config->get('codex.hooks.git.default_project_config')
            )
        );
    }
}
