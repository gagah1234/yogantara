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

$router->group(['middleware' => ['auth']], function ($router){

	//Cars CRUD
	$router->get('/cars', 'CarsController@index');
	$router->post('/cars', 'CarsController@store');
	$router->get('/cars/{id}', 'CarsController@show');
	$router->put('/cars/{id}', 'CarsController@update');
	$router->delete('/cars/{id}', 'CarsController@destroy');

	//Drivers CRUD
	$router->get('/drivers', 'DriversController@index');
	$router->post('/drivers', 'DriversController@store');
	$router->get('/drivers/{id}', 'DriversController@show');
	$router->put('/drivers/{id}', 'DriversController@update');
	$router->delete('/drivers/{id}', 'DriversController@destroy');

	//Borrowings CRUD
	$router->post('/borrowings', 'BorrowingsController@store');
	$router->get('/borrowings', 'BorrowingsController@index');
	$router->get('/borrowings/{id}', 'BorrowingsController@show');
	$router->delete('/borrowings/{id}', 'BorrowingsController@destroy');

	//Transactions CRUD
	$router->post('/transactions', 'TransactionsController@store');
	$router->get('/transactions', 'TransactionsController@index');
	$router->get('/transactions/{id}', 'TransactionsController@show');
});


$router->group(['prefix' => 'auth'], function() use ($router){
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});

