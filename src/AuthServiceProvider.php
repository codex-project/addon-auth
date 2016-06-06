<?php
namespace Codex\Addon\Auth;

use Codex\Contracts\Codex;
use Codex\Traits\CodexProviderTrait;
use Sebwite\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    use CodexProviderTrait;

    protected $dir = __DIR__;

    protected $configFiles = [ 'codex-auth' ];

    protected $viewDirs = [ 'views' => 'codex-auth' ];

    protected $assetDirs = [ 'assets' => 'codex-auth' ];

    protected $shared = [
        'codex.auth' => Auth::class
    ];

    protected $providers = [
        \Laravel\Socialite\SocialiteServiceProvider::class,
        Http\HttpServiceProvider::class,
        Socialite\SocialiteServiceProvider::class,
    ];


    public function boot()
    {
        $app = parent::boot();


        $this->codex()
            ->theme
            ->addStylesheet('auth', 'vendor/codex-auth/styles/auth')
            ->addBodyClass('codex-auth');

        #$this->bootMenu();
        $this->codex()->pushToStack('header', $this->codexView('auth.header-auth-menu'));

        return $app;
    }

    protected function bootMenu()
    {

        $menu = $this->codex()->menus->add('auth');
        $menu->setAttribute('title', 'Auth');
        $menu->setAttribute('subtitle', 'Auth');
        $menu->setView($this->codex()->view('menus.auth'));
        $this->codexHook('menu:render', function(\Codex\Menus\Menu $menu, \Codex\Menus\Node $root, $sorter){
            if($menu->getId() === 'auth' && $menu->attr('resolved', false) !== true ){
                $auth = codex('auth');
                foreach($auth->getDrivers() as $driver)
                {
                    if ( $auth->isLoggedIn($driver) === false )
                    {
                        $node = $menu->add('auth-login-' . $driver, 'Login to ' . ucfirst($driver));
                        $node->setAttribute('href', route('codex.auth.login', $driver));
                    }
                }

                foreach($auth->getDrivers() as $driver)
                {
                    if ( $auth->isLoggedIn($driver) === true )
                    {
                        $node = $menu->add('auth-logout-' . $driver, 'Logout from ' . ucfirst($driver));
                        $node->setAttribute('href', route('codex.auth.logout', $driver));
                    }
                }
                $menu->setAttribute('resolved', true);
            }
        });
        $this->codex()->pushToStack('header', $this->codexView('auth.header-auth-menu'));

    }

    public function register()
    {
        $app = parent::register();
        $this->codexIgnoreRoute('auth');
        $this->registerCodexAuthExtension();

        $this->codexView('menus.auth', 'codex::menus.header-dropdown');
        $this->codexView('auth.header-auth-menu', 'codex-auth::header-auth-menu');
        return $app;
    }


    protected function registerCodexAuthExtension()
    {
        $this->codexHook('constructed', function (Codex $codex)
        {
            $codex->extend('auth', Auth::class);
        });
    }
}