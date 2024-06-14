<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->get('/permissions', 'PermissionController@findAll');
    $router->get('/permissions/{id}', 'PermissionController@findById');
    $router->post('/permissions', 'PermissionController@create');
    $router->patch('/permissions/{id}', 'PermissionController@update');
    $router->delete('/permissions/{id}', 'PermissionController@delete');
});
