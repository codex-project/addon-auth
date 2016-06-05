<?php
namespace Codex\Addon\Auth\Socialite;

class User extends \Laravel\Socialite\Two\User
{
    public $driver;

    public $groups;

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return mixed
     */
    public function getGroups()
    {
        return $this->groups;
    }


}