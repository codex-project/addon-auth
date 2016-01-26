<?php
/**
 * Part of the Sebwite PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */


namespace Codex\Hooks\Auth\Exceptions;


class InvalidProviderException extends \Exception
{
    public static function forProvider($provider)
    {
        return new static("The given provider [{$provider}] is not valid");
    }
}
