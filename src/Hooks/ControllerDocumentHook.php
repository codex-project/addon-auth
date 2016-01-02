<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */
namespace Codex\Hooks\Auth\Hooks;

use Codex\Core\Contracts\Codex;
use Codex\Core\Contracts\Hook;
use Codex\Core\Document;
use Codex\Core\Http\Controllers\CodexController;
use Codex\Core\Project;
use Sebwite\Support\Html;

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

    public function handle(CodexController $controller, Project $project, Document $document, $ref = '', $path = '')
    {
        if (!$project->hasEnabledHook('auth')) {
            return;
        }

        /** @var \Codex\Hooks\Auth\ProjectAuth $auth */
        $auth    = $project->getAuth();
        $allowed = $auth->isAllowed();

        if (!$allowed) {
            $provider = $auth->getProvider();
            $link = Html::linkRoute('codex.hooks.auth.social.login', ucfirst($provider), compact('provider'), ['target' => '_blank']);
            return redirect()->back()->withErrors('You need to login to ' . $link . ' and be in one of the allowed groups.');
        }
    }
}
