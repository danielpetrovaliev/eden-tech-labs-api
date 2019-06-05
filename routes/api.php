<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/posts', 'PostController@index')->name('posts.index');
Route::post('/posts', 'PostController@store')->name('posts.store')->middleware('api.authorization');
Route::get('/posts/{post}', 'PostController@show')->name('posts.show');
Route::delete('/posts/{post}', 'PostController@destroy')->name('posts.destroy');
Route::post('/posts/{post}/upvote', 'PostController@upVote')->name('posts.upvote');

Route::post('/authorize', 'AuthorizationController@auth');
Route::get('/whoAmI', 'AuthorizationController@whoAmI');

