<?php
namespace Codex\Addon\Auth\Http\Controllers;


use Codex\Exception\CodexHttpException;

class AuthController extends \Codex\Http\Controller
{

    public function redirectToProvider($driver)
    {
        $this->validateDriver($driver);
        session()->set('codex.auth.redirect_after_callback', session()->previousUrl());
        return $this->codex->auth->redirect($driver);
    }

    public function logoutProvider($driver)
    {
        $this->codex->auth->logout($driver);
        return redirect()->route('codex.index');
    }

    public function handleProviderCallback($driver)
    {
        $this->validateDriver($driver);
        $this->codex->auth->callback($driver);
        return redirect()->route('codex.index');
    }

    public function getProtected()
    {
        return response(view('codex-auth::protected')->render(), 403);
    }


    /**
     * getDriver method
     *
     * @param $name
     *
     * @return \Laravel\Socialite\Contracts\Provider|mixed
     */
    protected function validateDriver($name)
    {
        if ( !in_array($name, config('codex-auth.drivers', [ ]), true) )
        {
            throw CodexHttpException::authDriverNotSupported($name);
        }
    }
}