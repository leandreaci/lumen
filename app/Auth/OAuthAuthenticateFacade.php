<?php


namespace App\Auth;


use Illuminate\Support\Facades\Facade;

class OAuthAuthenticateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'oauth-authenticate';
    }
}
