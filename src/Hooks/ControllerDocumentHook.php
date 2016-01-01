<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Hooks;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Hook;
use Codex\Core\Http\Controllers\CodexController;

/**
 * This is the class ControllerDocumentHook.
 *
 * @package        Codex\Hooks
 * @author         Sebwite
 * @copyright      Copyright (c) 2015, Sebwite. All rights reserved
 */
class ControllerDocumentHook implements Hook
{
    protected $codex;

    /** Instantiates the class */
    public function __construct(Codex $codex)
    {
        $this->codex = $codex;
    }

    public function handle(CodexController $controller, $projectSlug, $ref, $path)
    {
        if ( !$this->codex->hasProject($projectSlug) )
        {
            return;
        }
        $project = $this->codex->getProject($projectSlug);
        if ( $project->config('enable_auth_hook', false) !== true )
        {
            return;
        }
    }
}
