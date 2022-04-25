<?php

use Illuminate\Support\Facades\Route;

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

//CATEGORY
Route::post('/category/create', 'App\Http\Controllers\CategoryController@createCategory');
Route::post('/category/edit/{id}', 'App\Http\Controllers\CategoryController@editCategory');
Route::get('/category/delete/{id}', 'App\Http\Controllers\CategoryController@deleteCategory');
Route::get('/categories', 'App\Http\Controllers\CategoryController@listCategories');

//MARK
Route::post('/product/mark/create/{product_id}', 'App\Http\Controllers\MarkController@createMark');
Route::get('/product/mark/{id}', 'App\Http\Controllers\MarkController@getMark');
Route::get('/product/marks/{product_id}', 'App\Http\Controllers\MarkController@getMarks');
Route::post('/product/mark/{id}', 'App\Http\Controllers\MarkController@editMark');
Route::get('/product/delete/{id}', 'App\Http\Controllers\MarkController@deleteMark');