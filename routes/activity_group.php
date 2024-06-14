<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/activity_groups', 'ActivityGroupController@findAll');
$router->get('/activity_groups/{id}', 'ActivityGroupController@findById');
$router->post('/activity_groups', 'ActivityGroupController@create');
$router->patch('/activity_groups/{id}', 'ActivityGroupController@update');
$router->delete('/activity_groups/{id}', 'ActivityGroupController@delete');
