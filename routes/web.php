<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(
    ['prefix' => 'api/v1'],
    function () use ($router) {
        $router->post('register', 'UserController@register');
        $router->get('checkToken', 'UserController@checkToken');
    }
);

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function () use ($router) {
    $router->get('getUser', 'UserController@getUser');
    $router->get('logout', 'UserController@logout');
    $router->get('getBrands', 'BrandController@index');
    $router->get('getConsoles', 'ConsoleController@index');
    $router->get('searchConsole', 'ConsoleController@searchConsole');
    $router->get('getConsole/{id}', 'ConsoleController@getConsole');
    $router->get('getCarts', 'CartController@index');
    $router->post('addCart', 'CartController@store');
    $router->delete('deleteItem/{id}', 'CartController@destroy');
});
