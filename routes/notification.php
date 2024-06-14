<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/notifications', 'NotificationController@findAll');
$router->get('/notifications/{id}', 'NotificationController@findById');
$router->post('/notifications', 'NotificationController@create');
$router->patch('/notifications/{id}', 'NotificationController@update');
$router->delete('/notifications/{id}', 'NotificationController@delete');
