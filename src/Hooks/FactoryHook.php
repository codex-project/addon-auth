<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Hooks;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Hook;

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
    public function handle(Codex $codex)
    {
        $codex->mergeDefaultProjectConfig('codex.hooks.auth.default_project_config');

        return;
        foreach ($codex->getMenus()->get('projects')->all() as $node) {
            if ($node->hasMeta('project')) {
                /** @var \Codex\Core\Project $project */
                $project = $node->meta('project');
                if ($project->hasEnabledHook('auth')) {
                /** @var \Codex\Hooks\Auth\ProjectAuth $auth */
                    $auth = $project->getAuth();
                    if (!$auth->isAllowed()) {
                        $node->setMeta('hidden', true);
                    }
                }
            }
        }
    }
}
