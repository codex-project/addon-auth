Codex Auth Hook
====================

[![Documentation](https://img.shields.io/badge/documentation-codex--project.ninja%2Fauth--hook-orange.svg?style=flat-square)](https://codex-project.ninja/auth-hook)
[![Source](http://img.shields.io/badge/source-auth--hook-blue.svg?style=flat-square)](https://github.com/codex-project/auth-hook)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

The Auth Hook provides Codex the means to leverage access control to the projects you define. Currently it works only with Bitbucket/Github login.

Define Github\Bitbucket groups that are allowed to view the documentation.
 
There will be support for more providers in the future. Including local/database.

Installation
------------
1. Add to composer

		composer require codex/phpdoc-hook

2. Add service provider

		Codex\Hooks\Phpdoc\HookServiceProvider::class

3. Publish and configure the configuration file

		php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=config

4. Publish the asset files

        php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=public
        
5. Publish the view files (optional)        

        php artisan vendor:publish --provider=Codex\Hooks\Phpdoc\HookServiceProvider --tag=views

6. Check the [documentation](http://codex-project.ninja/auth-hook) for more!

