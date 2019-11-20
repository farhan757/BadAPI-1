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

$router->get('/', function () use ($router) {
    return "Hello";
});

// Users
$router->group(['prefix' => 'users'], function () use ($router) {
    $router->get('/', ['uses' => 'UserController@dataUsers']);
    $router->post('/', ['uses' => 'UserController@addUser']);

    $router->get('/{userId}', ['uses' => 'UserController@profileUser']);
    $router->post('/{userId}', ['uses' => 'UserController@updateProfileUser']);
    $router->delete('/{userId}', ['uses' => 'UserController@delete']);

    $router->put('/{userId}/to-male', ['uses' => 'UserController@toMale']);
    $router->put('/{userId}/to-female', ['uses' => 'UserController@toFemale']);

});

//male-content
$router->group(['prefix' => 'male-content', 'middleware' => 'isMale'], function () use ($router) {
    $router->get('/{userId}', ['uses' => 'MaleFemaleController@getProfile']);
});

//female-content
$router->group(['prefix' => 'female-content', 'middleware' => 'isFeMale'], function () use ($router) {
    $router->get('/{userId}', ['uses' => 'MaleFemaleController@getProfile']);
});
