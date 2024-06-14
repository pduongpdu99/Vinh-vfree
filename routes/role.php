<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/roles', 'RoleController@findAll');
$router->get('/roles/{id}', 'RoleController@findById');
$router->post('/roles', 'RoleController@create');
$router->patch('/roles/{id}', 'RoleController@update');
$router->delete('/roles/{id}', 'RoleController@delete');
