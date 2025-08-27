<?php

use App\Http\Controllers\AuthController;

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->options('{any:.*}', function () {
    return response('', 200);
});

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/halo',function() use ($router) {
    return 'halo,ini udah berhasil muncul dari API ya,nah sekarang bebas mau ngapain';
});

$router->post('/login','AuthController@login');
