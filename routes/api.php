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
    return $router->app->version();
});

// Users

$router->get('/users', 'UsersController@getUsers');

$router->get('/users/{user_id}', 'UsersController@getUser');

$router->post('/users', 'UsersController@createUser');

$router->post('/users/consumers', 'UsersController@createConsumer');

$router->post('/users/sellers', 'UsersController@createSeller');

// Transactions

$router->post('/transactions', 'TransactionsController@createTransaction');

$router->get('/transactions/{transaction_id}', 'TransactionsController@getTransaction');
