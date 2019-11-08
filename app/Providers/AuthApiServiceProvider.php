<?php


namespace App\Providers;


use App\Auth\OAuthAuthenticate;
use App\Auth\OAuthAuthenticateFacade;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AuthApiServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->app->singleton('oauth-authenticate', function() {
            return new OAuthAuthenticate(
                new Client()
            );
        });

    }

    public function register()
    {

    }

}
