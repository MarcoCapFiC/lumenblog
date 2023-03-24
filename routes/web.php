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

//1, 2, 3, 4, 5
$router->group(['prefix' => 'posts'], function () use ($router) {

    $router->get('', ['uses' => 'PostController@showAllPosts']);
    $router->get('{postId}', ['uses' => 'PostController@showOnePost']);

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->post('', ['uses' => 'PostController@newPost']);
        $router->put('{postId}', ['uses' => 'PostController@editPost']);
        $router->delete('{postId}', ['uses' => 'PostController@deletePost']);
    });
});

//6, 7, 8, 9, 10
$router->group(['prefix' => 'comments'], function () use ($router) {

    $router->get('', ['uses' => 'CommentController@showSinglePostComments']);
    $router->get('{commentId}', ['uses' => 'CommentController@showOneComment']);

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->post('', ['uses' => 'CommentController@newComment']);
        $router->put('{commentId}', ['uses' => 'CommentController@editComment']);
        $router->delete('{commentId}', ['uses' => 'CommentController@deleteComment']);
    });
});

//11, 12
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('register', ['uses' => 'UserController@addUser']);
    $router->post('login', ['uses' => 'UserController@loginUser']);
});

$router->group(['prefix' => 'likes'], function () use ($router) {

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->post('', ['uses' => 'LikeController@newLike']);
        $router->delete('{likeId}', ['uses' => 'LikeController@deleteLike']);
    });
});
