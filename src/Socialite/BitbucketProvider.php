<?php
namespace Codex\Addon\Auth\Socialite;

use Exception;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class BitbucketProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * The scopes being requested.
     *
     * @var array
     */
    protected $scopes = [ 'account' ];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://bitbucket.org/site/oauth2/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://bitbucket.org/site/oauth2/access_token';
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string $code
     *
     * @return array
     */
    protected function getTokenFields($code)
    {
        return array_add(
            parent::getTokenFields($code), 'grant_type', 'authorization_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://api.bitbucket.org/2.0/user', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        $user = json_decode($response->getBody(), true);

        $user[ 'email' ] = $this->getEmailByToken($token);

        $user[ 'groups' ] = $this->getGroupsByToken($token);

        return $user;
    }

    /**
     * Get the email for the given access token.
     *
     * @param  string $token
     *
     * @return string|null
     */
    protected function getEmailByToken($token)
    {
        try
        {

            $response = $this->getHttpClient()->get('https://api.bitbucket.org/2.0/user/emails', [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);
        }
        catch (Exception $e)
        {
            return;
        }

        foreach ( json_decode($response->getBody(), true)[ 'values' ] as $email )
        {
            if ( $email[ 'is_primary' ] && $email[ 'is_confirmed' ] )
            {
                return $email[ 'email' ];
            }
        }
    }

    protected function getGroupsByToken($token)
    {
        $response = $this->getHttpClient()->get('https://api.bitbucket.org/1.0/user/privileges', [
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        $data = json_decode($response->getBody(), true);

        return array_keys($data[ 'teams' ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {

        return (new User)->setRaw($user)->map([
            'id'       => array_get($user, 'uuid'),
            'nickname' => array_get($user, 'username'),
            'name'     => array_get($user, 'display_name'),
            'email'    => array_get($user, 'email'),
            'avatar'   => array_get($user, 'links.avatar.href'),
            'driver'   => 'bitbucket',
            'groups'   => $user[ 'groups' ],
        ]);
    }

    /**
     * Get the default options for an HTTP request.
     *
     * @return array
     */
    protected function getRequestOptions($conf = [ ])
    {
        return array_replace_recursive([
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
            ],
        ], $conf);
    }
}