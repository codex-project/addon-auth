<?php
namespace Codex\Addon\Auth;

use Codex\Addons\Annotations\Hook;
use Codex\Codex;
use Codex\Contracts\Projects\Projects;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Menus\Node;
use Codex\Projects\Project;

class AuthHooks
{
    /**
     * controllerDocument method
     * @Hook("controller:document")
     *
     * @param \Codex\Http\Controllers\CodexController $controller
     * @param \Codex\Documents\Document               $document
     * @param \Codex\Codex     $codex
     * @param \Codex\Projects\Project                 $project
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response|void
     */
    public function controllerDocument(CodexController $controller, Document $document, Codex $codex, Project $project)
    {
        if ( false === $this->hasEnabledAuth($project) )
        {
            return;
        }
        if ( $codex->auth->hasAccess($project) === false )
        {
            return $codex->error(
                config('codex-auth.error.title'),
                config('codex-auth.error.text'),
                403,
                2
            );
        }
    }


    /**
     * @Hook("projects:resolved:node")
     * @param \Codex\Contracts\Projects\Projects $projects
     * @param \Codex\Projects\Project            $project
     * @param \Codex\Menus\Node                  $node
     *
     * @throws \Codex\Exception\CodexException
     */
    public function projectsResolvedNode(Projects $projects, Project $project, Node $node)
    {
        if ( false === $this->hasEnabledAuth($project) )
        {
            return;
        }
        if ( false === $project->hasAccess() )
        {
            $node->setMeta('hidden', true);
            // if all neighbors are hidden, hide the parent as well
            if ( $node->hasParent() && $node->neighbors()->where('meta.hidden', true)->count() === count($node->getNeighbors()))
            {
                $node->getParent()->setMeta('hidden', true);
            }
        }
    }

    /**
     * @Hook("constructed")
     * @param \Codex\Contracts\Codex $codex
     */
    public function codexConstructed(Codex $codex)
    {
        $codex->extend('auth', CodexAuth::class);
    }

    /**
     * @Hook("project:constructed")
     * @param \Codex\Projects\Project $project
     */
    public function projectConstructed(Project $project)
    {
        $project->extend('hasEnabledAuth', function () use ($project)
        {
            return $project->config('auth.enabled', false) === true;
        });
        $project->extend('hasAccess', function () use ($project)
        {
            if ( false === $project->hasEnabledAuth() )
            {
                return true;
            }
            if ( $project->getCodex()->auth->hasAccess($project) )
            {
                return true;
            }
            return false;
        });
    }


    protected function hasEnabledAuth(Project $project)
    {
        return $project->config('auth.enabled', false) === true;
    }
}
