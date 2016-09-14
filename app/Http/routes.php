<?php

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Api\v1',
    'middleware' => ['cors']
], function ($app) {
    $app->post('/auth/login', 'AuthController@login');
    $app->post('/auth/register', 'AuthController@register');
    
    $app->post('/auth/facebook', 'AuthController@facebook');
    $app->post('/auth/google', 'AuthController@google');
    $app->post('/auth/twitter', 'AuthController@twitter');
    $app->post('/auth/buffer', 'AuthController@buffer');
});

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Api\v1',
    'middleware' => ['cors', 'jwt.refresh']
], function ($app) {
    $app->get('/auth/refresh', 'AuthController@refresh');
});

Route::group([
    'prefix' => 'api/v1',
    'namespace' => 'Api\v1',
    'middleware' => ['jwt.auth', 'cors']
], function ($app) {
    $app->post('/auth/logout', 'AuthController@logout');
    $app->post('/auth/login-other', 'AuthController@loginOther');
    $app->get('/auth/user', 'AuthController@user');
    

    $app->get('/users', 'UserController@all');
});

Route::options('{any}', ['middleware' => ['cors'], function () { return response(['status' => 'success']); }])->where('any', '.*');