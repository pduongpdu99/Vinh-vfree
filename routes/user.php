<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/users', 'UserController@findAll');
$router->get('/users/{id}', 'UserController@findById');
$router->post('/users', 'UserController@create');
$router->patch('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@delete');
