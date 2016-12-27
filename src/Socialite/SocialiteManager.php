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
namespace Codex\Addon\Auth\Socialite;

class SocialiteManager extends \Laravel\Socialite\SocialiteManager
{

    /**
     * Create an instance of the specified driver.
     *
     * @return \Laravel\Socialite\Two\AbstractProvider
     */
    protected function createGithubDriver()
    {
        return $this->buildProvider(
            'Codex\Addon\Auth\Socialite\GithubProvider', $this->getDriverConfig('github')
        );
    }
    /**
     * Create an instance of the specified driver.
     *
     * @return \Laravel\Socialite\One\AbstractProvider
     */
    protected function createBitbucketDriver()
    {
        return $this->buildProvider(BitbucketProvider::class, $this->getDriverConfig('bitbucket'));
    }

    protected function getDriverConfig($driver)
    {
        $config = $this->app[ 'config' ][ "codex-auth.providers.{$driver}" ];
        $uri    = $this->getCallbackUri($driver);
        if ( $driver === 'bitbucket' )
        {
            $config[ 'redirect' ] = $uri;
            $config               = $this->formatConfig($config);
        }
        else
        {
            $config[ 'redirect' ] = $uri;
        }
        return $config;
    }

    protected function getCallbackUri($driver)
    {
        return route("codex.auth.login.callback", compact('driver'));
    }

    /**
     * Format the server configuration.
     *
     * @param  array $config
     *
     * @return array
     */
    public function formatConfig(array $config)
    {
        return array_merge([
            'identifier'   => $config[ 'client_id' ],
            'secret'       => $config[ 'client_secret' ],
            'callback_uri' => $config[ 'redirect' ],
        ], $config);
    }

}