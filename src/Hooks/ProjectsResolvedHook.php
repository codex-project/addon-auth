<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Hooks\Auth\Hooks;

use Codex\Core\Components\Factory\Projects;
use Codex\Core\Contracts\Hook;

class ProjectsResolvedHook implements Hook
{
    public function handle(Projects $projects)
    {
        foreach ($projects->menu()->all() as $node) {
            if ($node->hasMeta('project')) {
                /** @var \Codex\Core\Project $project */
                $project = $node->meta('project');
                if ($project->hasEnabledHook('auth')) {
                /** @var \Codex\Hooks\Auth\ProjectAuth $auth */
                    $auth = $project->getAuth();
                    if (!$auth->isAllowed()) {
                        $parent = $node->getParent();
                        $parent->removeChild($node);
                        if (count($parent->getChildren()) === 0 && $parent->getParent() !== null) {
                            $parent->getParent()->removeChild($parent);
                        }
                        //$node->setMeta('hidden', true);
                    }
                }
            }
        }
    }
}
