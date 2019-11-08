<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Auth\OAuthAuthenticateFacade;


$router->group(['prefix' => 'api', 'middleware' => 'auth'], function($router) {
    $router->get('/', function () use ($router) {

        //$model->setConnection(OAuthAuthenticateFacade::connection());
        return 'authorized';

    });
});
