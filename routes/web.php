<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

//AUTHENTICATION
Route::post('/login', 'App\Http\Controllers\AuthController@login');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

//USER
Route::post('/signin', 'App\Http\Controllers\UserController@createUser');
Route::post('/edit_profile', 'App\Http\Controllers\UserController@editUser');
Route::post('/change_password', 'App\Http\Controllers\UserController@changePassword');
Route::get('/delete_account', 'App\Http\Controllers\UserController@deleteUser');

//PRODUCT
Route::post('/product/create', 'App\Http\Controllers\ProductController@createProduct');
Route::post('/product/edit/{id}', 'App\Http\Controllers\ProductController@editProduct');
Route::get('/product/{id}', 'App\Http\Controllers\ProductController@readProduct');
Route::get('/product/delete/{id}', 'App\Http\Controllers\ProductController@deleteProduct');
Route::get('/products', 'App\Http\Controllers\ProductController@listProducts');