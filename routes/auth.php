<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->post('/auth/signin', 'AuthController@login');
$router->post('/auth/signup', 'AuthController@registry');
$router->get('/auth/signout', 'AuthController@logout');
