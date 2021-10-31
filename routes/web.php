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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/','ProductController@index');
Route::get('/create','ProductController@create');
Route::post('/books','ProductController@store');

Route::name('product.')
      ->group(function () {
          Route::get('/product/index','ProductController@index')->name('index');
          Route::get('/product/{id}', 'ProductController@show')->name('show');
      });
    
Route::get('users/{users}/show','UserController@show')->name('users.show');
Route::post('/cart/create','CartController@store')->name('cart.create');
Route::get('/cart/index','CartController@index')->name('cart.index');
Route::get('/cart/checkout','CartController@checkout')->name('cart.checkout');
Route::delete('/cart/{cart}','CartController@destroy');