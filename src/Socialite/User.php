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

use Illuminate\Contracts\Auth\Authenticatable;

class User extends \Laravel\Socialite\Two\User implements Authenticatable
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

    public function inGroup($group)
    {
        return in_array($group, $this->groups, true);
    }

    public function inAllGroups($groups = [ ])
    {
        if ( is_string($groups) )
        {
            $groups = func_get_args();
        }
        foreach ( $groups as $group )
        {
            if ( $this->inGroup($group) === false )
            {
                return false;
            }
        }
        return true;
    }

    public function inAnyGroups($groups = [ ])
    {
        if ( is_string($groups) )
        {
            $groups = func_get_args();
        }
        foreach ( $groups as $group )
        {
            if ( $this->inGroup($group) )
            {
                return true;
            }
        }
        return false;
    }


    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->token;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->token;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param  string $value
     *
     * @return void
     */
    public function setRememberToken($value)
    {
        $this->token = $value;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'token';
    }

    public function toArray()
    {
        $arr = [];
        foreach(array_keys(get_class_vars(static::class)) as $key){
            if(isset($this->{$key})){
                $arr[$key] = $this->{$key};
            }
        }
        return $arr;
    }
}