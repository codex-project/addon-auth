<?php
namespace Codex\Addon\Auth;

use Codex\Addons\Annotations\Hook;
use Codex\Contracts\Codex;
use Codex\Contracts\Projects\Projects;
use Codex\Documents\Document;
use Codex\Http\Controllers\CodexController;
use Codex\Menus\Menu;
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
     * @param \Codex\Codex|\Codex\Contracts\Codex     $codex
     * @param \Codex\Projects\Project                 $project
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response|void
     */
    public function controllerDocument(CodexController $controller, Document $document, Codex $codex, Project $project)
    {
        if ( false === $this->hasEnabledAuth($project) ) {
            return;
        }
        if ( $codex->auth->hasAccess($project) === false ) {
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
        if ( false === $this->hasEnabledAuth($project) ) {
            return;
        }
        if ( false === $project->hasAccess() ) {
            $node->setMeta('hidden', true);
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
        $project->extend('hasEnabledAuth', function () use ($project) {
            return $project->config('auth.enabled', false) === true;
        });
        $project->extend('hasAccess', function () use ($project) {
            if ( false === $project->hasEnabledAuth() ) {
                return true;
            }
            if ( $project->getCodex()->auth->hasAccess($project) ) {
                return true;
            }
            return false;
        });
    }


    /**
     * @Hook("menu:render")
     * @param \Codex\Menus\Menu $menu
     * @param \Codex\Menus\Node $root
     * @param                   $sorter
     */
    public function menuRender(Menu $menu, Node $root, $sorter)
    {
        if ( $menu->getId() === 'auth' && $menu->attr('resolved', false) !== true ) {
            $auth = codex()->auth;

            foreach ( $auth->getDrivers() as $driver ) {
                if ( $auth->isLoggedIn($driver) === false ) {
                    $node = $menu->add('auth-login-' . $driver, 'Login to ' . ucfirst($driver));
                    $node->setAttribute('href', route('codex.auth.login', $driver));
                }
            }

            foreach ( $auth->getDrivers() as $driver ) {
                if ( $auth->isLoggedIn($driver) === true ) {
                    $node = $menu->add('auth-logout-' . $driver, 'Logout from ' . ucfirst($driver));
                    $node->setAttribute('href', route('codex.auth.logout', $driver));
                }
            }
            $menu->setAttribute('resolved', true);
        }
    }

    protected function hasEnabledAuth(Project $project)
    {
        return $project->config('auth.enabled', false) === true;
    }
}
