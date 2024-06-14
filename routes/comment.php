<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/comments', 'CommentController@findAll');
$router->get('/comments/{id}', 'CommentController@findById');
$router->post('/comments', 'CommentController@create');
$router->patch('/comments/{id}', 'CommentController@update');
$router->delete('/comments/{id}', 'CommentController@doDelete');
