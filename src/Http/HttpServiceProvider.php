<?php
/**
 * Part of the Codex Project packages.
 *
 * License and copyright information bundled with this package in the LICENSE file.
 *
 * @author    Robin Radic
 * @copyright Copyright 2016 (c) Codex Project
 * @license   http://codex-project.ninja/license The MIT License
 */
namespace Codex\Addon\Auth\Http;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Routing\Router;

class HttpServiceProvider extends RouteServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Codex\Addon\Auth\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $useMiddleware = version_compare($this->app->version(), '5.2.0', '>=') === true;
        $router->group([
            'prefix'    => config('codex.base_route') . '/' . config('codex-auth.route_prefix'),
            'namespace' => $this->namespace,
            'as'        => 'codex.auth.',
            'middleware' => $useMiddleware ? [ 'web' ] : [ ],
        ], function ($router) {
            require realpath(__DIR__ . '/routes.php');
        });
    }
}