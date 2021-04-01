<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Image;


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/usuario/update', 'UserController@update')->name('user.update');
Route::get('/usuario/avatar/{filename}', 'UserController@getImage')->name('user.avatar');
Route::get('/usuario/profile/{user_id}', 'UserController@profile')->name('user.profile');
Route::get('/usuarios/{search?}', 'UserController@users')->name('user.users');

Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image/detalle/{id}', 'ImageController@detail')->name('image.detail');
Route::get('/image/delete/{image_id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{image_id}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update/', 'ImageController@update')->name('image.update');

Route::post('/comment/create', 'CommentController@create')->name('comment.create');
Route::get('/comment/delete/{id}', 'CommentController@deleteById')->name('comment.delete');

Route::get('/like/{id}', 'LikeController@like')->name('like.like');
Route::get('/likes', 'LikeController@index')->name('like.likes');



