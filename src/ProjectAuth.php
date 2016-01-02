<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth;

use Codex\Core\Contracts\Codex;
use Codex\Core\Project;
use Codex\Core\Traits\CodexTrait;
use Codex\Core\Traits\ConfigTrait;
use Codex\Hooks\Auth\Contracts\Manager as ManagerContract;

/**
 * This is the class ProjectAuth.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class ProjectAuth
{
    use CodexTrait, ConfigTrait;

    protected $project;

    protected $manager;

    /** Instantiates the class
     *
     * @param \Codex\Core\Contracts\Codex         $codex
     * @param \Codex\Hooks\Auth\Contracts\Manager $manager
     * @param \Codex\Core\Project                 $project
     */
    public function __construct(Codex $codex, ManagerContract $manager, Project $project)
    {
        $this->setCodex($codex);
        $this->setConfig($project->config('hooks.auth'));
        $this->manager = $manager;
        $this->project = $project;
    }

    public function getProvider()
    {
        return $this->config('provider');
    }

    public function isAllowed()
    {
        if (!$this->manager->isLoggedIn($this->getProvider())) {
            return false;
        }

        $user = $this->manager->getUser($this->getProvider());

        $allow = $this->config('allow');

        if (!empty($allow[ 'users' ]) && in_array($user->nickname, $allow[ 'users' ], true)) {
            return true;
        }

        if (!empty($allow[ 'groups' ]) && !empty($user->groups)) {
            foreach ($user->groups as $group) {
                if (in_array($group, $allow[ 'groups' ], true)) {
                    return true;
                }
            }
        }

        return false;
    }
}
