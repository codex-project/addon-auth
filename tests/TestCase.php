<?php

namespace Codex\Tests\AuthHook;

abstract class TestCase extends \Sebwite\Testbench\TestCase
{
    /**
     * {@inheritdoc}
     */
    protected function getServiceProviderClass()
    {
        return \Codex\AuthHook\AuthHookServiceProvider::class;
    }

   /**
    * {@inheritdoc}
    */
    protected function getPackageRootPath()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..';
    }
}
