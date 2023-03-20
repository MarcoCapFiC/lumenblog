<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('greetings', function () use ($router) {
    return 'Hello world';
});

//$router->get('users', ['uses' => 'UserController@showAllUsers']);
//$router->get('comments', ['uses' => 'CommentController@showAllComments']);

//1
$router->get('posts', ['uses' => 'PostController@showAllPosts']);
//2
$router->get('posts/{postId}', ['uses' => 'PostController@showOnePost']);
//3
$router->post('posts', ['middleware' => ['auth'], 'uses' => 'PostController@newPost']);
//4
$router->put('posts/{postId}', ['middleware' => ['auth'], 'uses' => 'PostController@editPost']);
//5
$router->delete('posts/{postId}', ['middleware' => ['auth'], 'uses' => 'PostController@deletePost']);
//6
$router->get('comments', ['uses' => 'CommentController@showSinglePostComments']);
//7
$router->get('comments/{commentId}', ['uses' => 'CommentController@showOneComment']);
//8
$router->post('comments', ['middleware' => ['auth'], 'uses' => 'CommentController@newComment']);
//9
$router->put('comments/{commentId}', ['middleware' => ['auth'], 'uses' => 'CommentController@editComment']);
//10
$router->delete('comments/{commentId}', ['middleware' => ['auth'], 'uses' => 'CommentController@deleteComment']);
//11
$router->post('auth/register', ['uses' => 'UserController@addUser']);
//12
$router->post('auth/login', ['uses' => 'UserController@loginUser']);
