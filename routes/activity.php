<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/activities', 'ActivityController@findAll');
$router->get('/activities/{id}', 'ActivityController@findById');
$router->post('/activities', 'ActivityController@create');
$router->patch('/activities/{id}', 'ActivityController@update');
$router->delete('/activities/{id}', 'ActivityController@delete');
