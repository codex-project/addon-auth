<?php
namespace Codex\Addon\Auth\Socialite;

use Exception;

class GithubProvider extends \Laravel\Socialite\Two\GithubProvider
{
    protected function getUserByToken($token)
    {
        $user             = parent::getUserByToken($token);
        $user[ 'groups' ] = $this->getGroupsByToken($token, $user[ 'login' ]);
        return $user;
    }

    protected function getGroupsByToken($token, $username)
    {

        $orgsUrl = 'https://api.github.com/user/orgs?access_token=' . $token;

        try
        {
            $response = $this->getHttpClient()->get(
                $orgsUrl, $this->getRequestOptions()
            );
        }
        catch (Exception $e)
        {
            return;
        }

        return collect(json_decode($response->getBody(), true))->pluck('login')->toArray();

        $groups = [ ];
        foreach ( json_decode($response->getBody(), true) as $org )
        {
            $groups[] = $org[ 'login' ];
        }
        return $groups;
    }


    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'       => $user[ 'id' ],
            'nickname' => $user[ 'login' ],
            'name'     => array_get($user, 'name'),
            'email'    => array_get($user, 'email'),
            'avatar'   => $user[ 'avatar_url' ],
            'driver' => 'github',
            'groups' => $user['groups']
        ]);
    }
}