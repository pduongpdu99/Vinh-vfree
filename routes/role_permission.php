<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/role_permission', 'RolePermissionController@findAll');
$router->get('/role_permission/{id}', 'RolePermissionController@findById');
$router->post('/role_permission', 'RolePermissionController@create');
$router->patch('/role_permission/{id}', 'RolePermissionController@update');
$router->delete('/role_permission/{id}', 'RolePermissionController@delete');
